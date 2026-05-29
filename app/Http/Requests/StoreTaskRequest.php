<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Constants\TaskConstants;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Otorisasi nanti di-handle di Controller
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'in:' . implode(',', TaskConstants::allStatuses())],
            'priority' => ['nullable', 'in:' . implode(',', TaskConstants::allPriorities())],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'deadline_at' => ['nullable', 'date'],
        ];
    }
}