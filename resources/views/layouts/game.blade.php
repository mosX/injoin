<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">

        @section('css')
            <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <link href="/css/main.css" rel="stylesheet" type="text/css"/>
            <link href="/css/header.css" rel="stylesheet" type="text/css"/>
        @show
        
        @section('js')
            <script src="/js/angular.min.js" type="text/javascript"></script>
            <script src="/js/jquery.js" type="text/javascript"></script>
            <script src="/js/bootstrap.min.js" type="text/javascript"></script>
            
            <script src="/js/main.js" type="text/javascript"></script>
        @show
        
        <title>
            @section('title') 
                Travel 
            @show
        </title>
    </head>

    <body ng-app="app">
        <script>
            var app = angular.module('app', []);
        </script>
        @section('header')
            @include('helpers.header')
        @show
        <div class="content">
            
            @section('sidebar')
                @include('helpers.sidebar')
            @show

            <div class="sub-content">
                <div class="maincontent">
                    @yield('content')
                </div>
            </div>
        </div>

        
    </body>
</html>
