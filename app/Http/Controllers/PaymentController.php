<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $intent = PaymentIntent::create([
            'amount' => $request->amount,
            'currency' => 'usd',
            // Other payment intent parameters
        ]);

        return response()->json(['client_secret' => $intent->client_secret]);
    }

    public function paymentSuccess()
    {
        return view('payment.success');
    }
}
