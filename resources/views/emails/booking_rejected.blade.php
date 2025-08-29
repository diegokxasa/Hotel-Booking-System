<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Rejected</title>
</head>
<body>
    <h2>Hello {{ $booking->name }}</h2>
    <p>Unfortunately, your booking request has been <strong style="color: red;">rejected ❌</strong>.</p>
    <p>If you believe this is a mistake, please contact our support.</p>

    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
