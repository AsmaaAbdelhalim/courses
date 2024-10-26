<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');





//Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->middleware('auth');
Route::get('course/list', [App\Http\Controllers\CourseController::class, 'list'])->name('course.list');
Route::resource('course', CourseController::class)->only(['index', 'show', 'create','edit', 'store','update', 'destroy']);

Route::resource('enrollment', EnrollmentController::class)->only(['index', 'show', 'create','edit', 'store','update', 'destroy']);
Route::get('/My-Courses', [CourseController::class, 'userCourses'])->name('course.userCourses');

Route::middleware('role:1')->group (function(){
});
Route::middleware('role:2')->group (function(){
});
Route::middleware('role:0')->group (function(){
});
Route::middleware(['auth'])->group(function () {
});
Route::post('/course/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('enrollpost');
Route::put('/course/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('enroll');
Route::post('/course/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('unenrollpost');
Route::put('/course/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('unenroll'); 

    Route::resource('category',CategoryController::class)->only(['index', 'edit', 'show', 'create', 'store','update', 'destroy','courses']);
    Route::resource('lesson', LessonController::class)->only(['list', 'index', 'create','edit', 'store','update', 'destroy']);
    Route::get('lesson/list',[LessonController::class, 'list'])->name('lesson.list');
    Route::get('lesson/{course_id}/{lesson_id}', [App\Http\Controllers\LessonController::class, 'show'])->name('lesson');
    


   Route::resource('review', ReviewController::class)->only([ 'index', 'create','edit', 'store','update', 'destroy']);
   Route::get('/review/list', [ReviewController::class, 'list'])->name('review.list');


//Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/profile', [UserController::class, 'show'])->name('profile');
Route::get('/change-password', [UserController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [UserController::class, 'updatePassword'])->name('update-password');
Route::get('/edit-profile', [UserController::class, 'editProfile'])->name('edit-profile');
Route::post('/edit-profile', [UserController::class, 'updateProfile'])->name('update-profile');
Route::get('/users',[UserController::class, 'users'])->name('profile.users');
Route::get('/users/{user}', [UserController::class, 'editUserRole'])->name('edit-user-role');
Route::get('/users/{user}', [UserController::class, 'editUserRole'])->name('profile.edit-user-role');
Route::put('/users/{user}', [UserController::class, 'UpdateUserRole'])->name('update-user-role');




Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/list', [ContactController::class, 'list'])->name('contact.list');



Route::post('/wishlist/add/{course}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::get('/wishlist/remove/{course}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');



Route::post('/session/{course}', 'App\Http\Controllers\PaymentController@session')->name('session');
Route::get('/session/{course}', 'App\Http\Controllers\PaymentController@session');
Route::any('webhook', [PaymentController::class, 'webhook'])->name('webhook');
//Route::post('/payment', 'App\Http\Controllers\PaymentController@payment')->name('payment');
//Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');

Route::get('/payment/list', 'App\Http\Controllers\PaymentController@list')->name('payment.list');
Route::get('/checkout/{course}', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/success/{course}', 'App\Http\Controllers\PaymentController@success')->name('success');



Route::resource('question', QuestionController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
Route::resource('exam', ExamController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
Route::get('/exam/start/{exam}', [ExamController::class, 'startExam'])->name('exam.start');
Route::post('/exam/submit/{exam}', [ResultController::class, 'submitExam'])->name('exam.submit');
//Route::post('/exam/{exam}/submit', 'ExamController@submit')->name('exam.submit');
Route::resource('answer', AnswerController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

//Route::match(['GET', 'POST'],'pay', [PaymentController::class, 'pay'])->name('pay.order');



Route::get('/search', [CourseController::class, 'search'])->name('search');
Route::resource('result', ResultController::class)->only(['index', 'show', 'create', 'store' , 'edit', 'update','destroy']);

