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
use App\Http\Controllers\CertificateController;
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

Auth::routes();

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('course/list', [CourseController::class, 'list'])->name('course.list');

Route::resource('course', CourseController::class)
    ->only(['index','show']);

Route::resource('category', CategoryController::class)
    ->only(['index','show']);

Route::get('/search', [CourseController::class, 'search'])->name('search');


/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/

Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/list', [ContactController::class, 'list'])->name('contact.list');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    | User Profile
    */

    Route::get('/profile', [UserController::class, 'show'])->name('profile');

    Route::get('/edit-profile', [UserController::class, 'editProfile'])->name('edit-profile');
    Route::post('/edit-profile', [UserController::class, 'updateProfile'])->name('update-profile');

    Route::get('/change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('update-password');

      /*
    | Categories
    */

    Route::resource('category', CategoryController::class)
        ->only(['create','store','edit','update','destroy']);

    /*
    | Courses
    */

    Route::resource('course', CourseController::class)
        ->only(['create','store','edit','update','destroy']);
    Route::get('/My-Courses', [CourseController::class, 'userCourses'])
        ->name('course.userCourses');

    Route::post('/course/{course}/enroll', [EnrollmentController::class, 'enroll'])
        ->name('enroll');

    Route::delete('/course/{course}/unenroll', [EnrollmentController::class, 'unenroll'])
        ->name('unenroll');


    /*
    | Wishlist
    */

    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');

    Route::post('/wishlist/add/{course}', [WishlistController::class, 'addToWishlist'])
        ->name('wishlist.add');

    Route::get('/wishlist/remove/{course}', [WishlistController::class, 'removeFromWishlist'])
        ->name('wishlist.remove');


    /*
    | Reviews
    */

    Route::resource('review', ReviewController::class)
        ->only(['index','create','edit','store','update','destroy']);

    /*
    | Lessons
    */

    Route::resource('lesson', LessonController::class)
        ->only(['index','create','edit','store','update','destroy']);

    Route::get('lesson/{course_id}/{lesson_id}', [LessonController::class, 'show'])
        ->name('lesson');


    /*
    | Exams
    */

    Route::resource('exam', ExamController::class)
        ->only(['index','show','create','store','edit','update','destroy']);

    Route::get('/exam/start/{exam}', [ExamController::class, 'startExam'])
        ->name('exam.start');

    Route::post('/exam/{exam}/submit', [ExamController::class, 'submitExam'])
        ->name('exam.submit');

    /*
    | Results
    */

    Route::resource('result', ResultController::class)
        ->only(['index','show','create','store','edit','update','destroy']);

    Route::get('/certificate/{result}', [CertificateController::class, 'downloadCertificate'])
        ->name('certificate.download');


    /*
    | Questions
    */

    Route::post('/questions', [QuestionController::class,'store'])
        ->name('question.store');

    Route::get('/questions/{question}/edit', [QuestionController::class,'edit']);

    Route::put('/questions/{question}', [QuestionController::class,'update']);

    Route::delete('/questions/{question}', [QuestionController::class,'destroy']);


    /*
    | Payments
    */

    Route::get('session/{course}', [PaymentController::class,'session'])
        ->name('session');

    Route::get('/payment/index', [PaymentController::class,'index'])
        ->name('payment.index');

    Route::get('/success/{course}', [PaymentController::class,'success'])
        ->name('success');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:1'])->group(function () {

    Route::get('/admin', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'users'])
        ->name('profile.users');

    Route::get('/users/{user}', [UserController::class, 'editUserRole'])
        ->name('edit-user-role');

    Route::put('/users/{user}', [UserController::class, 'UpdateUserRole'])
        ->name('update-user-role');

});


/*
|--------------------------------------------------------------------------
| Stripe Webhook
|--------------------------------------------------------------------------
*/

Route::any('webhook', [PaymentController::class, 'webhook'])
    ->name('webhook');