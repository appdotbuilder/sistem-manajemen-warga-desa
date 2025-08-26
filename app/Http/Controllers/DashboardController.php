<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Surat;
use App\Models\Warga;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $stats = [];
        $recentActivity = [];
        $beritas = [];

        if ($user->isSuperAdmin()) {
            $stats = [
                'total_desas' => \App\Models\Desa::aktif()->count(),
                'total_wargas' => Warga::aktif()->count(),
                'total_surats' => Surat::count(),
                'pending_surats' => Surat::whereIn('status', ['diajukan', 'verifikasi_rt', 'menunggu_approval'])->count(),
            ];
        } elseif ($user->isAdminDesa() || $user->isKepala()) {
            $stats = [
                'total_wargas' => Warga::where('desa_id', $user->desa_id)->aktif()->count(),
                'total_surats' => Surat::where('desa_id', $user->desa_id)->count(),
                'pending_surats' => Surat::where('desa_id', $user->desa_id)
                    ->whereIn('status', ['diajukan', 'verifikasi_rt', 'menunggu_approval'])->count(),
                'completed_surats' => Surat::where('desa_id', $user->desa_id)
                    ->where('status', 'selesai')->count(),
            ];
            
            $beritas = Berita::where('desa_id', $user->desa_id)
                ->published()
                ->latest('published_at')
                ->take(5)
                ->get();
        } elseif ($user->isKetuaRt()) {
            $stats = [
                'total_wargas' => Warga::where('rt_id', $user->rt_id)->aktif()->count(),
                'pending_verification' => Surat::where('rt_id', $user->rt_id)
                    ->where('status', 'verifikasi_rt')->count(),
                'verified_surats' => Surat::where('rt_id', $user->rt_id)
                    ->where('diverifikasi_oleh', $user->id)->count(),
            ];
        } elseif ($user->isWarga()) {
            $stats = [
                'my_surats' => Surat::where('pemohon_id', $user->warga_id)->count(),
                'pending_surats' => Surat::where('pemohon_id', $user->warga_id)
                    ->whereIn('status', ['diajukan', 'verifikasi_rt', 'menunggu_approval'])->count(),
                'completed_surats' => Surat::where('pemohon_id', $user->warga_id)
                    ->where('status', 'selesai')->count(),
            ];
            
            $beritas = Berita::where('desa_id', $user->desa_id)
                ->published()
                ->latest('published_at')
                ->take(10)
                ->get();
                
            $recentActivity = Surat::where('pemohon_id', $user->warga_id)
                ->with(['jenisSurat'])
                ->latest()
                ->take(5)
                ->get();
        }

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'beritas' => $beritas,
            'recentActivity' => $recentActivity,
            'userRole' => $user->role,
        ]);
    }
}