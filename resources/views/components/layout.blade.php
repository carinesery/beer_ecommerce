<!doctype html>
<html lang="en">
<head>    
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Bière en ligne' }}</title> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- Ajout navbar --}}
    <x-navbar></x-navbar>
    
    {{ $slot }}
    
    {{-- Ajout footer --}}
</body>
</html>