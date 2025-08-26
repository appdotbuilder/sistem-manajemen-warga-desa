import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface Stats {
    [key: string]: number;
}

interface Berita {
    id: number;
    judul: string;
    ringkasan: string;
    kategori: string;
    published_at: string;
    views_count: number;
}

interface RecentActivity {
    id: number;
    nomor_surat: string;
    status: string;
    jenis_surat: {
        nama_surat: string;
    };
    created_at: string;
}

interface Props {
    stats: Stats;
    beritas: Berita[];
    recentActivity: RecentActivity[];
    userRole: string;
    [key: string]: unknown;
}

const statusColors: Record<string, string> = {
    'draft': 'bg-gray-100 text-gray-800',
    'diajukan': 'bg-blue-100 text-blue-800',
    'verifikasi_rt': 'bg-yellow-100 text-yellow-800',
    'menunggu_approval': 'bg-orange-100 text-orange-800',
    'disetujui': 'bg-green-100 text-green-800',
    'ditolak': 'bg-red-100 text-red-800',
    'selesai': 'bg-purple-100 text-purple-800',
};

const statusLabels: Record<string, string> = {
    'draft': 'Draft',
    'diajukan': 'Diajukan',
    'verifikasi_rt': 'Verifikasi RT',
    'menunggu_approval': 'Menunggu Approval',
    'disetujui': 'Disetujui',
    'ditolak': 'Ditolak',
    'selesai': 'Selesai',
};

const kategoriIcons: Record<string, string> = {
    'pengumuman': '📢',
    'kegiatan': '🎉',
    'berita': '📰',
    'informasi': 'ℹ️',
};

const roleLabels: Record<string, string> = {
    'super_admin': 'Super Admin',
    'admin_desa': 'Admin Desa', 
    'kepala_desa': 'Kepala Desa',
    'ketua_rt': 'Ketua RT',
    'warga': 'Warga',
};

