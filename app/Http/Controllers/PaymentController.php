<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $payments = [
            [
                'id' => 1,
                'title' => 'November Monthly Fees',
                'parent_names' => 'Nuraidah & Azwan',
                'children_names' => 'Sarah Qistina',
                'total_amount' => 500.00,
                'due_date' => '2023-12-31',
                'status' => 'Pending'
            ],
            [
                'id' => 2,
                'title' => 'December Monthly Fees',
                'parent_names' => 'Ahmad & Sarah',
                'children_names' => 'Ali Ahmad',
                'total_amount' => 450.00,
                'due_date' => '2024-01-31',
                'status' => 'Paid'
            ],
            [
                'id' => 3,
                'title' => 'Registration Fees',
                'parent_names' => 'John & Mary',
                'children_names' => 'James Smith',
                'total_amount' => 200.00,
                'due_date' => '2024-01-15',
                'status' => 'Pending'
            ]
        ];

        return view('payments.index', compact('payments'));
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
        //
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
