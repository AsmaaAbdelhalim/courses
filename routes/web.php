<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('role:admin');

// Route::get('/course', [App\Http\Controllers\CourseController::class, 'index']);
// Route::post('/course', [App\Http\Controllers\CourseController::class, 'store']);
// Route::get('/course/{id}', [App\Http\Controllers\CourseController::class, 'show']);
// Route::put('/course/{id}', [App\Http\Controllers\CourseController::class, 'update']);
// Route::delete('/course/{id}', [App\Http\Controllers\CourseController::class, 'destroy']);
// Route::get('/course/create', [App\Http\Controllers\CourseController::class, 'create']);


//Route::DELETE('/course/{id}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('course.destory');





Route::middleware('role:admin')->group (function(){

Route::resource('course', CourseController::class)->only(['index', 'show', 'create','edit', 'store','update', 'destroy']);



});

Route::middleware('role:user')->group (function(){


Route::get('/courses', [App\Http\Controllers\CourseController::class, 'index2']);


});