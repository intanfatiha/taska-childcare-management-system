<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ParentRecord;
use App\Models\Child;
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
          // Retrieve parent records with eager loading of relationships
        $parentRecords = ParentRecord::with(['father', 'mother', 'guardian', 'child'])->get();
        
        // Create array for dropdown
        $formattedParents = [];
        
       
foreach ($parentRecords as $parentRecord) {
    \Log::info('Parent Record ID: ' . $parentRecord->id);
    \Log::info('Guardian: ' . optional($parentRecord->guardian)->guardian_name);
    \Log::info('Father: ' . optional($parentRecord->father)->father_name);
    \Log::info('Mother: ' . optional($parentRecord->mother)->mother_name);
}
        // Process each parent record
        foreach ($parentRecords as $parentRecord) {

            // Determine parent name
            // $parentName = 'No Data';
              $parentName = 'No Data';
            if ($parentRecord->father && $parentRecord->mother) {
                $parentName = $parentRecord->father->father_name . ' & ' . $parentRecord->mother->mother_name;
            } elseif ($parentRecord->guardian) {
                $parentName = $parentRecord->guardian->guardian_name;
            } elseif ($parentRecord->father) {
                $parentName = $parentRecord->father->father_name;
            } elseif ($parentRecord->mother) {
                $parentName = $parentRecord->mother->mother_name;
            }
            
            // Simply store the ID and parent name for the dropdown
            // This is all you need if you're just populating a dropdown
            $formattedParents[] = [
                'id' => $parentRecord->id,
                'parent_name' => $parentName
            ];
            
            // If you still need children data, add it like this:
            /*
            $formattedParents[count($formattedParents)-1]['children'] = [];
            foreach ($parentRecord->child as $child) {
                $formattedParents[count($formattedParents)-1]['children'][] = [
                    'id' => $child->id,
                    'name' => $child->child_name
                ];
            }
            */
        }
        
        // Optionally, you can sort the array by parent name if needed
        usort($formattedParents, function($a, $b) {
            return strcmp($a['parent_name'], $b['parent_name']);
        });
        
        // For debugging (uncomment if needed)
        // dd($formattedParents);
        
        return view('payments.create', compact('formattedParents'));
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
