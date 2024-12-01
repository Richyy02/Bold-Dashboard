<?php

use App\Http\Controllers\Api\ApiLocationController;
use App\Http\Controllers\ProfileController;
use App\Models\ApiLocation;
use App\Models\Uri;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
require __DIR__.'/auth.php';
Route::get('/', function () {
    return redirect("/voorkappers_nl");
});

Route::get('/dashboard', function () {
    return redirect("/voorkappers_nl");
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/{api_location}", [ApiLocationController::class, "show"])->middleware('auth');
