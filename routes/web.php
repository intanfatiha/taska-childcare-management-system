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
Route::post('/admin/reject-registration/{enrollmentId}', [AdminController::class, 'rejectRegistration'])
    ->name('adminActivity.rejectRegistration');

// Route::post('/register-parents-success', [AdminController::class, 'registerParents'])->name('adminActivity.success');
// Route::post('/register-parents-success', [ParentRegistrationController::class, 'registerParents'])->name('adminActivity.success');
// Route::put('/admin/approve-registration/{enrollmentId}', [AdminController::class, 'approveRegistration'])
//     ->name('adminActivity.approveRegistration');

Route::post('/admin/approve-registration/{enrollmentId}', [AdminController::class, 'approveRegistration'])
    ->name('adminActivity.approveRegistration');

Route::get('/admin/approve-registration/{enrollmentId}', [AdminController::class, 'approveRegistrationForm'])
    ->name('adminActivity.approveForm');
    Route::get('/children-enrollment', [AdminController::class, 'listEnrollments'])->name('listChildEnrollment');
    Route::get('/enrollment-detail/{id}', [AdminController::class, 'enrollmentDetail'])->name('enrollmentDetail');


Route::resource('rooms',RoomController::class);
Route::resource('roomreservations',RoomReservationController::class); //tgk nama model

Route::resource('admin', DailyActivitiesController::class);

Route::resource('staffs', StaffController::class);
Route::get('/staff-assignment', [StaffController::class, 'staffAssignment'])->name('staffs.staffAssignment');
Route::post('/staff-assignments/update', [StaffController::class, 'updateAssignments'])->name('staff.updateAssignments');


Route::resource('childrens', ChildrenController::class);

Route::resource('announcements',AnnouncementsController::class);


Route::resource('daily_activities', DailyActivitiesController::class);

Route::resource('cameraFootages', CameraFootageController::class);
// Route for displaying camera footage page
Route::get('/camera-footages', [CameraFootageController::class, 'index'])->name('cameraFootages.index');

// Route for storing camera footage (make sure it accepts POST requests)
Route::post('/camera-footages', [CameraFootageController::class, 'store'])->name('cameraFootages.store');

// Route for deleting camera footage
Route::delete('/camera-footages/{id}', [CameraFootageController::class, 'destroy'])->name('cameraFootages.destroy');

Route::resource('attendances', AttendanceController::class);
Route::get('/attendances-parentsChildAttendance', [AttendanceController::class, 'parentsIndex'])->name('attendances.parentsIndex');

Route::resource('payments', PaymentController::class);

Route::resource('generateReports', GenerateReportController::class);
Route::get('/generate-reports/payment', [GenerateReportController::class, 'showPayment'])->name('generateReports.payment');

Route::get('/camera', [CameraFootageController::class, 'index'])->name('camera.index');

require __DIR__.'/auth.php';

