<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ mix('/css/app.css') }}"/>

        <title>Calendar</title>
    </head>
    <body>
        <div id="calendar">
            @if ($user)
                @php
                    echo '@{{ initUser('.json_encode($user).') }}';
                @endphp
            @endif

            @include('components/auth-form')

            @include('components/calendar')
        </div>
    </body>

    <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
</html>