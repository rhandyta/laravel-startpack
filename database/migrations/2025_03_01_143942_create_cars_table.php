<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string("nopol")->unique();
            $table->text("brand_kendaraan");
            $table->text("model_kendaraan");
            $table->integer("kapasitas");
            $table->text("filepath")->nullable();
            $table->text("filename")->nullable();
            $table->tinyInteger("aktif")->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
