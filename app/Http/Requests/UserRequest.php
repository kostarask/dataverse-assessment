<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
//        dd($this->id);
        return [
            "name" => [
                "required"
                ,"string"
            ],
            "username" => [
                "required",
                "string",
                Rule::unique('users')->ignore($this->id),
            ],
            "email" => [
                "required",
                "string",
                "email",
                Rule::unique('users')->ignore($this->id),
            ],
            "password" => "required|string|confirmed",
            "password_confirmation" => "required|string|same:password",
            "is_active" => "required|boolean",
            "roles.*" => "nullable|between:1,6"
        ];
    }
}
