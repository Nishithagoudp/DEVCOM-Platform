<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        // Start with the query for all payments
        $query = Payment::query();

        // Filter by user if specified
        if ($request->has('user') && $request->user) {
            $query->where('user_id', $request->user);
        }

        // Filter by payment status if specified
        if ($request->has('status') && $request->status) {
            $query->where('payment_status', $request->status);
        }

        // Filter by payment method if specified
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_methods', $request->payment_method);
        }

        // Fetch the filtered payments
        $payments = $query->get();

        // Get all users for the filter dropdown
        $users = User::all();


        return view('dashboard.payments.index', compact('payments', 'users'));
    }



    public function edit(Payment $payment)
    {
        // Only allow editing if the user is an admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard.payments.index')->with('error', 'You do not have permission to edit this payment.');
        }

        return view('dashboard.payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the status
        $request->validate([
            'status' => 'required',  // Ensure only valid statuses can be selected
        ]);

        // Find the payment by ID
        $payment = Payment::findOrFail($id);

        // Update the payment status
        $payment->status = $request->input('status');
        $payment->save();

        // Check if the status is 'completed' and the payable type is 'Subscription'
        if ($payment->status === 'completed' && $payment->payable_type === 'subscription') {
            // Find the related Subscription using payable_id
            $subscription = Subscription::find($payment->payable_id);

            if ($subscription) {
                // Update the subscription status to 'Active'
                $subscription->status = 'Active';
                $subscription->save();
            }
        }

        // Check if the status is 'completed' and the payable type is 'Certificate'
        if ($payment->status === 'completed' && $payment->payable_type === 'certificate') {
            // Find the related Challenge using payable_id
            $certificate = Certificate::find($payment->payable_id);

            if ($certificate) {
                // If certificate entry exists, you can do something with it if needed
                // Example: Optionally update or log that the payment has been completed for the certificate
                $certificate->issued_at = now(); // Optionally set the issue date
                $certificate->save();
            }
        }

        // Redirect to the payments index page with a success message
        return redirect()->route('payments.index')->with('success', 'Payment status updated successfully.');
    }

    public function show($id)
    {
        // Fetch the payment record
        $payment = Payment::findOrFail($id);

        // Get the related payable details (Subscription or Certificate)
        $payableDetails = $payment->getPayableDetails();

        return view('dashboard.payments.show', compact('payment', 'payableDetails'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
