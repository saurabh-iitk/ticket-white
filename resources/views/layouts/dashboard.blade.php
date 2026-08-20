<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}::@yield('title')</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom Theme CSS -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
      .required {
        color:#ff0000;
      }
    </style>
  	
    <!-- Custom Page Level CSS -->
    @yield('css')
</head>
<body id="body" class="app sidebar-mini rtl">
    <div id="app">
        @include('../partials/navbar')
        
        @include('../partials/sidebar')
        
        @yield('content')
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
  	<script src="{{ asset('js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript">
       $(document).ready(function() {
        $('form').on('submit', function() {
            $(this).find('input[type="submit"], button[type="submit"]').prop('disabled', true);
        });
    });
    </script>
    <!-- Custom Page Level JS -->
    @yield('js')
</body>
</html>
