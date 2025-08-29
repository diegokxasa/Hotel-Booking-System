<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AdminController::class, 'home']);
Route::get('/home', [AdminController::class, 'index'])->name('home');

// --- Rooms (Admin only) ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/create_room', [AdminController::class, 'create_room']);
    Route::post('/add_room', [AdminController::class, 'add_room']);
    Route::get('/View_room', [AdminController::class, 'View_room']);
    Route::get('/room_delete/{id}', [AdminController::class, 'room_delete'])->name('room_delete');
    Route::get('/room_update/{id}', [AdminController::class, 'room_update'])->name('room_update');
    Route::post('/room_update/{id}', [AdminController::class, 'room_update_confirm'])->name('room_update_confirm');
});

// --- Room details & Booking (Public) ---
Route::get('/room_details/{id}', [HomeController::class, 'room_details']);
Route::post('/add_booking/{id}', [HomeController::class, 'add_booking']);

// --- Bookings (Admin only) ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::delete('/bookings/{id}', [AdminController::class, 'destroy'])->name('booking_delete');
    Route::patch('/bookings/{id}/approve', [AdminController::class, 'booking_approve'])->name('booking_approve');
    Route::patch('/bookings/{id}/reject', [AdminController::class, 'booking_reject'])->name('booking_reject');
});

// --- Gallery (Admin only) ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/View_gallery', [AdminController::class, 'View_gallery']);
    Route::post('/upload_gallery', [AdminController::class, 'upload_gallery']);
    Route::delete('/delete_gallery/{id}', [AdminController::class, 'delete_gallery']);
});

// --- Contact / Messages ---
Route::get('/contact', [HomeController::class, 'contact']);
Route::post('/contact', [HomeController::class, 'submitContact']);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/all_messages', [AdminController::class, 'all_messages'])->name('all_messages');
    Route::delete('/message_delete/{id}', [AdminController::class, 'message_delete'])->name('message_delete');
    Route::get('/send_mail/{id}', [AdminController::class, 'showMailForm'])->name('send_mail.form');
    Route::post('/send_mail/{id}', [AdminController::class, 'sendMail'])->name('send_mail.send');
});

// --- Payment (Stripe) ---
Route::post('/booking/create-payment-intent/{room}', [PaymentController::class, 'createPaymentIntent'])
    ->name('booking.create_payment_intent');

// --- GitHub Social Login ---
Route::get('auth/github', function () {
    return Socialite::driver('github')->redirect();
})->name('github.login');

Route::get('auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    $user = User::updateOrCreate([
        'email' => $githubUser->getEmail(),
    ], [
        'name' => $githubUser->getName() ?? $githubUser->getNickname(),
        'github_id' => $githubUser->getId(),
        'avatar' => $githubUser->getAvatar(),
    ]);

    Auth::login($user);

    return redirect('/home');
});
