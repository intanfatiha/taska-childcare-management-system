<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\RoomController; //panggil sebab kat bawah kita ada panggil resorce ctrller
use App\http\Controllers\RoomReservationController;
use App\http\Controllers\StaffController;
use App\http\Controllers\ChildrenController;
use App\http\Controllers\AnnouncementsController;
use App\http\Controllers\DailyActivitiesController;
use App\http\Controllers\AdminController;
use App\http\Controllers\CameraFootageController;
use App\http\Controllers\ParentInfoController;
use App\http\Controllers\AttendanceController;
use App\http\Controllers\PaymentController;
use App\http\Controllers\GenerateReportController;




//use App\http\Controllers\ChildRegistrationController;

//return view
Route::get('/', function () {
    return view('welcome');
});

Route::get('/try', function () {
    return view('try'); // Make sure you have created this view file 'try.blade.php'
});

Route::get('/parentChildrenRegister', function () {
    return view('parentChildrenRegister'); // Make sure you have created this view file 'try.blade.php'
});

Route::post('/register-children', [ParentInfoController::class, 'processRelationType'])->name('processRelationType');


Route::get('/parent-children-register', function () {
    return view('parentChildrenRegister');
})->name('parentChildrenRegister');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin-home', function () {
    return view('adminHomepage');
})->middleware(['auth', 'verified'])->name('adminHomepage');

//return controller
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); //panggil function edit
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/parentChildrenRegister', function () {
    return view('parentChildrenRegister');
})->middleware(['auth', 'verified'])->name('parentChildrenRegister');

Route::resource('rooms',RoomController::class);
Route::resource('roomreservations',RoomReservationController::class); //tgk nama model

Route::resource('parentInfos', ParentInfoController::class);

//Parent or Guardian selection page
Route::get('/register-children', [ParentInfoController::class, 'showRegistrationForm'])->name('register.children');
Route::post('/register-children', [ParentInfoController::class, 'processRelationType'])->name('processRelationType');

// Parent routes
Route::get('/father-form', [ParentInfoController::class, 'showFatherForm'])->name('father.form');
Route::post('/father-form', [ParentInfoController::class, 'storeFather'])->name('father.store');

Route::get('/mother-form', [ParentInfoController::class, 'showMotherForm'])->name('mother.form');
Route::post('/mother-form', [ParentInfoController::class, 'storeMotherInfo'])->name('mother.store');

// Guardian route
Route::get('/guardian-form', [ParentInfoController::class, 'showGuardianForm'])->name('guardian.form');
Route::post('/guardian-form', [ParentInfoController::class, 'storeGuardian'])->name('guardian.store');


Route::resource('admin', DailyActivitiesController::class);
Route::resource('staffs', StaffController::class);
Route::resource('childrens', ChildrenController::class);

Route::resource('announcements',AnnouncementsController::class);
Route::resource('daily_activities', DailyActivitiesController::class);
Route::get('/children-Register-Request', [AdminController::class, 'childrenRegisterRequest'])->name('childrenRegisterRequest');
Route::resource('camera_footages', CameraFootageController::class);
Route::resource('attendances', AttendanceController::class);
Route::resource('payments', PaymentController::class);
Route::resource('generateReports', GenerateReportController::class);
Route::get('/generate-reports/payment', [GenerateReportController::class, 'showPayment'])->name('generateReports.payment');



require __DIR__.'/auth.php';

