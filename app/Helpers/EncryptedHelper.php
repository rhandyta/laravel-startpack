<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class EncryptedHelper
{
    protected $key;
    protected $method;

    public function __construct()
    {
        $this->key = str_pad(Config::get("internal.secure_encrypted_key", "travel-apps213"), 32, "\0");
        $this->method = "aes-256-cbc";
    }

    protected function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    protected function base64UrlDecode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public function secureEncode($data)
    {
        $ivLength = openssl_cipher_iv_length($this->method);
        $iv = openssl_random_pseudo_bytes($ivLength); 
        $encryptedData = openssl_encrypt($data, $this->method, $this->key, 0, $iv);
 
        return $this->base64UrlEncode($encryptedData) . "::" . $this->base64UrlEncode($iv);
    }

    public function secureDecode($data)
    {
        list($encryptedData, $iv) = explode("::", $data);
    
        $encryptedData = $this->base64UrlDecode($encryptedData);
        $iv = $this->base64UrlDecode($iv);
    
        return openssl_decrypt($encryptedData, $this->method, $this->key, 0, $iv);
    }
}