<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="StegAdventure, the game designed to give students an introduction
        to the topic of steganography, while having fun. Perfect for students learning
        about cybersecurity without preknowledge on steganography.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>StegAdventure</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div id="app"></div>
    @vite('resources/js/app.js')
</body>

</html>
