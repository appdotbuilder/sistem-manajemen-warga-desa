<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuratRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isWarga() || 
               $this->user()->isAdminDesa() || 
               $this->user()->isKetuaRt();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'keperluan' => 'required|string|max:500',
            'data_tambahan' => 'nullable|array',
        ];
        
        // Add pemohon_id validation for admin/ketua RT creating manual surat
        if (!$this->user()->isWarga()) {
            $rules['pemohon_id'] = 'required|exists:wargas,id';
        }
        
        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'jenis_surat_id.required' => 'Jenis surat wajib dipilih.',
            'jenis_surat_id.exists' => 'Jenis surat yang dipilih tidak valid.',
            'keperluan.required' => 'Keperluan surat wajib diisi.',
            'keperluan.max' => 'Keperluan surat maksimal 500 karakter.',
            'pemohon_id.required' => 'Pemohon surat wajib dipilih.',
            'pemohon_id.exists' => 'Pemohon yang dipilih tidak valid.',
        ];
    }
}