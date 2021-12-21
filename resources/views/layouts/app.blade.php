<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <script
        src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}">
    <script src="{{ asset('js/semantic.min.js') }}"></script>
</head>
<body class="font-sans antialiased">
<div class="ui container">
    @include('layouts.navigation')
</div>
@php($currentUrl = Request::segment(1))
@if($currentUrl != null)
    <div class="ui container">
        {{$slot}}
    </div>
@else
    <div id="background" style="background-image: url({{asset('img/img-decor-01.jpg')}}); ">
        <div class="ui container">
            <h1 style="color: white; text-align: center; padding: 250px 0 0; font-size: 50px  ">MarkerPlace Parser.</h1>
            <h1 style="color: #726397; text-align: center">Version 0.1</h1>
        </div>
    </div>
@endif
</body>
</html>
<style>
    #background {
        height: 100%;
        display: flex;
        flex-direction: column;
        background-size: cover;
        background-attachment: fixed;
    }
</style>
