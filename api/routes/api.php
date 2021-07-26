<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Designs\DesignController;
use App\Http\Controllers\Designs\UploadController;
use App\Http\Controllers\Users\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (Request $request) {
  return response()->json([]);
});

Route::middleware(['auth:sanctum', 'password.confirm'])->delete('/user', function (Request $request) {
  return $request->user()->delete();
});

// Public Routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Route Group For Design
Route::name('designs.')->group(function() {

  // Public Routes
  Route::get('/designs', [DesignController::class, 'index'])->name('index');

  // Route Group For Authenticated Users Only
  Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::post('/designs', UploadController::class)->name('name');
    Route::put('/designs/{design}', [DesignController::class, 'update'])->name('update');
    Route::delete('/designs/{design}', [DesignController::class, 'destroy'])->name('destroy');
  });

});
