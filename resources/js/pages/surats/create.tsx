import React from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface JenisSurat {
    id: number;
    nama_surat: string;
    kode_surat: string;
    deskripsi: string;
    estimasi_hari: number;
    biaya: number;
}

interface Props {
    jenisSurats: JenisSurat[];
    [key: string]: unknown;
}

export default function CreateSurat({ jenisSurats }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        jenis_surat_id: '',
        keperluan: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('surats.store'));
    };

    const selectedJenis = jenisSurats.find(j => j.id.toString() === data.jenis_surat_id);

    return (
        <AppShell>
            <Head title="Ajukan Surat" />
            
            <div className="p-6">
                {/* Header */}
                <div className="flex items-center gap-4 mb-8">
                    <Link href={route('surats.index')}>
                        <Button variant="outline" size="sm">
                            ← Kembali
                        </Button>
                    </Link>
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">📝 Ajukan Surat Baru</h1>
                        <p className="text-gray-600">Ajukan permohonan surat sesuai kebutuhan Anda</p>
                    </div>
                </div>

                <div className="grid lg:grid-cols-3 gap-8">
                    {/* Form */}
                    <div className="lg:col-span-2">
                        <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <form onSubmit={handleSubmit} className="space-y-6">
                                {/* Jenis Surat */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Jenis Surat <span className="text-red-500">*</span>
                                    </label>
                                    <select
                                        value={data.jenis_surat_id}
                                        onChange={e => setData('jenis_surat_id', e.target.value)}
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required
                                    >
                                        <option value="">Pilih Jenis Surat</option>
                                        {jenisSurats.map((jenis) => (
                                            <option key={jenis.id} value={jenis.id}>
                                                {jenis.nama_surat}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.jenis_surat_id && <p className="text-red-500 text-sm mt-1">{errors.jenis_surat_id}</p>}
                                </div>

                                {/* Keperluan */}
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-2">
                                        Keperluan Surat <span className="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        value={data.keperluan}
                                        onChange={e => setData('keperluan', e.target.value)}
                                        rows={4}
                                        placeholder="Jelaskan keperluan surat dengan detail..."
                                        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required
                                    />
                                    {errors.keperluan && <p className="text-red-500 text-sm mt-1">{errors.keperluan}</p>}
                                </div>

                                {/* Submit */}
                                <div className="flex gap-4 pt-6">
                                    <Link href={route('surats.index')}>
                                        <Button type="button" variant="outline">
                                            Batal
                                        </Button>
                                    </Link>
                                    <Button 
                                        type="submit" 
                                        disabled={processing}
                                        className="bg-blue-600 hover:bg-blue-700"
                                    >
                                        {processing ? '⏳ Mengajukan...' : '📝 Ajukan Surat'}
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Selected Surat Info */}
                        {selectedJenis && (
                            <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <h3 className="font-semibold text-gray-900 mb-4">📋 Informasi Surat</h3>
                                <div className="space-y-3 text-sm">
                                    <div>
                                        <span className="font-medium text-gray-700">Nama Surat:</span>
                                        <p className="text-gray-600">{selectedJenis.nama_surat}</p>
                                    </div>
                                    <div>
                                        <span className="font-medium text-gray-700">Kode:</span>
                                        <p className="text-gray-600">{selectedJenis.kode_surat}</p>
                                    </div>
                                    <div>
                                        <span className="font-medium text-gray-700">Deskripsi:</span>
                                        <p className="text-gray-600">{selectedJenis.deskripsi}</p>
                                    </div>
                                    <div>
                                        <span className="font-medium text-gray-700">Estimasi Proses:</span>
                                        <p className="text-gray-600">{selectedJenis.estimasi_hari} hari kerja</p>
                                    </div>
                                    <div>
                                        <span className="font-medium text-gray-700">Biaya:</span>
                                        <p className="text-gray-600">
                                            {selectedJenis.biaya > 0 
                                                ? `Rp ${selectedJenis.biaya.toLocaleString('id-ID')}` 
                                                : 'Gratis'
                                            }
                                        </p>
                                    </div>
                                </div>
                            </div>
                        )}

                        {/* Process Flow */}
                        <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 className="font-semibold text-gray-900 mb-4">🔄 Alur Proses</h3>
                            <div className="space-y-4">
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-medium">
                                        1
                                    </div>
                                    <div>
                                        <p className="font-medium text-gray-900">Pengajuan</p>
                                        <p className="text-xs text-gray-600">Warga mengajukan surat</p>
                                    </div>
                                </div>
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm font-medium">
                                        2
                                    </div>
                                    <div>
                                        <p className="font-medium text-gray-900">Verifikasi RT</p>
                                        <p className="text-xs text-gray-600">Ketua RT memverifikasi</p>
                                    </div>
                                </div>
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-medium">
                                        3
                                    </div>
                                    <div>
                                        <p className="font-medium text-gray-900">Approval Kades</p>
                                        <p className="text-xs text-gray-600">Kepala Desa menyetujui</p>
                                    </div>
                                </div>
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-medium">
                                        4
                                    </div>
                                    <div>
                                        <p className="font-medium text-gray-900">Selesai</p>
                                        <p className="text-xs text-gray-600">Surat dapat diambil</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}