<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ParentRecord;
use App\Models\Child;
use App\Models\Father;
use App\Models\Mother;
use App\Models\Guardian;
use App\Models\Enrollment;
use App\Models\Attendance;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
public function index(Request $request)
{
    $month = $request->get('month', now()->format('Y-m'));
    $status = $request->get('status', 'all');

    $today = Carbon::now();

    // Automatically update overdue payments
    Payment::where('payment_status', 'pending')
        ->whereDate('payment_duedate', '<', $today)
        ->update(['payment_status' => 'overdue']);

    $paymentsQuery = Payment::with(['child', 'parentRecord'])
        ->orderBy('payment_duedate', 'desc');

    // Filter by month
    if ($month) {
        $paymentsQuery->whereMonth('payment_duedate', Carbon::parse($month)->month)
                      ->whereYear('payment_duedate', Carbon::parse($month)->year);
    }

    // Filter by status
    if ($status && $status !== 'all') {
        if ($status === 'overdue') {
            $paymentsQuery->where('payment_status', 'overdue');
        } else {
            $paymentsQuery->where('payment_status', ucfirst($status));
        }
    }

    // Filter for parents
    if (auth()->user()->role === 'parents') {
        $parentRecord = $this->getParentRecordForLoggedInUser();
        if ($parentRecord) {
            $paymentsQuery->where('parent_id', $parentRecord->id);
        }
    }

    if (auth()->user()->role === 'parents') {
    $children = \App\Models\Child::whereHas('parentRecord', function($q) use ($parentRecord) {
    $q->where('father_id', $parentRecord->father_id)
      ->orWhere('mother_id', $parentRecord->mother_id)
      ->orWhere('guardian_id', $parentRecord->guardian_id);
})->get();
    } else {
        $children = collect();
    }

    $payments = $paymentsQuery->get();

    // For month dropdown (last 12 months)
    $months = [];
    for ($i = 0; $i < 12; $i++) {
        $months[] = now()->subMonths($i)->format('Y-m');
    }


    return view('payments.index', compact('payments', 'months', 'month', 'status', 'children'));
}

    //function to get the parent record for the logged-in user
    protected function getParentRecordForLoggedInUser()
    {
        $userId = auth()->id();

        // 1. Check if user is a father
        $father = Father::where('user_id', $userId)->first();
        if ($father) {
            $record = ParentRecord::where('father_id', $father->id)->first();
            if ($record) return $record;
        }

        // 2. Check if user is a mother
        $mother = Mother::where('user_id', $userId)->first();
        if ($mother) {
            $record = ParentRecord::where('mother_id', $mother->id)->first();
            if ($record) return $record;
        }

        // 3. Check if user is a guardian
        $guardian = Guardian::where('user_id', $userId)->first();
        if ($guardian) {
            $record = ParentRecord::where('guardian_id', $guardian->id)->first();
            if ($record) return $record;
        }

        // No matching parent record
        return null;
    }
    


