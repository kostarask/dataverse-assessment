<?php

namespace App\Http\Requests;

use App\Rules\UserIsActive;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => [
                "required",
                "string",
                "exists:users",
                new UserIsActive(),
            ],
            "password" => "required|string",
        ];
    }

    public function messages(): array
    {
        return [
            'username.exists' => 'No user with this username found.',
        ];
    }
}
