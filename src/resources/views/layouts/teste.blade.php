<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESTE</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    @livewireScripts
</head>
<body>
    @yield('body')
</body>
</html>