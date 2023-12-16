<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
      <title>@section('title') Home @show | {{{ config('app.name') }}}</title>
      <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" />
   </head>
   <body  class="bg-website d-flex flex-column">
      @yield('content')
   </body>
</html>