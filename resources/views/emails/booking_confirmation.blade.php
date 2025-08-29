<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>{{ $greeting }}</h2>
    <p>{{ $body }}</p>

    <p><strong>Booking ID:</strong> {{ $booking_id }}</p>
    <p><strong>Room:</strong> {{ $room }}</p>
    <p><strong>Check-in:</strong> {{ $start_date }}</p>
    <p><strong>Check-out:</strong> {{ $end_date }}</p>
    <p><strong>Total Price:</strong> ${{ $price }}</p>

    <p>{{ $end_line }}</p>
</body>
</html>
