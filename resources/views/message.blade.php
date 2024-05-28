<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    {{ $message }}

    @if($image)
    <img src="{{ asset('/images/' . $image) }}" alt="Message Photo">
    @endif
</body>
</html>