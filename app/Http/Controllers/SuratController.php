<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuratRequest;
use App\Http\Requests\UpdateSuratRequest;
use App\Models\JenisSurat;
use App\Models\Surat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Surat::with(['jenisSurat', 'pemohon', 'desa', 'rt']);
        
        // Filter based on user role
        if ($user->isWarga()) {
            $query->where('pemohon_id', $user->warga_id);
        } elseif ($user->isKetuaRt()) {
            $query->where('rt_id', $user->rt_id);
        } elseif ($user->isAdminDesa() || $user->isKepala()) {
            $query->where('desa_id', $user->desa_id);
        }
        
        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nomor_surat', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pemohon', function($subQ) use ($request) {
                      $subQ->where('nama_lengkap', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $surats = $query->latest()->paginate(15)->withQueryString();
        
        return Inertia::render('surats/index', [
            'surats' => $surats,
            'filters' => $request->only(['search', 'status']),
            'userRole' => $user->role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = $request->user();
        
        if (!$user->isWarga() && !$user->isAdminDesa() && !$user->isKetuaRt()) {
            abort(403);
        }
        
        $jenisSurats = JenisSurat::active()->get();
        
        return Inertia::render('surats/create', [
            'jenisSurats' => $jenisSurats,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuratRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();
        
        // Generate nomor surat
        $lastSurat = Surat::where('desa_id', $user->desa_id)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $nomorSurat = sprintf(
            '%03d/SK/%s/%d',
            $lastSurat + 1,
            $user->desa->kode_desa ?? 'DESA',
            now()->year
        );
        
        $validated['nomor_surat'] = $nomorSurat;
        $validated['desa_id'] = $user->desa_id;
        $validated['rt_id'] = $user->rt_id;
        
        if ($user->isWarga()) {
            $validated['pemohon_id'] = $user->warga_id;
            $validated['status'] = 'diajukan';
        } else {
            // For admin/ketua RT creating manual surat
            $validated['status'] = 'draft';
        }
        
        $surat = Surat::create($validated);
        
        return redirect()->route('surats.show', $surat)
            ->with('success', 'Permohonan surat berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Surat $surat)
    {
        $user = $request->user();
        
        // Authorization check
        if ($user->isWarga() && $user->warga_id !== $surat->pemohon_id) {
            abort(403);
        } elseif ($user->isKetuaRt() && $user->rt_id !== $surat->rt_id) {
            abort(403);
        } elseif (($user->isAdminDesa() || $user->isKepala()) && $user->desa_id !== $surat->desa_id) {
            abort(403);
        }
        
        $surat->load(['jenisSurat', 'pemohon', 'desa', 'rt', 'verifikator', 'approver']);
        
        return Inertia::render('surats/show', [
            'surat' => $surat,
            'userRole' => $user->role,
            'canVerify' => $user->isKetuaRt() && $surat->status === 'verifikasi_rt',
            'canApprove' => $user->isKepala() && $surat->status === 'menunggu_approval',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuratRequest $request, Surat $surat)
    {
        $user = $request->user();
        $validated = $request->validated();
        
        if ($request->action === 'verify' && $user->isKetuaRt()) {
            $validated['status'] = $request->approve ? 'menunggu_approval' : 'ditolak';
            $validated['diverifikasi_oleh'] = $user->id;
            $validated['tanggal_verifikasi'] = now();
            
            if (!$request->approve) {
                $validated['alasan_penolakan'] = $request->alasan_penolakan;
            }
        } elseif ($request->action === 'approve' && $user->isKepala()) {
            $validated['status'] = $request->approve ? 'disetujui' : 'ditolak';
            $validated['disetujui_oleh'] = $user->id;
            $validated['tanggal_persetujuan'] = now();
            
            if (!$request->approve) {
                $validated['alasan_penolakan'] = $request->alasan_penolakan;
            }
        }
        
        $surat->update($validated);
        
        $message = match($surat->status) {
            'menunggu_approval' => 'Surat berhasil diverifikasi dan diteruskan ke Kepala Desa.',
            'disetujui' => 'Surat berhasil disetujui.',
            'ditolak' => 'Surat telah ditolak.',
            default => 'Status surat berhasil diperbarui.',
        };
        
        return redirect()->route('surats.show', $surat)
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Surat $surat)
    {
        $user = $request->user();
        
        // Only allow deletion by admin or if it's a draft
        if (!$user->isAdminDesa() && !$user->isSuperAdmin()) {
            if ($surat->status !== 'draft' || $user->warga_id !== $surat->pemohon_id) {
                abort(403);
            }
        }
        
        $surat->delete();
        
        return redirect()->route('surats.index')
            ->with('success', 'Surat berhasil dihapus.');
    }
}