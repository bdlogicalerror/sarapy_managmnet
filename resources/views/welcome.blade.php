<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sarapy Managment System</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div id="app">
            <vue-progress-bar></vue-progress-bar>

            <router-view></router-view>

        </div>
    </body>
    <script src="{{asset('js/app.js')}}"></script>

</html>
