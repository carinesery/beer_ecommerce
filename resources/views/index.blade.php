<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <h1>Welcome</h1>
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        @foreach ($users as $user)
                <span>{{ $user->firstname }}</span> <br>
        @endforeach
    </div>
    
</body>
</html>