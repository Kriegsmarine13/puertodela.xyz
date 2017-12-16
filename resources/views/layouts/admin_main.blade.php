<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/resources/css/admin.css">
</head>
<body>
<h1>Welcome, {{Session::get('login')}}<a href="logout">Log out</a><br></h1>

<div class="admin_navigation">
    <ul>Меню
        <li><a href="/admin">Главная Страница</a></li>
        <li><a href="/admin/add-news">Добавить статью</a></li>
        <li><a href="#">Список статей</a></li>
    </ul>
</div>
@yield('navigation')
@yield('add_news_form')
@yield('status')
</body>
</html>