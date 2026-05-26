<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Constants\TeamMemberConstants;

class ChangeRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'string', 'in:' . implode(',', TeamMemberConstants::allRoles())],
        ];
    }
}