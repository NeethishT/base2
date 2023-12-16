<!doctype html>
<html lang="en">
   @include('partials.dashboard-header')
   <body>
      <div class="loading-modal"></div>
      <div class="page">
         @include('partials.dashboard-nav')
         <div class="page-wrapper">
            @include('partials.page-header')
            <div class="page-body">
               <div class="container-xl">
                  <div class="row row-deck row-cards">
                     @include('partials.messages')
                     @yield('content')
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="{{ Vite::asset('resources/js/app.js') }}"></script>
      @yield('scripts')
   </body>
</html>