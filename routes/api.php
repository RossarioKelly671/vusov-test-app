<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WeatherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    "middleware" => "api",
    "prefix" => "auth",
    "controller" => AuthController::class,
], function () {
    Route::post("/login", "login")->name("login");
    Route::get("/logout", "logout")->name("logout");
    Route::get("/refresh", "refresh")->name("refresh");
});

Route::group([
    "middleware" => "auth:api",
    "prefix" => "user",
    "controller" => UserController::class,
], function () {
    Route::post("/", "create")
        ->name("create")
        ->middleware("role:admin");
    Route::put("/{user}", "update")->name("update");
    Route::delete("/{user}", "delete")->name("delete");
    Route::get("/{user}", "show")->name("show");
});

Route::group([
    "middleware" => "auth:api",
    "prefix" => "weather",
    "controller" => WeatherController::class,
], function () {
    Route::get("/{city}", "getWeatherByCity");
});
