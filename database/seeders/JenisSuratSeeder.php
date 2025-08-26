<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $jenisSurats = [
            [
                'nama_surat' => 'Surat Keterangan Domisili',
                'kode_surat' => 'SKD',
                'deskripsi' => 'Surat keterangan yang menyatakan domisili seseorang',
                'template_surat' => 'Yang bertanda tangan di bawah ini, Kepala Desa {nama_desa}, Kecamatan {kecamatan}, Kabupaten {kabupaten}, dengan ini menerangkan bahwa: {data_warga} adalah benar-benar berdomisili di wilayah kami.',
                'field_required' => ['keperluan'],
                'perlu_verifikasi_rt' => true,
                'perlu_approval_kades' => true,
                'estimasi_hari' => 3,
                'biaya' => 5000.00,
                'is_active' => true,
            ],
            [
                'nama_surat' => 'Surat Pengantar',
                'kode_surat' => 'SP',
                'deskripsi' => 'Surat pengantar untuk berbagai keperluan',
                'template_surat' => 'Yang bertanda tangan di bawah ini, Kepala Desa {nama_desa}, dengan ini memberikan surat pengantar kepada: {data_warga} untuk keperluan {keperluan}.',
                'field_required' => ['keperluan', 'tujuan'],
                'perlu_verifikasi_rt' => true,
                'perlu_approval_kades' => true,
                'estimasi_hari' => 2,
                'biaya' => 3000.00,
                'is_active' => true,
            ],
            [
                'nama_surat' => 'Surat Keterangan Tidak Mampu',
                'kode_surat' => 'SKTM',
                'deskripsi' => 'Surat keterangan untuk keluarga tidak mampu',
                'template_surat' => 'Yang bertanda tangan di bawah ini, Kepala Desa {nama_desa}, menerangkan bahwa keluarga: {data_warga} adalah termasuk keluarga tidak mampu di wilayah kami.',
                'field_required' => ['keperluan', 'kondisi_ekonomi'],
                'perlu_verifikasi_rt' => true,
                'perlu_approval_kades' => true,
                'estimasi_hari' => 5,
                'biaya' => 0.00,
                'is_active' => true,
            ],
            [
                'nama_surat' => 'Surat Keterangan Usaha',
                'kode_surat' => 'SKU',
                'deskripsi' => 'Surat keterangan untuk usaha/kegiatan ekonomi',
                'template_surat' => 'Yang bertanda tangan di bawah ini, Kepala Desa {nama_desa}, menerangkan bahwa: {data_warga} adalah benar memiliki usaha {jenis_usaha} di wilayah kami.',
                'field_required' => ['keperluan', 'jenis_usaha', 'alamat_usaha'],
                'perlu_verifikasi_rt' => true,
                'perlu_approval_kades' => true,
                'estimasi_hari' => 4,
                'biaya' => 10000.00,
                'is_active' => true,
            ],
            [
                'nama_surat' => 'Surat Keterangan Belum Menikah',
                'kode_surat' => 'SKBM',
                'deskripsi' => 'Surat keterangan status belum menikah',
                'template_surat' => 'Yang bertanda tangan di bawah ini, Kepala Desa {nama_desa}, menerangkan bahwa: {data_warga} berstatus belum menikah hingga surat ini dibuat.',
                'field_required' => ['keperluan'],
                'perlu_verifikasi_rt' => true,
                'perlu_approval_kades' => true,
                'estimasi_hari' => 3,
                'biaya' => 5000.00,
                'is_active' => true,
            ],
        ];

        foreach ($jenisSurats as $jenisSurat) {
            JenisSurat::create($jenisSurat);
        }
    }
}