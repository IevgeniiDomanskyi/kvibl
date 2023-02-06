<!doctype html>
<html translate="no">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1.0, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" value="{{ csrf_token() }}" />
        <meta name="google" content="notranslate" />

        <title>Kvibl</title>
        <link href="{{ mix('css/loader.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />

        <script src="https://kit.fontawesome.com/a3f6b0d34f.js" crossorigin="anonymous" SameSite="none Secure"></script>
    </head>

    <body>
        <div id="app">
        </div>

        <div id="loader">
            <span style="animation-delay: 100ms;">K</span>
            <span style="animation-delay: 250ms;">v</span>
            <span style="animation-delay: 400ms;">i</span>
            <span style="animation-delay: 550ms;">b</span>
            <span style="animation-delay: 700ms;">l</span>
        </div>

        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>