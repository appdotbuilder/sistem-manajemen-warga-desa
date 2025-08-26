import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface JenisSurat {
    nama_surat: string;
}

interface Pemohon {
    nama_lengkap: string;
    nik: string;
}

interface Surat {
    id: number;
    nomor_surat: string;
    status: string;
    keperluan: string;
    jenis_surat: JenisSurat;
    pemohon: Pemohon;
    created_at: string;
}

interface PaginatedSurats {
    data: Surat[];
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
    current_page: number;
    last_page: number;
    total: number;
}

interface Props {
    surats: PaginatedSurats;
    filters: {
        search?: string;
        status?: string;
    };
    userRole: string;
    [key: string]: unknown;
}

export default function SuratsIndex({ surats, filters, userRole }: Props) {
    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        const formData = new FormData(e.target as HTMLFormElement);
        const search = formData.get('search') as string;
        const status = formData.get('status') as string;
        
        router.get(route('surats.index'), {
            search: search || undefined,
            status: status || undefined,
        }, {
            preserveState: true,
        });
    };

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

    return (
        <AppShell>
            <Head title="Manajemen Surat" />
            
            <div className="p-6">
                {/* Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">📄 Manajemen Surat</h1>
                        <p className="text-gray-600">Kelola semua permohonan surat menyurat</p>
                    </div>
                    {(userRole === 'warga' || userRole === 'admin_desa' || userRole === 'ketua_rt') && (
                        <Link href={route('surats.create')}>
                            <Button className="bg-blue-600 hover:bg-blue-700 mt-4 sm:mt-0">
                                📝 Ajukan Surat
                            </Button>
                        </Link>
                    )}
                </div>

                {/* Filters */}
                <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-4">
                        <div className="flex-1">
                            <input
                                type="text"
                                name="search"
                                placeholder="Cari nomor surat atau nama pemohon..."
                                defaultValue={filters.search || ''}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <select 
                            name="status" 
                            defaultValue={filters.status || ''}
                            className="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="diajukan">Diajukan</option>
                            <option value="verifikasi_rt">Verifikasi RT</option>
                            <option value="menunggu_approval">Menunggu Approval</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        <Button type="submit" className="bg-gray-600 hover:bg-gray-700">
                            🔍 Cari
                        </Button>
                    </form>
                </div>

                {/* Results Info */}
                <div className="flex items-center justify-between mb-4">
                    <p className="text-sm text-gray-600">
                        Menampilkan {surats.data.length} dari {surats.total} surat
                    </p>
                </div>

                {/* Surats List */}
                <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    {surats.data.length > 0 ? (
                        <div className="divide-y divide-gray-200">
                            {surats.data.map((surat) => (
                                <div key={surat.id} className="p-6 hover:bg-gray-50 transition-colors">
                                    <div className="flex items-start justify-between">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-3 mb-2">
                                                <h3 className="font-semibold text-gray-900">
                                                    {surat.jenis_surat.nama_surat}
                                                </h3>
                                                <span className={`px-2 py-1 rounded-full text-xs font-medium ${statusColors[surat.status]}`}>
                                                    {statusLabels[surat.status]}
                                                </span>
                                            </div>
                                            <div className="space-y-1 text-sm text-gray-600">
                                                <p><span className="font-medium">No. Surat:</span> {surat.nomor_surat}</p>
                                                {userRole !== 'warga' && (
                                                    <p><span className="font-medium">Pemohon:</span> {surat.pemohon.nama_lengkap} ({surat.pemohon.nik})</p>
                                                )}
                                                <p><span className="font-medium">Keperluan:</span> {surat.keperluan}</p>
                                                <p><span className="font-medium">Tanggal:</span> {new Date(surat.created_at).toLocaleDateString('id-ID')}</p>
                                            </div>
                                        </div>
                                        <div className="ml-4">
                                            <Link href={route('surats.show', surat.id)}>
                                                <Button size="sm" className="bg-blue-600 hover:bg-blue-700">
                                                    👁️ Lihat Detail
                                                </Button>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">📄</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">Tidak ada surat</h3>
                            <p className="text-gray-600 mb-4">
                                {filters.search || filters.status
                                    ? 'Tidak ada surat yang sesuai dengan filter yang dipilih.'
                                    : 'Belum ada permohonan surat yang diajukan.'
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

                {/* Pagination */}
                {surats.links && surats.links.length > 3 && (
                    <div className="flex items-center justify-center gap-2 mt-8">
                        {surats.links.map((link, index) => (
                            <button
                                key={index}
                                onClick={() => link.url && router.visit(link.url)}
                                disabled={!link.url}
                                className={`px-3 py-2 text-sm rounded-lg transition-colors ${
                                    link.active
                                        ? 'bg-blue-600 text-white'
                                        : link.url
                                        ? 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'
                                        : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                }`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </div>
                )}
            </div>
        </AppShell>
    );
}