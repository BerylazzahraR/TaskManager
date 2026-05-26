<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Constants\TeamConstants;

class UpdateTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi role owner/admin nanti akan di-handle lebih aman lewat Policy di Controller
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'in:' . implode(',', TeamConstants::allStatuses())],
            'visibility' => ['nullable', 'in:' . implode(',', TeamConstants::allVisibility())],
        ];
    }
}