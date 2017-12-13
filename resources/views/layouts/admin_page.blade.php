<!DOCTYPE html>
<html>
    <head>
        <title>PdlK Administration</title>
        {{--<link rel="stylesheet" type="text/css" href="../css/styles.css">--}}
    </head>
    <body>
        <form action="/admin" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <br>Login: <input type="text" name="login" required>
            <br>Password: <input type="password" name="password" required>
            <input type="submit" value="Войти">
        </form>
    </body>
</html>