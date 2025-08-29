<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Message from Admin</title>
</head>
<body style="font-family:Arial,sans-serif; line-height:1.5; color:#333;">
    <p>{{ $greeting }}</p>
    <p>{{ $body }}</p>

    @if(!empty($action_text) && !empty($action_url))
        <p>
            <a href="{{ $action_url }}" style="display:inline-block; padding:10px 20px; background:#0d6efd; color:#fff; text-decoration:none; border-radius:5px;">
                {{ $action_text }}
            </a>
        </p>
    @endif

    <p>{{ $end_line }}</p>
</body>
</html>
