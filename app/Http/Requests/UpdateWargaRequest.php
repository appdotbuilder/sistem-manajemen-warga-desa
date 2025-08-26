<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWargaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdminDesa() || $this->user()->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $wargaId = $this->route('warga')->id;
        
        return [
            'rt_id' => 'required|exists:rts,id',
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:wargas,nik,' . $wargaId,
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'pekerjaan' => 'required|string|max:255',
            'status_pernikahan' => 'required|in:belum_menikah,menikah,cerai_hidup,cerai_mati',
            'agama' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:wargas,email,' . $wargaId,
            'nomor_kk' => 'nullable|string|max:20',
            'status_dalam_keluarga' => 'nullable|in:kepala_keluarga,istri,anak,menantu,cucu,orangtua,mertua,famili_lain,pembantu,lainnya',
            'status' => 'required|in:aktif,pindah,meninggal',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'rt_id.required' => 'RT/RW harus dipilih.',
            'rt_id.exists' => 'RT/RW yang dipilih tidak valid.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'status_pernikahan.required' => 'Status pernikahan wajib dipilih.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'status.required' => 'Status warga wajib dipilih.',
        ];
    }
}