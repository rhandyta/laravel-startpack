<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CarStoreRequest extends FormRequest
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
            "nopol" => "required|string|unique:cars,nopol",
            "brand_kendaraan" => "required|string",
            "model_kendaraan" => "required|string",
            "kapasitas" => "required|numeric|min:1",
            "gambar" => "required|array",
            "gambar.*" => "image|mimes:png,jpg,jpeg|max:10240"
        ];
    }

    public function attributes()
    {
        return [
            "nopol" => "nomor kendaraan",
            "brand_kendaraan" => "merk kendaraan",
            "model" => "tipe kendaraan",
        ];
    }

    public function messages()
    {
        return [
            "nopol.required" => "nomor kendaraan wajib diisi",
            "nopol.unique" => "nomor kendaraan sudah terdaftar",
            "brand_kendaraan.required" => "merk kendaraan wajib diisi",
            "model_kendaraan.required" => "tipe kendaraan wajib diisi",
            "kapasitas.required" => "kapasitas wajib diisi",
            "kapasitas.numeric" => "kapasitas harus angka",
            "kapasitas.min" => "kapasitas minimal 1",
            "gambar.required" => "gambar wajib diisi",
            "gambar.*" => "gambar tidak valid",
            "gambar.*.max" => "gambar melebihi ukuran yang ditentukan 10mb"
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
}
