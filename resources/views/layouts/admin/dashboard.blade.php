<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('common.common_header');
   </head>

   <body>
      @include('shared.admin.header');

      @include('shared.admin.sidebar')
      <main id="main" class="main">
         <div class="loading loader" style="display: none;">Loading&#8230;</div>
         @yield('content')
      </main>

      @include('shared.admin.footer')
      @yield('scripts')
   </body>
</html>
