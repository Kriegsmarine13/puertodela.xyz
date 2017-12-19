<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Главная Страница|Пуэрто де ла Куз</title>
        <link href="/resources/css/styles.css" rel="stylesheet" type="text/css">
        <script src="/resources/js/jquery-3.2.1.min.js"></script>
        <script src="/resources/js/masonry.pkgd.min.js" type="text/javascript"></script>
        <script src="/resources/js/rainbow-custom.min.js"></script>
        <link href="/resources/css/rainbow/all-hallows-eve.css" type="text/css" rel="stylesheet">
        @yield('metrics')
    </head>
    <body>
        @yield('header')
        @yield('top-news')
        <div class="grid">
            @yield('content')
            @yield('single')
        </div>
        <script>
            $('div.grid').masonry({
                columnWidth: 'div.article_main',
                itemSelector: 'div.article_main'
            });
        </script>
    </body>

</html>