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
use App\http\Controllers\EnrollmentController;
use App\http\Controllers\AttendanceController;
use App\http\Controllers\PaymentController;
use App\http\Controllers\GenerateReportController;

//GET	Fetch data (View)
//POST	Create new data
//PUT	Update existing data


//use App\http\Controllers\ChildRegistrationController;

//return view
Route::get('/', function () {
    return view('welcome');
});

// //Show registration form
// Route::get('/registration', function() {
//     return view('registration');
// });

//Handle form submission
Route::get('/registration', [EnrollmentController::class, 'create'])->name('enrollment.create');
Route::post('/registration', [EnrollmentController::class, 'store'])->name('enrollment.store');
Route::get('/registration/confirmation', function (){ return view('registrations.confirmation');})->name('enrollments.confirmation');

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

Route::resource('adminActivity', AdminController::class);

Route::get('/children-Register-Request', [AdminController::class, 'childrenRegisterRequest'])->name('childrenRegisterRequest');
Route::get('/children-Register-Request-reject', [AdminController::class, 'rejection'])->name('adminActivity.rejection');
// Route::post('/register-parents-success', [AdminController::class, 'registerParents'])->name('adminActivity.success');
// Route::post('/register-parents-success', [ParentRegistrationController::class, 'registerParents'])->name('adminActivity.success');
Route::put('/admin/approve-registration/{enrollmentId}', [AdminController::class, 'approveRegistration'])
    ->name('adminActivity.approveRegistration');
Route::get('/admin/approve-registration/{enrollmentId}', [AdminController::class, 'approveRegistrationForm'])
    ->name('adminActivity.approveForm');


Route::resource('rooms',RoomController::class);
Route::resource('roomreservations',RoomReservationController::class); //tgk nama model

Route::resource('admin', DailyActivitiesController::class);

Route::resource('staffs', StaffController::class);
Route::get('/staff-assignment', [StaffController::class, 'staffAssignment'])->name('staffs.staffAssignment');


Route::resource('childrens', ChildrenController::class);

Route::resource('announcements',AnnouncementsController::class);

Route::resource('daily_activities', DailyActivitiesController::class);

Route::resource('camera_footages', CameraFootageController::class);

Route::resource('attendances', AttendanceController::class);

Route::resource('payments', PaymentController::class);

Route::resource('generateReports', GenerateReportController::class);
Route::get('/generate-reports/payment', [GenerateReportController::class, 'showPayment'])->name('generateReports.payment');

Route::get('/camera', [CameraFootageController::class, 'index'])->name('camera.index');

require __DIR__.'/auth.php';

