<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no ">
    <title><?php echo env('APP_NAME')?></title>
    @include('includes.header-code')
    @include('includes.analytics')
    @yield('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body style="overflow-x:hidden">
    <div class=main>
        @include('includes.head-bar')
        @yield('main_content')
        @include('includes.foot-bar')
        @include('includes.footer-code')
    </div>
    @yield('js')
</body>
</html>