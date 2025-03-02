<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// AUTH START
Route::group(["prefix" => "auth"], function () {

    Route::get("login", function () {
        return view("auth.login");
    })->name("auth.login");

    Route::post("login", LoginController::class)->name("submit.login");
});
// AUTH END


Route::group(["prefix" => "admin", "middleware" => "admin"], function () {

    Route::get("/", function () {
        return view("dashboard.index");
    })->name("dashboard.index");

    // Kendaraan
    Route::resource("kendaraan", CarController::class)->except(["create", "show"]);
    Route::get("kendaraan/loaddata", [CarController::class, "loadData"])->name("kendaraan.loaddata");


});
