import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface Rt {
    id: number;
    nomor_rt: string;
    nomor_rw: string;
}

interface Warga {
    id: number;
    nama_lengkap: string;
    nik: string;
    alamat: string;
    jenis_kelamin: string;
    pekerjaan: string;
    status: string;
    rt: {
        nomor_rt: string;
        nomor_rw: string;
    };
    tanggal_lahir: string;
}

interface PaginatedWargas {
    data: Warga[];
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
    wargas: PaginatedWargas;
    rts: Rt[];
    filters: {
        search?: string;
        rt_id?: string;
        status?: string;
    };
    [key: string]: unknown;
}

export default function WargasIndex({ wargas, rts, filters }: Props) {
    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        const formData = new FormData(e.target as HTMLFormElement);
        const search = formData.get('search') as string;
        const rt_id = formData.get('rt_id') as string;
        const status = formData.get('status') as string;
        
        router.get(route('wargas.index'), {
            search: search || undefined,
            rt_id: rt_id || undefined,
            status: status || undefined,
        }, {
            preserveState: true,
        });
    };

    const statusColors: Record<string, string> = {
        'aktif': 'bg-green-100 text-green-800',
        'pindah': 'bg-yellow-100 text-yellow-800',
        'meninggal': 'bg-red-100 text-red-800',
    };

    const genderIcons: Record<string, string> = {
        'laki-laki': '👨',
        'perempuan': '👩',
    };

    return (
        <AppShell>
            <Head title="Data Warga" />
            
            <div className="p-6">
                {/* Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">👥 Data Warga</h1>
                        <p className="text-gray-600">Kelola data penduduk desa secara terpusat</p>
                    </div>
                    <Link href={route('wargas.create')}>
                        <Button className="bg-blue-600 hover:bg-blue-700 mt-4 sm:mt-0">
                            ➕ Tambah Warga
                        </Button>
                    </Link>
                </div>

                {/* Filters */}
                <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-4">
                        <div className="flex-1">
                            <input
                                type="text"
                                name="search"
                                placeholder="Cari nama atau NIK..."
                                defaultValue={filters.search || ''}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <select 
                            name="rt_id" 
                            defaultValue={filters.rt_id || ''}
                            className="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Semua RT/RW</option>
                            {rts.map((rt) => (
                                <option key={rt.id} value={rt.id}>
                                    RT {rt.nomor_rt} / RW {rt.nomor_rw}
                                </option>
                            ))}
                        </select>
                        <select 
                            name="status" 
                            defaultValue={filters.status || ''}
                            className="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="pindah">Pindah</option>
                            <option value="meninggal">Meninggal</option>
                        </select>
                        <Button type="submit" className="bg-gray-600 hover:bg-gray-700">
                            🔍 Cari
                        </Button>
                    </form>
                </div>

                {/* Results Info */}
                <div className="flex items-center justify-between mb-4">
                    <p className="text-sm text-gray-600">
                        Menampilkan {wargas.data.length} dari {wargas.total} warga
                    </p>
                </div>

                {/* Warga Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {wargas.data.map((warga) => (
                        <div key={warga.id} className="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div className="flex items-start justify-between mb-4">
                                <div className="flex items-center gap-3">
                                    <span className="text-3xl">{genderIcons[warga.jenis_kelamin]}</span>
                                    <div>
                                        <h3 className="font-semibold text-gray-900">{warga.nama_lengkap}</h3>
                                        <p className="text-sm text-gray-600">NIK: {warga.nik}</p>
                                    </div>
                                </div>
                                <span className={`px-2 py-1 rounded-full text-xs font-medium ${statusColors[warga.status]}`}>
                                    {warga.status}
                                </span>
                            </div>

                            <div className="space-y-2 mb-4">
                                <div className="flex items-center gap-2 text-sm text-gray-600">
                                    <span>🏘️</span>
                                    <span>RT {warga.rt.nomor_rt} / RW {warga.rt.nomor_rw}</span>
                                </div>
                                <div className="flex items-center gap-2 text-sm text-gray-600">
                                    <span>📍</span>
                                    <span className="truncate">{warga.alamat}</span>
                                </div>
                                <div className="flex items-center gap-2 text-sm text-gray-600">
                                    <span>💼</span>
                                    <span>{warga.pekerjaan}</span>
                                </div>
                                <div className="flex items-center gap-2 text-sm text-gray-600">
                                    <span>📅</span>
                                    <span>{new Date(warga.tanggal_lahir).toLocaleDateString('id-ID')}</span>
                                </div>
                            </div>

                            <div className="flex gap-2">
                                <Link href={route('wargas.show', warga.id)} className="flex-1">
                                    <Button variant="outline" size="sm" className="w-full">
                                        👁️ Lihat
                                    </Button>
                                </Link>
                                <Link href={route('wargas.edit', warga.id)} className="flex-1">
                                    <Button size="sm" className="w-full bg-blue-600 hover:bg-blue-700">
                                        ✏️ Edit
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Empty State */}
                {wargas.data.length === 0 && (
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">👥</div>
                        <h3 className="text-lg font-semibold text-gray-900 mb-2">Tidak ada data warga</h3>
                        <p className="text-gray-600 mb-4">
                            {filters.search || filters.rt_id || filters.status
                                ? 'Tidak ada warga yang sesuai dengan filter yang dipilih.'
                                : 'Belum ada data warga yang terdaftar.'
                            }
                        </p>
                        <Link href={route('wargas.create')}>
                            <Button className="bg-blue-600 hover:bg-blue-700">
                                ➕ Tambah Warga Pertama
                            </Button>
                        </Link>
                    </div>
                )}

                {/* Pagination */}
                {wargas.links && wargas.links.length > 3 && (
                    <div className="flex items-center justify-center gap-2 mt-8">
                        {wargas.links.map((link, index) => (
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