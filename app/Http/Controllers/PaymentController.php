<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
          // Fetch payments with optional filtering
        $query = Payment::query();

        // Filter by month if requested
        // if (request()->has('month')) {
        //     $query->whereMonth('due_date', request('month'));
        // }

        // // Sort payments
        $payments = Payment::orderBy('payment_duedate', 'desc')->get();

        return view('payments.index',compact('payments'));

    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // Validate the request
        $validatedData = $request->validate([
            'parent_names' => 'required|string|max:255',
            'child_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today',
        ]);

        // Determine payment status
        $status = $this->determinePaymentStatus($validatedData['due_date']);

        // Create the payment
        $payment = Payment::create([
            'parent_names' => $validatedData['parent_names'],
            'child_name' => $validatedData['child_name'],
            'amount' => $validatedData['amount'],
            'due_date' => $validatedData['due_date'],
            'status' => $status,
            'created_by' => Auth::id()
        ]);

        // Optionally send confirmation email
        $this->sendPaymentConfirmationEmail($payment);

        // Return response
        return response()->json([
            'message' => 'Payment added successfully',
            'payment' => $payment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
