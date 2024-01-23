<?php

use App\Http\Controllers\GenerateController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/banner/{id}', [GenerateController::class, 'showBanner'])->name('banner.show');
Route::get('/story/{id}', [GenerateController::class, 'showStory'])->name('story.show');
Route::post('/stories/update-order', [GenerateController::class, 'updateOrder']);
