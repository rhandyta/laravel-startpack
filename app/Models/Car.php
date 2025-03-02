<?php

namespace App\Models;

use App\Helpers\EncryptedHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{

    use SoftDeletes;

    protected $table = "cars";


    protected $fillable = ["nopol", "brand_kendaraan", "model_kendaraan", "kapasitas", "filepath", "filename"];

    // protected function casts(): array
    // {
    //     return [
    //         'created_at' => 'datetime',
    //         'updated_at' => 'datetime',
    //     ];
    // }

}
