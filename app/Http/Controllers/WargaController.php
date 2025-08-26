<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWargaRequest;
use App\Http\Requests\UpdateWargaRequest;
use App\Models\Desa;
use App\Models\Rt;
use App\Models\Warga;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Warga::with(['desa', 'rt']);
        
        // Filter based on user role
        if ($user->isAdminDesa() || $user->isKepala()) {
            $query->where('desa_id', $user->desa_id);
        } elseif ($user->isKetuaRt()) {
            $query->where('rt_id', $user->rt_id);
        } elseif ($user->isWarga()) {
            // Warga can only see their own data
            return redirect()->route('profile.edit');
        }
        
        // Search functionality
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by RT
        if ($request->rt_id) {
            $query->where('rt_id', $request->rt_id);
        }
        
        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $wargas = $query->latest()->paginate(15)->withQueryString();
        
        $rts = Rt::where('desa_id', $user->desa_id)->get();
        
        return Inertia::render('wargas/index', [
            'wargas' => $wargas,
            'rts' => $rts,
            'filters' => $request->only(['search', 'rt_id', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        
        if (!$user->isAdminDesa() && !$user->isSuperAdmin()) {
            abort(403);
        }
        
        $rts = Rt::where('desa_id', $user->desa_id)->get();
        
        return Inertia::render('wargas/create', [
            'rts' => $rts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWargaRequest $request)
    {
        $user = $request->user();
        
        if (!$user->isAdminDesa() && !$user->isSuperAdmin()) {
            abort(403);
        }
        
        $validated = $request->validated();
        $validated['desa_id'] = $user->desa_id;
        
        $warga = Warga::create($validated);
        
        return redirect()->route('wargas.show', $warga)
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Warga $warga)
    {
        $user = $request->user();
        
        // Authorization check
        if ($user->isWarga() && $user->warga_id !== $warga->id) {
            abort(403);
        } elseif ($user->isKetuaRt() && $user->rt_id !== $warga->rt_id) {
            abort(403);
        } elseif (($user->isAdminDesa() || $user->isKepala()) && $user->desa_id !== $warga->desa_id) {
            abort(403);
        }
        
        $warga->load(['desa', 'rt', 'surats.jenisSurat']);
        
        return Inertia::render('wargas/show', [
            'warga' => $warga,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Warga $warga)
    {
        $user = $request->user();
        
        if (!$user->isAdminDesa() && !$user->isSuperAdmin()) {
            abort(403);
        }
        
        if (($user->isAdminDesa() || $user->isKepala()) && $user->desa_id !== $warga->desa_id) {
            abort(403);
        }
        
        $rts = Rt::where('desa_id', $warga->desa_id)->get();
        
        return Inertia::render('wargas/edit', [
            'warga' => $warga,
            'rts' => $rts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWargaRequest $request, Warga $warga)
    {
        $user = $request->user();
        
        if (!$user->isAdminDesa() && !$user->isSuperAdmin()) {
            abort(403);
        }
        
        if (($user->isAdminDesa() || $user->isKepala()) && $user->desa_id !== $warga->desa_id) {
            abort(403);
        }
        
        $warga->update($request->validated());
        
        return redirect()->route('wargas.show', $warga)
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Warga $warga)
    {
        $user = $request->user();
        
        if (!$user->isAdminDesa() && !$user->isSuperAdmin()) {
            abort(403);
        }
        
        if (($user->isAdminDesa() || $user->isKepala()) && $user->desa_id !== $warga->desa_id) {
            abort(403);
        }
        
        $warga->delete();
        
        return redirect()->route('wargas.index')
            ->with('success', 'Data warga berhasil dihapus.');
    }
}