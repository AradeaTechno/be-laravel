<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator){
        $errors = $validator->errors();
        $response = response()->json([
            'status' => 400,
            'message' => "Bad request",
            "data" => $errors
        ], 400);

        throw new HttpResponseException($response);
    }
}
