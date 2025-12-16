<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="StegIF is an educational game that introduces students to steganography in a fun and interactive way.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StegIF') }}</title>

    @vite('resources/css/app.css')
</head>

<body>
    <div id="app"></div>
    @vite('resources/js/app.js')
</body>

</html>
