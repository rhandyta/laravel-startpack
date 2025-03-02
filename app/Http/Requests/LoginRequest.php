<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

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
            "email" => "required|email|string",
            "password" => "required|min:6|string"
        ];
    }


    public function failedValidation(Validator $validator) 
    {
        $message = "";

        if($validator->fails()) {
            $message = $validator->errors();
        }

        throw new HttpResponseException(response()->json([
            "success" => false,
            "code" => Response::HTTP_BAD_REQUEST,
            "message" => $message
        ], Response::HTTP_BAD_REQUEST));
    }

    public function messages(): array
    {
        return [
            'email.required' => 'e-mail wajib diisi',
            'email.email' => 'e-mail tidak valid',
            'password.required' => "password wajib diisi",
            "password.min" => "password minimal 6 karakter",
        ];
    }

    public function attributes()
    {
        return [
            "email" => "email address",
            "password" => "password",
        ];
    }
}
