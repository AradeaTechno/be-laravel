<?php

namespace App\Http\Requests;

class LoginRequest extends BaseApiRequest
{

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            "email" => "required",
            "password" => "required"
        ];
    }
}
