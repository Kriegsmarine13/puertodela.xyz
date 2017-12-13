<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/resources/admin.css">
    </head>
    <body>
        <h1>Welcome, {{Session::get('login')}}</h1><br>
        @yield('navigation')
        @yield('status')
    </body>
</html>