<!DOCTYPE html>
<html>
@minify('html')
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta content='true' name='HandheldFriendly'/>
    <meta content='width' name='MobileOptimized'/>
    <meta content='yes' name='apple-mobile-web-app-capable'/>

    @yield('seo_tags')
   
</head>
<body>
<!--ALL!-->
<div class="all">
    @include('partials.header')
    @yield('main')
    <div class="empty_footer"></div>
</div>

@include('partials.footer')

@endminify
</body>
</html>
