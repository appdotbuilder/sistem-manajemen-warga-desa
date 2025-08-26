<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuratRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $action = $this->input('action');
        
        if ($action === 'verify') {
            return $user->isKetuaRt();
        }
        
        if ($action === 'approve') {
            return $user->isKepala();
        }
        
        return $user->isAdminDesa() || $user->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $action = $this->input('action');
        
        if ($action === 'verify') {
            return [
                'approve' => 'required|boolean',
                'catatan_rt' => 'nullable|string|max:1000',
                'alasan_penolakan' => 'required_if:approve,false|nullable|string|max:1000',
            ];
        }
        
        if ($action === 'approve') {
            return [
                'approve' => 'required|boolean',
                'catatan_kades' => 'nullable|string|max:1000',
                'alasan_penolakan' => 'required_if:approve,false|nullable|string|max:1000',
            ];
        }
        
        return [
            'keperluan' => 'sometimes|required|string|max:500',
            'data_tambahan' => 'nullable|array',
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
            'approve.required' => 'Keputusan persetujuan wajib dipilih.',
            'approve.boolean' => 'Keputusan persetujuan tidak valid.',
            'alasan_penolakan.required_if' => 'Alasan penolakan wajib diisi jika surat ditolak.',
            'catatan_rt.max' => 'Catatan RT maksimal 1000 karakter.',
            'catatan_kades.max' => 'Catatan Kepala Desa maksimal 1000 karakter.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
            'keperluan.required' => 'Keperluan surat wajib diisi.',
            'keperluan.max' => 'Keperluan surat maksimal 500 karakter.',
        ];
    }
}