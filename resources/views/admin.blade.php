<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" value="{{ csrf_token() }}" />
        <title>Admin Panel - Kvibl</title>
        <link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet" type="text/css" />
        <link href="{{ mix('css/admin.css') }}" type="text/css" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/5c946ea839.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div id="app">
        </div>

        <script src="{{ mix('js/admin.js') }}" type="text/javascript"></script>
    </body>
</html>