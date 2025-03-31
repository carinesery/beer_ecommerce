<!doctype html>
<html lang="fr">
<head>    
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'E-commerce de bières' }}</title> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- Ajout navbar --}}
    <x-navbar></x-navbar>
    
    {{ $slot }}
    
    {{-- Ajout footer --}}
</body>
</html>