export default function Dashboard({ stats, beritas, recentActivity, userRole }: Props) {
    const renderStatCards = () => {
        const statCards = [];
        
        if (userRole === 'super_admin') {
            statCards.push(
                { key: 'total_desas', label: 'Total Desa', icon: '🏛️', color: 'from-blue-500 to-blue-600' },
                { key: 'total_wargas', label: 'Total Warga', icon: '👥', color: 'from-green-500 to-green-600' },
                { key: 'total_surats', label: 'Total Surat', icon: '📄', color: 'from-purple-500 to-purple-600' },
                { key: 'pending_surats', label: 'Surat Pending', icon: '⏳', color: 'from-orange-500 to-orange-600' }
            );
        } else if (userRole === 'admin_desa' || userRole === 'kepala_desa') {
            statCards.push(
                { key: 'total_wargas', label: 'Total Warga', icon: '👥', color: 'from-blue-500 to-blue-600' },
                { key: 'total_surats', label: 'Total Surat', icon: '📄', color: 'from-green-500 to-green-600' },
                { key: 'pending_surats', label: 'Surat Pending', icon: '⏳', color: 'from-orange-500 to-orange-600' },
                { key: 'completed_surats', label: 'Surat Selesai', icon: '✅', color: 'from-purple-500 to-purple-600' }
            );
        } else if (userRole === 'ketua_rt') {
            statCards.push(
                { key: 'total_wargas', label: 'Warga RT', icon: '👥', color: 'from-blue-500 to-blue-600' },
                { key: 'pending_verification', label: 'Perlu Verifikasi', icon: '🔍', color: 'from-orange-500 to-orange-600' },
                { key: 'verified_surats', label: 'Surat Terverifikasi', icon: '✅', color: 'from-green-500 to-green-600' }
            );
        } else if (userRole === 'warga') {
            statCards.push(
                { key: 'my_surats', label: 'Surat Saya', icon: '📄', color: 'from-blue-500 to-blue-600' },
                { key: 'pending_surats', label: 'Surat Pending', icon: '⏳', color: 'from-orange-500 to-orange-600' },
                { key: 'completed_surats', label: 'Surat Selesai', icon: '✅', color: 'from-green-500 to-green-600' }
            );
        }
        
        return statCards;
    };

    return (
        <AppShell>
            <Head title="Dashboard" />
            
            <div className="p-6">
                {/* Header */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        👋 Selamat Datang, {roleLabels[userRole]}!
                    </h1>
                    <p className="text-gray-600">
                        Dashboard sistem manajemen warga desa - kelola semua aktivitas dari sini.
                    </p>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    {renderStatCards().map((card) => (
                        <div key={card.key} className={`bg-gradient-to-r ${card.color} rounded-xl p-6 text-white`}>
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-white/80 text-sm font-medium">{card.label}</p>
                                    <p className="text-3xl font-bold mt-1">{stats[card.key] || 0}</p>
                                </div>
                                <div className="text-4xl opacity-80">{card.icon}</div>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Main Content Grid */}
                <div className="grid lg:grid-cols-3 gap-8">
                    {/* Quick Actions */}
                    <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 className="text-xl font-semibold text-gray-900 mb-4">🚀 Aksi Cepat</h2>
                        <div className="space-y-3">
                            {userRole === 'warga' && (
                                <>
                                    <Link href={route('surats.create')}>
                                        <Button className="w-full justify-start bg-blue-600 hover:bg-blue-700">
                                            📝 Ajukan Surat
                                        </Button>
                                    </Link>
                                    <Link href={route('surats.index')}>
                                        <Button variant="outline" className="w-full justify-start">
                                            📋 Lihat Status Surat
                                        </Button>
                                    </Link>
                                </>
                            )}
                            
                            {(userRole === 'admin_desa' || userRole === 'super_admin') && (
                                <>
                                    <Link href={route('wargas.create')}>
                                        <Button className="w-full justify-start bg-green-600 hover:bg-green-700">
                                            👤 Tambah Warga
                                        </Button>
                                    </Link>
                                    <Link href={route('wargas.index')}>
                                        <Button variant="outline" className="w-full justify-start">
                                            👥 Kelola Warga
                                        </Button>
                                    </Link>
                                </>
                            )}
                            
                            {userRole === 'ketua_rt' && (
                                <>
                                    <Link href={route('surats.index', { status: 'verifikasi_rt' })}>
                                        <Button className="w-full justify-start bg-orange-600 hover:bg-orange-700">
                                            🔍 Verifikasi Surat
                                        </Button>
                                    </Link>
                                    <Link href={route('wargas.index')}>
                                        <Button variant="outline" className="w-full justify-start">
                                            👥 Data Warga RT
                                        </Button>
                                    </Link>
                                </>
                            )}
                            
                            {userRole === 'kepala_desa' && (
                                <>
                                    <Link href={route('surats.index', { status: 'menunggu_approval' })}>
                                        <Button className="w-full justify-start bg-purple-600 hover:bg-purple-700">
                                            ✅ Approval Surat
                                        </Button>
                                    </Link>
                                    <Link href={route('surats.index')}>
                                        <Button variant="outline" className="w-full justify-start">
                                            📊 Laporan Surat
                                        </Button>
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>

                    {/* Recent Activity / Berita */}
                    <div className="lg:col-span-2">
                        {userRole === 'warga' && recentActivity.length > 0 ? (
                            <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <div className="flex items-center justify-between mb-4">
                                    <h2 className="text-xl font-semibold text-gray-900">📋 Aktivitas Terbaru</h2>
                                    <Link href={route('surats.index')}>
                                        <Button variant="outline" size="sm">Lihat Semua</Button>
                                    </Link>
                                </div>
                                <div className="space-y-4">
                                    {recentActivity.map((activity) => (
                                        <div key={activity.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <div className="flex-1">
                                                <h3 className="font-medium text-gray-900">{activity.jenis_surat.nama_surat}</h3>
                                                <p className="text-sm text-gray-600">No: {activity.nomor_surat}</p>
                                                <p className="text-xs text-gray-500">
                                                    {new Date(activity.created_at).toLocaleDateString('id-ID')}
                                                </p>
                                            </div>
                                            <span className={`px-2 py-1 rounded-full text-xs font-medium ${statusColors[activity.status]}`}>
                                                {statusLabels[activity.status]}
                                            </span>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        ) : beritas.length > 0 ? (
                            <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <h2 className="text-xl font-semibold text-gray-900 mb-4">📰 Berita & Pengumuman</h2>
                                <div className="space-y-4">
                                    {beritas.map((berita) => (
                                        <div key={berita.id} className="p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                                            <div className="flex items-start justify-between">
                                                <div className="flex-1">
                                                    <div className="flex items-center gap-2 mb-2">
                                                        <span className="text-lg">{kategoriIcons[berita.kategori]}</span>
                                                        <span className="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full font-medium">
                                                            {berita.kategori}
                                                        </span>
                                                    </div>
                                                    <h3 className="font-semibold text-gray-900 mb-1">{berita.judul}</h3>
                                                    <p className="text-sm text-gray-600 line-clamp-2">{berita.ringkasan}</p>
                                                    <div className="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                                        <span>📅 {new Date(berita.published_at).toLocaleDateString('id-ID')}</span>
                                                        <span>👁️ {berita.views_count} views</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        ) : (
                            <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                                <div className="text-6xl mb-4">📝</div>
                                <h3 className="text-lg font-semibold text-gray-900 mb-2">Belum Ada Aktivitas</h3>
                                <p className="text-gray-600 mb-4">
                                    {userRole === 'warga' 
                                        ? 'Mulai dengan mengajukan surat atau membaca berita desa.' 
                                        : 'Sistem siap digunakan untuk mengelola data dan layanan desa.'
                                    }
                                </p>
                                {userRole === 'warga' && (
                                    <Link href={route('surats.create')}>
                                        <Button className="bg-blue-600 hover:bg-blue-700">
                                            📝 Ajukan Surat Pertama
                                        </Button>
                                    </Link>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppShell>
    );
}