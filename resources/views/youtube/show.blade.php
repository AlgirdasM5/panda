<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>Panda</title>
        <link rel="stylesheet" href="{{ url(elixir('css/app.css')) }}" type="text/css">
    </head>
    <body>
        <div id="app">
            <stats></stats>
        </div>
        <script src="{{ url(elixir('js/app.js')) }}"></script>
    </body>
</html>
