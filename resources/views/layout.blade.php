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
            @include('components/nav-panel')
            @include('components/auth-form')
            @include('components/register-form')
            @include('components/calendar')
            @include('components/wait-window')
        </div>
    </body>

    <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>

    @if ($user)
        <script type="text/javascript">
            app.initUser(@php echo json_encode($user) @endphp);
        </script>
    @endif
</html>