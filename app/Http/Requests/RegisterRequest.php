<?php

namespace App\Http\Requests;

class RegisterRequest extends BaseApiRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            "name" => "required|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required",
        ];
    }
}
