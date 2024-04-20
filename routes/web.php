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
use App\Http\Controllers\ExamController;



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

//Route::get('/admin', function () {
  //  return view('admin');
//});

Route::get('/test', function () {
    return view('test');
});

//Route::get('/mycourses',[App\Http\Controllers\EnrollmentController::class , 'mycourses' ])->name('mycourses');
//Route::get('/mycourses', [EnrollmentController::class, 'mycourses']);
//Route::get('/mycourses', [App\Http\Controllers\EnrollmentController::class ,'enrollment.mycourses']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
//->middleware('role:admin')
// Route::get('/course', [App\Http\Controllers\CourseController::class, 'index']);
// Route::post('/course', [App\Http\Controllers\CourseController::class, 'store']);
// Route::get('/course/{id}', [App\Http\Controllers\CourseController::class, 'show']);
// Route::put('/course/{id}', [App\Http\Controllers\CourseController::class, 'update']);
// Route::delete('/course/{id}', [App\Http\Controllers\CourseController::class, 'destroy']);
// Route::get('/course/create', [App\Http\Controllers\CourseController::class, 'create']);


//Route::DELETE('/course/{id}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('course.destory');



//Route::get('/mycourses', ['App\Http\Controllers\EnrollmentController::class , 'mycourses'])->name('enrollment.myCourses');



Route::resource('enrollment', EnrollmentController::class)->only(['index', 'show', 'create','edit', 'store','update', 'destroy', 'mycourses']);
//Route::get('/enrollment/{id}', [EnrollmentController::class, 'show'])->name('enrollment.show');


Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->middleware('auth');

Route::resource('course', CourseController::class)->only(['index', 'show', 'create','edit', 'store','update', 'destroy']);
Route::get('course.list', [App\Http\Controllers\CourseController::class, 'list'])->name('course.list');

Route::middleware('role:1')->group (function(){





});


Route::middleware('role:2')->group (function(){





});
Route::get('/My-Courses', [CourseController::class, 'userCourses'])->name('course.userCourses');
Route::middleware('role:0')->group (function(){






});
//Route::get('/courses', [App\Http\Controllers\CourseController::class, 'index2']);
//Route::post('/enroll/{course}', [EnrollmentController::class, 'enroll'])->name('enrollpost');

Route::post('/course/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('enrollpost');
Route::put('/course/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('enroll');
Route::post('/course/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('unenrollpost');
Route::put('/course/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('unenroll'); 
//Route::resource('enrollment', [EnrollmentController::class, 'show' , 'mycourses']);


///Route::get('/enrollment/{course}/checkout', [EnrollmentController::class, 'checkout'])->name('enrollment.checkout');
Route::post('/courses/pay', [EnrollmentController::class, 'Payment'])->name('courses.pay');

Route::get('enrollment/checkout', [EnrollmentController::class, 'checkout'])->name('enrollment.checkoutget');
Route::post('enrollment/checkout', [EnrollmentController::class, 'checkout'])->name('enrollment.checkout');


// Route::controller(PaymentController::class)->group(function(){
//     Route::get('payment', 'payment');
//     Route::post('payment', 'stripePost')->name('stripe.post');
// });

// Route::name('stripe.')
//     ->controller(PaymentController::class)
//     ->prefix('stripe')
//     ->group(function () {
//         Route::get('payment', 'index')->name('index');
//         Route::post('payment', 'store')->name('store');
//     });

    Route::resource('category',App\Http\Controllers\CategoryController::class)->only(['index', 'index2', 'show', 'create','edit', 'store','update', 'destroy','courses']);


    //Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/courses', [App\Http\Controllers\CategoryController::class, 'courses'])
    ->name('category.courses');

    Route::resource('lesson',App\Http\Controllers\LessonController::class)->only(['list', 'index', 'create','edit', 'store','update', 'destroy']);
    Route::get('lesson/list',[App\Http\Controllers\LessonController::class, 'list'])->name('lesson.list');
   Route::resource('enrollment',App\Http\Controllers\EnrollmentController::class)->only
   ('index', 'show', 'create','edit', 'store','update', 'destroy');

   Route::get('lesson/{course_id}/{lesson_id}', [App\Http\Controllers\LessonController::class, 'show'])->name('lesson');
   Route::get('/lessons/{courseId}', [LessonController::class, 'showlesson']);

   Route::post('/lessons/{courseId}', [LessonController::class, 'showlesson']);

   Route::resource('review',App\Http\Controllers\ReviewController::class)->only([ 'index', 'create','edit', 'store','update', 'destroy']);


//Route::get('/courses/{course}', [CourseController::class, 'show'])->name('course.show');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/review/list', [ReviewController::class, 'list'])->name('review.list');

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
Route::get('/wishlist/courses', [WishlistController::class, 'wishlistCourses'])->name('wishlist.courses');
Route::get('/wishlist/{user}', [WishlistController::class,'show'])->name('wishlist.show');


Route::get('/wishlist/toggle/{course}', [WishlistController::class,'toggleWishlist'])->name('wishlist.toggle');

//Route::get('/checkout', 'App\Http\Controllers\PaymentController@checkout')->name('checkout');

Route::post('/session', 'App\Http\Controllers\PaymentController@session')->name('session');
Route::get('/session', 'App\Http\Controllers\PaymentController@session')->name('session');

Route::post('/payment', 'App\Http\Controllers\PaymentController@payment')->name('payment');

Route::get('/payment/list', 'App\Http\Controllers\PaymentController@list')->name('payment.list');
//Route::get('/session', 'App\Http\Controllers\PaymentController@session')->name('session');
//Route::match(['GET', 'POST'], '/session', [PaymentController::class, 'session'])->name('session');
Route::get('/checkout/{course}', [PaymentController::class, 'checkout'])->name('payment.checkout');
//Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
//Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');
Route::get('/success', 'App\Http\Controllers\PaymentController@success')->name('success');
Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');


Route::get('/exam/create' ,  [ExamController::class, 'create']) -> name ('exam.create') ; 
Route::post('/exam/store' ,  [ExamController::class, 'store']) -> name ('exam.store') ; 
Route::get('/exam/{exam}/edit' ,  [ExamController::class, 'edit']) -> name ('exam.edit') ; 
Route::put('/exam/{exam}' ,  [ExamController::class, 'update']) -> name ('exam.update') ; 
Route::delete('/exam/{exam}' ,  [ExamController::class, 'destroy']) -> name ('exam.destroy') ;

Route::match(['GET', 'POST'],'pay', [PaymentController::class, 'pay'])->name('pay.order');
//Route::get('success', [PaymentController::class, 'success'])->name('pay.success');
//Route::get('stripe', [PaymentController::class, 'stripe']);
//Route::post('stripe', [PaymentController::class, 'stripePost'])->name('stripe.post');



// Route::middleware('auth')->group(function () {
//     // Routes for profile editing functionality
//     Route::get('/profile', 'UserController@showProfile')->name('profile');
//     Route::post('/profile/update', 'UserController@updateProfile')->name('update-profile');
// });
Route::middleware(['auth'])->group(function () {
});