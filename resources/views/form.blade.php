<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
    @csrf
    
        @if (session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        <input style="margin-top: 30px;" type="email" name="email" placeholder="Mail du destinataire">
        <textarea name="message" placeholder="Message"></textarea>
        <input type="file" name="image">
  
        @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <input type="submit" value="Envoyer le message">
    </form>
</body>
</html>