<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">

        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/css/main.css" rel="stylesheet" type="text/css"/>
        <link href="/css/header.css" rel="stylesheet" type="text/css"/>
        <link href="/css/sweetalert.css" rel="stylesheet" type="text/css"/>
        
        
        <script src="/js/angular.min.js" type="text/javascript"></script>
            
        <script src="/js/jquery.js" type="text/javascript"></script>
        <script src="/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/js/sweetalert.min.js" type="text/javascript"></script>
        <script src="/js/main.js" type="text/javascript"></script>
        
        <title>
            @section('title') 
                Travel 
            @show
        </title>
    </head>

        
    <body ng-app="app" >
<script>
/*$('document').ready(function(){
console.log('34234234');
swal("Here's a message!")
});*/
</script>
        <script>
            var app = angular.module('app', []);
        </script>
        @section('header')
           @include('helpers.header')
        @show
        
        @section('bannercontent')
            @include('helpers.bannercontent')
        @show
        
        @yield('content')
        
        @section('footer')
            @include('helpers.footer')
        @show
    </body>
</html>
