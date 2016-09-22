<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">

        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/css/main.css" rel="stylesheet" type="text/css"/>
        <link href="/css/header.css" rel="stylesheet" type="text/css"/>
        
        <script src="/js/jquery.js" type="text/javascript"></script>
        <script src="/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/js/main.js" type="text/javascript"></script>
        
        <title>
            @section('title') 
                Travel 
            @show
        </title>
    </head>

    <body>
        <div id="wraper">
            @section('header')
                @include('helpers.header')
            @show
            <section class="content">
                @section('sidebar')
                    @include('helpers.sidebar')
                @show

                <div class="sub-content">
                    @yield('content')
                </div>
                <div class="clearfix"></div>
            </section>
        </div>
        <!--
        
        @section('footer')
            @include('helpers.footer')
        @show
        -->
    </body>
</html>
