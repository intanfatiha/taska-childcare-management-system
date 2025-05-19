<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ParentRecord;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
          // Fetch payments with relationships for display
        $payments = Payment::with(['child', 'parentRecord'])
                    ->orderBy('payment_duedate', 'desc')
                    ->get();

        // Update payment statuses before displaying
        foreach ($payments as $payment) {
            $this->updatePaymentStatus($payment);
        }

        return view('payments.index',compact('payments'));

    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
     // Get all children with their parent record and related parent models
    $children = \App\Models\Child::with(['parentRecord.father', 'parentRecord.mother', 'parentRecord.guardian'])->get();

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

    // Optionally sort children alphabetically
    usort($formattedChildren, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });

    return view('payments.create', compact('formattedChildren', 'parentsByChild', 'parentRecordIdByChild'));

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
            'user_id' => null, // As per requirement
            'child_id' => $validatedData['child_id'],
            'parent_id' => $validatedData['parent_id'],
            'payment_amount' => $validatedData['payment_amount'],
            'payment_duedate' => $validatedData['due_date'],
            'payment_status' => 'pending',
            'bill_date' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('payments.index')
                         ->with('message', 'Payment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
         $this->updatePaymentStatus($payment);
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
        //
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
}
