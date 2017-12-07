<!DOCTYPE html>
<html>
<head>
@yield('meta')
    <title>Create your meme!</title>
    <script type="text/javascript" src="https://vk.com/js/api/share.js?95" charset="windows-1251"></script>
</head>
<body>
<div style="text-align: center;display:block;">
    Страница создания ваших мемчиков<br>
    Загрузи картиночку в формате JPEG, GIF или PNG и РАЗМЕРОМ НЕ БОЛЕЕЕ 800х800 пикселей<br>
    А ещё не тяжелее 500кб
</div>
@yield('picture')
<form action="/meme" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <br>Выбери картиночку:<input type="file" name="meme"><br>
    <br><label for="meme_text">Напиши текст:<input type="text" name="meme_text"></label><br>
    <br><label for="font">Выбери шрифт<select name="font">
            <optgroup label="English">
                <option value="IHATCS">I hate Comic Sans</option>
                <option value="HelveticaStruggleRegular">Helvetica Struggle</option>
                <option value="Times New Romance">Times New Romance</option>
            </optgroup>
            <optgroup label="English\Russian">
                <option value="ansellarist">Cansellarist</option>
                <option value="ds_vtcorona_cyr">DS Vtcorona Cyr</option>
                <option value="moonchild">Moon Child</option>
            </optgroup>
        </select></label><br>
    <br><label for="color">Выбери цвет<select name="color">
            <option value="white">Белый</option>
            <option value="black">Чёрный</option>
            <option value="red">Красный</option>
            <option value="yellow">Жёлтый</option>
        </select></label><br>
    <br><input type="submit" value="Получить мемас">
</form>
@yield('social_networks')
</body>
</html>