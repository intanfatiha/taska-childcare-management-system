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
Route::get('/registration/new-child', [\App\Http\Controllers\EnrollmentController::class, 'createNewChild'])->name('enrollment.createNewChild');
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
Route::post('/admin/reject-registration/{enrollmentId}', [AdminController::class, 'rejectRegistration'])->name('adminActivity.rejectRegistration');

// Route::post('/register-parents-success', [AdminController::class, 'registerParents'])->name('adminActivity.success');
// Route::post('/register-parents-success', [ParentRegistrationController::class, 'registerParents'])->name('adminActivity.success');
// Route::put('/admin/approve-registration/{enrollmentId}', [AdminController::class, 'approveRegistration'])
//     ->name('adminActivity.approveRegistration');

Route::post('/admin/approve-registration/{enrollmentId}', [AdminController::class, 'approveRegistration'])->name('adminActivity.approveRegistration');

Route::get('/admin/approve-registration/{enrollmentId}', [AdminController::class, 'approveRegistrationForm'])->name('adminActivity.approveForm');
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

// Route::resource('cameraFootages', CameraFootageController::class);

Route::resource('camera-footages', CameraFootageController::class);
// Route::post('/camera-footages', [CameraFootageController::class, 'testfunction'])->name('testfunction');

// // Route for displaying camera footage page
// Route::get('/camera-footages', [CameraFootageController::class, 'index'])->name('cameraFootages.index');

// // Route for storing camera footage (make sure it accepts POST requests)
// Route::post('/camera-footages', [CameraFootageController::class, 'store'])->name('cameraFootages.store');

// // Route for deleting camera footage
// Route::delete('/camera-footages/{id}', [CameraFootageController::class, 'destroy'])->name('cameraFootages.destroy');

Route::resource('attendances', AttendanceController::class);
Route::get('/attendances-parents', [AttendanceController::class, 'parentsIndex'])->name('attendances.parentsIndex');
Route::get('/time-out', [AttendanceController::class, 'createTimeOut'])->name('attendances.createTimeOut');
Route::post('/time-out', [AttendanceController::class, 'updateTimeOut'])->name('attendances.updateTimeOut');
Route::get('attendances/edit/{childId}/{date?}', [AttendanceController::class, 'edit'])->name('attendances.edit');
// In your web.php routes file


Route::put('attendances/update/{childId}/{date?}', [AttendanceController::class, 'update'])
     ->name('attendances.update');

Route::post('attendances/update-time-out', [AttendanceController::class, 'updateTimeOut'])
     ->name('attendances.updateTimeOut');



Route::resource('payments', PaymentController::class);
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.form');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/success', function () { return "Payment Successful!";})->name('payment.success');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', function () {return redirect()->route('payments.index');})->name('payment.cancel');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
  
// Invoice routes
Route::get('/payments/{payment}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');
// Preview invoice in browser with app layout
Route::get('/payments/{payment}/invoice/preview', [PaymentController::class, 'previewInvoice'])->name('payments.invoice.preview');

Route::resource('generateReports', GenerateReportController::class);
Route::get('/attendance-report', [GenerateReportController::class, 'index'])->name('attendance.report');
// Route::get('/payment-report', [GenerateReportController::class, 'index'])->name('payment.report');

Route::get('/generate-reports/payment', [GenerateReportController::class, 'showPayment'])->name('generateReports.payment');
Route::get('/attendance-report/pdf', [GenerateReportController::class, 'exportPdf'])->name('attendance.report.pdf');
Route::get('/attendance/download-pdf', [GenerateReportController::class, 'downloadPDF'])->name('attendance.downloadPDF');
Route::get('/generate-reports/payment/export-pdf', [GenerateReportController::class, 'exportPDF'])->name('generateReports.export.pdf');
// web.php
Route::post('/generate-report-pdf', [GenerateReportController::class, 'exportPDF'])->name('generateReports.export.pdf');



Route::get('/camera', [CameraFootageController::class, 'index'])->name('camera.index');

require __DIR__.'/auth.php';

