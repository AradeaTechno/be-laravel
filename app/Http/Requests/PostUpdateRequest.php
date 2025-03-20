<?php

namespace App\Http\Requests;

class PostUpdateRequest extends BaseApiRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string'
        ];
    }
}
