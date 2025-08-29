<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Approved</title>
</head>
<body>
    <h2>Hello {{ $booking->name }}</h2>
    <p>Your booking request has been <strong style="color: green;">approved ✅</strong>.</p>

    <p><b>Room:</b> {{ $booking->room->room_type ?? 'N/A' }}</p>
    <p><b>Check-in:</b> {{ $booking->start_date }}</p>
    <p><b>Check-out:</b> {{ $booking->end_date }}</p>
    <p><b>Total Price:</b> ${{ $booking->room->price ?? 'N/A' }}</p>

    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