public function create()
{
    $children = Child::with(['parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian'])->get();

    $formattedChildren = [];
    $parentsByChild = [];
    $parentRecordIdByChild = [];
    $enrollmentStartDates = [];

    foreach ($children as $child) {
        $formattedChildren[] = [
            'id' => $child->id,
            'name' => $child->child_name,
        ];

        $parentRecord = $child->parentRecord;
        $parentName = 'No Data';
        $parentRecordId = null;

        if ($parentRecord) {
            $names = [];
            if ($parentRecord->father) $names[] = $parentRecord->father->father_name;
            if ($parentRecord->mother) $names[] = $parentRecord->mother->mother_name;
            if ($parentRecord->guardian) $names[] = $parentRecord->guardian->guardian_name;
            $parentName = implode(' & ', $names);
            $parentRecordId = $parentRecord->id;
        }

        $parentsByChild[$child->id] = $parentName;
        $parentRecordIdByChild[$child->id] = $parentRecordId;
        $enrollmentStartDates[$child->id] = $child->parentRecord?->enrollment?->created_at?->format('Y-m-d');
    }

    // Sort children alphabetically
    usort($formattedChildren, fn($a, $b) => strcmp($a['name'], $b['name']));

    // Optimized overtime query
    $attendanceSums = Attendance::select('children_id', \DB::raw('SUM(attendance_overtime) as total'))
        ->whereMonth('attendance_date', now()->month)
        ->whereYear('attendance_date', now()->year)
        ->groupBy('children_id')
        ->pluck('total', 'children_id')
        ->toArray();

    $totalOvertimeMinutesByChild = [];
    foreach ($children as $child) {
        $totalOvertimeMinutesByChild[$child->id] = $attendanceSums[$child->id] ?? 0;
    }

    return view('payments.create', compact(
        'formattedChildren', 'parentsByChild', 'parentRecordIdByChild',
        'enrollmentStartDates', 'totalOvertimeMinutesByChild'
    ));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the request
        $validatedData = $request->validate([
            'child_id' => 'required|exists:childrens,id',
            'parent_id' => 'required|exists:parent_records,id',
            'payment_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        // Create the payment with initial pending status
        $payment = Payment::create([
            'user_id' => null, 
            'child_id' => $validatedData['child_id'],
            'parent_id' => $validatedData['parent_id'],
            'payment_amount' => $validatedData['payment_amount'],
            'payment_duedate' => $validatedData['due_date'],
            'payment_status' => 'pending',
            'bill_date' => Carbon::now()->toDateString(),
        ]);

        $parentRecord = \App\Models\ParentRecord::with(['father', 'mother', 'guardian'])
        ->find($validatedData['parent_id']);

        $emails = [];

        if ($parentRecord) {
            if ($parentRecord->father && $parentRecord->father->father_email) {
                $emails[$parentRecord->father->father_email] = $parentRecord->father->father_name;
            }
            if ($parentRecord->mother && $parentRecord->mother->mother_email) {
                $emails[$parentRecord->mother->mother_email] = $parentRecord->mother->mother_name;
            }
            if ($parentRecord->guardian && $parentRecord->guardian->guardian_email) {
                $emails[$parentRecord->guardian->guardian_email] = $parentRecord->guardian->guardian_name;
            }
        }

        foreach ($emails as $email => $name) {
        try {
            Mail::html("
                <h2>Dear $name,</h2>
                <p>A new payment has been created for your child. Please log in to your account to view and make payment.</p>
                <p>Thank you.</p>
            ", function ($message) use ($email) {
                $message->to($email)
                    ->subject('New Payment Notification');
            });

            // Log successful email
            \Log::info("Payment email sent successfully to: $email");
        } catch (\Exception $e) {
            // Log email sending failures
            \Log::error("Failed to send payment email to $email. Error: " . $e->getMessage());
        }
    }

        return redirect()->route('payments.index')
                         ->with('message', 'Payment created successfully');
    }

    
    public function show(Payment $payment)
    {
        //  $this->updatePaymentStatus($payment);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
         $children = Child::with(['parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian'])->get();

            $formattedChildren = [];
            $parentsByChild = [];
            $parentRecordIdByChild = [];

            foreach ($children as $child) {
                $formattedChildren[] = [
                    'id' => $child->id,
                    'name' => $child->child_name,
                ];

                $parentRecord = $child->parentRecord;
                $parentName = 'No Data';
                $parentRecordId = null;

                if ($parentRecord) {
                    $names = [];
                    if ($parentRecord->father) $names[] = $parentRecord->father->father_name;
                    if ($parentRecord->mother) $names[] = $parentRecord->mother->mother_name;
                    if ($parentRecord->guardian) $names[] = $parentRecord->guardian->guardian_name;
                    $parentName = implode(' & ', $names);
                    $parentRecordId = $parentRecord->id;
                }

                $parentsByChild[$child->id] = $parentName;
                $parentRecordIdByChild[$child->id] = $parentRecordId;
            }

            return view('payments.edit', compact('payment', 'formattedChildren', 'parentsByChild', 'parentRecordIdByChild'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
         // Validate the request
        $validatedData = $request->validate([
            'child_id' => 'required|exists:childrens,id',
            'parent_id' => 'required|exists:parent_records,id',
            'payment_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        // Update the payment record
        $payment->child_id = $validatedData['child_id'];
        $payment->parent_id = $validatedData['parent_id'];
        $payment->payment_amount = $validatedData['payment_amount'];
        $payment->payment_duedate = $validatedData['due_date'];
        $payment->save();

        return redirect()->route('payments.index')->with('message', 'Payment updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
          $payment->delete();
        return redirect()->route('payments.index')
                         ->with('message', 'Payment deleted successfully');
    }


    
public function checkout(Request $request)
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $payment = Payment::findOrFail($request->payment_id);

   
    try {
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'myr', // or 'myr' if you want MYR
                    'product_data' => [
                        'name' => 'Your Fees',
                    ],
                    'unit_amount' => intval($payment->payment_amount * 100), // amount in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['payment_id' => $payment->id]),
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url, 303);
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Unable to create payment session: ' . $e->getMessage()]);
    }
}

public function paymentSuccess(Request $request)
{
    $paymentId = $request->query('payment_id');
    $payment = Payment::findOrFail($paymentId);

    // Only update if not already complete
    if ($payment->payment_status !== 'Complete') {
        $payment->user_id = auth()->id(); // or set to the parent user id if needed
        $payment->paymentByParents_date = Carbon::now();
        $payment->payment_status = 'Complete';
        $payment->save();
    }

    return redirect()->route('payments.index')->with('message', 'Payment successful and updated!');
}
public function invoice(Payment $payment)
{
    // Only allow invoice generation for completed payments
    if ($payment->payment_status !== 'Complete') {
        return redirect()->back()
            ->with('error', 'Invoice can only be generated for completed payments.');
    }

    $user = auth()->user();

    // Authorization: admins can access all, parents only their own invoices
    if ($user->role !== 'admin') {
        $parentRecord = $this->getParentRecordForLoggedInUser();

        if (!$parentRecord || $payment->parent_id !== $parentRecord->id) {
            abort(403, 'Unauthorized access to invoice.');
        }
    }

    // Load relationships for invoice details
    $payment->load([
        'child',
        'parentRecord.father',
        'parentRecord.mother',
        'parentRecord.guardian'
    ]);

    // Generate PDF using the Blade view and set paper size to A4 portrait
    $pdf = Pdf::loadView('payments.invoice', compact('payment'))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'dpi' => 150,
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

    // Prepare filename with child name and invoice date
    $childName = $payment->child->child_name ?? 'Child';
    $invoiceDate = $payment->paymentByParents_date
        ? \Carbon\Carbon::parse($payment->paymentByParents_date)->format('Y-m-d')
        : \Carbon\Carbon::now()->format('Y-m-d');

    $filename = 'Invoice-' . $payment->id . '-' . str_replace(' ', '_', $childName) . '-' . $invoiceDate . '.pdf';

    // Download the generated PDF
    return $pdf->download($filename);
}



    /**
     * Preview invoice in browser (optional method for testing).
     */
    public function previewInvoice(Payment $payment)
    {
        // Check if payment is complete
        if ($payment->payment_status !== 'Complete') {
            return redirect()->back()
                           ->with('error', 'Invoice can only be generated for completed payments.');
        }

        // Check authorization
        $user = auth()->user();
        if ($user->role !== 'admin') {
            $parentRecord = $this->getParentRecordForLoggedInUser();
            if (!$parentRecord || $payment->parent_id !== $parentRecord->id) {
                abort(403, 'Unauthorized access to invoice.');
            }
        }

        // Load relationships
        $payment->load([
            'child', 
            'parentRecord.father', 
            'parentRecord.mother', 
            'parentRecord.guardian'
        ]);

        return view('payments.invoice', compact('payment'));
    }


    public function sendOverdueEmail(Request $request)
    {
        $payment = Payment::with(['parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian', 'child'])
            ->findOrFail($request->payment_id);

        $parentRecord = $payment->parentRecord;
        $childName = $payment->child->child_name ?? 'your child';

        $emails = [];
        if ($parentRecord) {
            if ($parentRecord->father && $parentRecord->father->father_email) {
                $emails[$parentRecord->father->father_email] = $parentRecord->father->father_name;
            }
            if ($parentRecord->mother && $parentRecord->mother->mother_email) {
                $emails[$parentRecord->mother->mother_email] = $parentRecord->mother->mother_name;
            }
            if ($parentRecord->guardian && $parentRecord->guardian->guardian_email) {
                $emails[$parentRecord->guardian->guardian_email] = $parentRecord->guardian->guardian_name;
            }
        }


        foreach ($emails as $email => $name) {
            try {
                Mail::html("
                    <h2>Dear $name,</h2>
                    <p>This is a reminder that your payment for <strong>$childName</strong> is overdue. Please make the payment as soon as possible.</p>
                    <p>Thank you.</p>
                ", function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Overdue Payment Reminder');
                });
                \Log::info("Overdue payment email sent successfully to: $email");
            } catch (\Exception $e) {
                \Log::error("Failed to send overdue payment email to $email. Error: " . $e->getMessage());
            }
        }

        return back()->with('message', 'Overdue email sent to parent/guardian.');
    }



}
