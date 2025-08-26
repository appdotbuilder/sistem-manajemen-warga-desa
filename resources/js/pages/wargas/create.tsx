import React from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface Rt {
    id: number;
    nomor_rt: string;
    nomor_rw: string;
}

interface Props {
    rts: Rt[];
    [key: string]: unknown;
}

export default function CreateWarga({ rts }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        rt_id: '',
        nama_lengkap: '',
        nik: '',
        alamat: '',
        tanggal_lahir: '',
        jenis_kelamin: '',
        pekerjaan: '',
        status_pernikahan: '',
        agama: '',
        pendidikan: '',
        telepon: '',
        email: '',
        nomor_kk: '',
        status_dalam_keluarga: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('wargas.store'));
    };

    return (
        <AppShell>
            <Head title="Tambah Warga" />
            
            <div className="p-6">
                {/* Header */}
                <div className="flex items-center gap-4 mb-8">
                    <Link href={route('wargas.index')}>
                        <Button variant="outline" size="sm">
                            ← Kembali
                        </Button>
                    </Link>
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">👤 Tambah Warga Baru</h1>
                        <p className="text-gray-600">Daftarkan warga baru ke dalam sistem</p>
                    </div>
                </div>

                {/* Form */}
                <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* RT/RW Selection */}
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                RT/RW <span className="text-red-500">*</span>
                            </label>
                            <select
                                value={data.rt_id}
                                onChange={e => setData('rt_id', e.target.value)}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                                <option value="">Pilih RT/RW</option>
                                {rts.map((rt) => (
                                    <option key={rt.id} value={rt.id}>
                                        RT {rt.nomor_rt} / RW {rt.nomor_rw}
                                    </option>
                                ))}
                            </select>
                            {errors.rt_id && <p className="text-red-500 text-sm mt-1">{errors.rt_id}</p>}
                        </div>

                        {/* Basic Info */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    value={data.nama_lengkap}
                                    onChange={e => setData('nama_lengkap', e.target.value)}
                                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                {errors.nama_lengkap && <p className="text-red-500 text-sm mt-1">{errors.nama_lengkap}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    NIK <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    maxLength={16}
                                    value={data.nik}
                                    onChange={e => setData('nik', e.target.value)}
                                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="16 digit NIK"
                                    required
                                />
                                {errors.nik && <p className="text-red-500 text-sm mt-1">{errors.nik}</p>}
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap <span className="text-red-500">*</span>
                            </label>
                            <textarea
                                value={data.alamat}
                                onChange={e => setData('alamat', e.target.value)}
                                rows={3}
                                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            />
                            {errors.alamat && <p className="text-red-500 text-sm mt-1">{errors.alamat}</p>}
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    value={data.tanggal_lahir}
                                    onChange={e => setData('tanggal_lahir', e.target.value)}
                                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                {errors.tanggal_lahir && <p className="text-red-500 text-sm mt-1">{errors.tanggal_lahir}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin <span className="text-red-500">*</span>
                                </label>
                                <select
                                    value={data.jenis_kelamin}
                                    onChange={e => setData('jenis_kelamin', e.target.value)}
                                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                {errors.jenis_kelamin && <p className="text-red-500 text-sm mt-1">{errors.jenis_kelamin}</p>}
                            </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Pekerjaan <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    value={data.pekerjaan}
                                    onChange={e => setData('pekerjaan', e.target.value)}
                                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                {errors.pekerjaan && <p className="text-red-500 text-sm mt-1">{errors.pekerjaan}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Status Pernikahan <span className="text-red-500">*</span>
                                </label>
                                <select
                                    value={data.status_pernikahan}
                                    onChange={e => setData('status_pernikahan', e.target.value)}
                                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                    <option value="">Pilih Status Pernikahan</option>
                                    <option value="belum_menikah">Belum Menikah</option>
                                    <option value="menikah">Menikah</option>
                                    <option value="cerai_hidup">Cerai Hidup</option>
                                    <option value="cerai_mati">Cerai Mati</option>
                                </select>
                                {errors.status_pernikahan && <p className="text-red-500 text-sm mt-1">{errors.status_pernikahan}</p>}
                            </div>
                        </div>

                        {/* Submit */}
                        <div className="flex gap-4 pt-6">
                            <Link href={route('wargas.index')}>
                                <Button type="button" variant="outline">
                                    Batal
                                </Button>
                            </Link>
                            <Button 
                                type="submit" 
                                disabled={processing}
                                className="bg-blue-600 hover:bg-blue-700"
                            >
                                {processing ? '⏳ Menyimpan...' : '💾 Simpan Warga'}
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </AppShell>
    );
}