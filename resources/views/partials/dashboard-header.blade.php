<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@section('title') Dashboard @show | {{{ config('app.name') }}}</title>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" />
    <link rel="stylesheet" href="{{ url(asset('css/app.css')) }}" />
</head>