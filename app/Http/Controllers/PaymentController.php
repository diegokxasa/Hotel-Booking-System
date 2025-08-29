<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{public function createPaymentIntent(Request $request, Room $room)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    $paymentIntent = PaymentIntent::create([
        'amount' => $room->price * 100,
        'currency' => 'usd',
    ]);

    return response()->json([
        'client_secret' => $paymentIntent->client_secret,
        'id' => $paymentIntent->id,
    ]);
}

}
