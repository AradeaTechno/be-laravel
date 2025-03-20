<?php

namespace App\Http\Requests;

class PostRequest extends BaseApiRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'user_id' => 'required|string|numeric',
            'title' => 'required|string|max:255',
            'content'   => 'required|string'
        ];
    }
}
