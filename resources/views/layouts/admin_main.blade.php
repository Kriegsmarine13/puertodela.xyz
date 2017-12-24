<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/resources/css/admin.css">
</head>
<body>
<h1>Welcome, {{Session::get('login')}}<a href="logout">Log out</a><br></h1>

<div class="admin_navigation">
    <ul>Меню
        <li><a href="/admin">Главная Страница</a></li>
        <li><a href="/admin/add-news">Добавить статью</a></li>
        <li><a href="/admin/news-list">Список статей</a></li>
    </ul>
</div>
@yield('navigation')
@yield('add_news_form')
@yield('status')
@yield('news_list')
</body>
</html>