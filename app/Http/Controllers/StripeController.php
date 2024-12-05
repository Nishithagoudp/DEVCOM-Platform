<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Payment;
use App\Models\Subscription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;


class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        // Retrieve the form data
        $payableType = $request->input('payable_type');  // 'subscription'
        $payableId = $request->input('payable_id');      // ID of the plan
        $userId = $request->input('user_id');            // User ID
        $amount = $request->input('amount');             // Amount of the payment

        // Initialize the Stripe client
        $stripe = new \Stripe\StripeClient(config('services.stripe.sk'));

        // Create a Stripe Checkout session
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => ['name' => $payableType === 'subscription' ? 'Subscription Plan' : 'Certificate'],
                        'unit_amount' => $amount * 100,  // Convert to cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payment-success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment-cancel'),
        ]);

        // If Stripe session creation is successful, redirect to Stripe checkout page
        if (isset($response->id) && $response->id != '') {
            // Store the transaction data in session for later use
            session()->put('payable_type', $payableType);
            session()->put('payable_id', $payableId);
            session()->put('user_id', $userId);
            session()->put('amount', $amount);

            // Redirect to the Stripe Checkout session URL
            return redirect($response->url);
        } else {
            // If session creation fails, redirect to the cancel route
            return redirect()->route('payment-cancel');
        }
    }

    public function success(Request $request)
    {
        if (isset($request->session_id)) {
            $stripe = new \Stripe\StripeClient(config('services.stripe.sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            // Create the Payment record
            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->product_name = 'name';
            $payment->quantity = 1;
            $payment->amount = session()->get('amount');
            $payment->currency = $response->currency;
            $payment->customer_name = $response->customer_details->name;
            $payment->customer_email = $response->customer_details->email;
            $payment->payment_status = $response->status;
            $payment->payment_methods = "Stripe";
            $payment->user_id = session()->get('user_id');
            $payment->payable_type = session()->get('payable_type');
            $payment->payable_id = session()->get('payable_id');
            $payment->save();

            if (session()->get('payable_type') === 'subscription') {
                // Create the subscription record
                $subscription = Subscription::create([
                    'user_id' => session()->get('user_id'),
                    'plan_id' => session()->get('payable_id'), // The plan ID from the session
                    'start_date' => now(), // Assuming the start date is the current time
                    'end_date' => now()->addMonths(1), // You can adjust the duration as needed
                    'status' => 'active', // Set subscription status to active
                ]);
            }

            // Check if the payment is for a certificate
            if (session()->get('payable_type') === 'certificate') {
                // Create the certificate record
                $certificate = Certificate::create([
                    'user_id' => session()->get('user_id'),
                    'challenge_id' => session()->get('payable_id'), // The challenge_user ID from the session
                    'issued_at' => now(), // Issued at the time of payment
                ]);
            }

            return redirect()->route('home')->with('success', 'Payment was successful!');
        } else {
            return redirect()->route('home')->with('error', 'There was an issue with your payment.');
        }
    }

    public function cancel()
    {
        return "Payment is Canceled";
    }

    public function downloadCertificate($certificateId)
    {
        // Retrieve the certificate record
        $certificate = Certificate::findOrFail($certificateId);

        // Ensure the logged-in user is the owner of the certificate
        if ($certificate->user_id !== Auth::id()) {
            // Optionally, you could redirect with an error message
            return redirect()->route('home')->with('error', 'You are not authorized to view this certificate.');
        }

        // Generate a PDF for the certificate (optional, if you want PDF download)
        $pdf = PDF::loadView('certificates.download', ['certificate' => $certificate]);

        // Return the PDF as a download (optional, if you want PDF download)
        return $pdf->download('certificate_' . $certificate->id . '.pdf');

        // Or, if you're serving an HTML view instead of PDF:
        // return view('certificates.download', ['certificate' => $certificate]);
    }
}
