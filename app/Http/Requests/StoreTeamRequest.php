<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Constants\TeamConstants;

class StoreTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Set ke true karena untuk urusan wajib login udah di-handle oleh middleware Auth
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'visibility' => ['nullable', 'in:' . implode(',', TeamConstants::allVisibility())],
        ];
    }

    /**
     * Custom pesan error (opsional tapi bagus untuk UX)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama workspace wajib diisi.',
            'name.max' => 'Nama workspace maksimal 255 karakter.',
            'visibility.in' => 'Visibilitas yang dipilih tidak valid.',
        ];
    }
}