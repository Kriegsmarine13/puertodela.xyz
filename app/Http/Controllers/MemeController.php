<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class MemeController extends Controller {

    const TARGET_IMG = 3;
    const TARGET_FOLDER = 2;
    
    public function getIndex(){
        return view('layouts.meme');

    }

    public function getImg($id){
        //Находим изображение в ссылке
        $uri = $_SERVER['REQUEST_URI'];
        $uriRaw = explode('/',$uri);
        $uri = $uriRaw[self::TARGET_FOLDER].'/'.$uriRaw[self::TARGET_IMG].'.jpg';

        //Делаем запрос к базе на наличие такого изображения
        $getImg = DB::connection('mysql')->select('select * from memegen where img=?', [$uri]);

        //Получаем из массива
        $data[] = (array)$getImg[0];

        //Создаем кнопки соц сетей
        $buttons = $this->mediaButtons($uriRaw[self::TARGET_IMG]);
        return view('meme.index',['pic'=>$data[0]['img'],'buttons'=>$buttons]);
    }

    public function postIndex() {
        $source = $_FILES['meme']['tmp_name'];
        //Проверка размера
        if(getimagesize($source)[0] > 800 || getimagesize($source)[1] > 800 || $_FILES['meme']['size'] > 500000) {
            echo "Файл слишком большой или тяжелый! Смотри внимательнее, что загружаешь!";
        } else {
            $uploadDir = 'img/'; //Устанавливаем директорию для изображений
            $img = $uploadDir.mb_substr(hash('sha512',basename($_FILES['meme']['name']).time()),12,18).'.jpg';

            //Задаем основные параметры для изображения: шрифт, текст, присваиваем хеш(?), размер шрифта
            //неработающий align, ширину в которую пишется текст и смещение по осям Х и У от верхнего левого угла
            $font = 'resources/fonts/'.$_POST['font'].'.ttf';
            $text = $_POST['meme_text'];
            $font_size = 36;
            $align = "left";
            $width = getimagesize($_FILES['meme']['tmp_name'])[0] - 10;
            $x = getimagesize($_FILES['meme']['tmp_name'])[0] - (getimagesize($_FILES['meme']['tmp_name'])[0] / 100 * 99);
            $y = getimagesize($_FILES['meme']['tmp_name'])[1] - (getimagesize($_FILES['meme']['tmp_name'])[1] / 100 * 85);

            //Цикл, определяющий формат изображения
            switch(getimagesize($source)['mime']){
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($source);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($source);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($source);
            }

            //Определяем нужный цвет текста
            switch($_POST['color']){
                case 'black':
                    $color = imagecolorallocate($image, 0,0,0);
                    break;
                case 'white':
                    $color = imagecolorallocate($image,255,255,255);
                    break;
                case 'red':
                    $color = imagecolorallocate($image, 255,0,0);
                    break;
                case 'yellow':
                    $color = imagecolorallocate($image, 255,255,0);
            }

            //Когда все проверки пройдены, перемещаем файл в папку и делаем запись в БД
            if(move_uploaded_file($source,$img)) {
                $sql = DB::connection('mysql')->insert('insert into memegen(id, img, text, font, color) VALUES (0,?,?,?,?)', [$img, $text, $font, $color]);

                //Здесь идёт чудесная чужая магия, призванная переносить текст, если он не влезает в картинку
                //Работает через жопу, только для выравнивания по левому краю
                $arr = explode(' ', $text);
                $ret = "";
                foreach ($arr as $word) {
                    $tmp_string = $ret . ' ' . $word;
                    $textbox = imagettfbbox($font_size, 0, $font, $tmp_string);
                    if ($textbox[2] > $width) {
                        $ret .= ($ret == "" ? "" : "\n") . $word;
                    } else {
                        $ret .= ($ret == "" ? "" : " ") . $word;
                    }
                }

                if ($align == "left") {
                    imagettftext($image, 36, 0, $x, $y, $color, $font, $ret);
                } else {
                    $arr = explode("\n", $ret);
                    $height_tmp = 0;
                    foreach ($arr as $str) {
                        $testbox = imagettfbbox($font_size, 0, $font, $str);
                        if ($align == "center") {
                            $left_x = round(($x - ($testbox[2] - $testbox[0])) / 2);
                        } else {
                            $left_x = round($x - ($testbox[2] - $testbox[0]));
                        }
                        imagettftext($image, 36, 0, $x + $left_x, $y + $height_tmp, $color, $font, $str);
                        $height_tmp = $height_tmp + 5;
                    }
                }

                imagejpeg($image, $img, 99);
                imagedestroy($image);
                //Берём путь к изображению, отделяем от расширения и перенаправляем на готовое изображение
                $img = explode('.',$img);
                $img = array_shift($img);
                return redirect()->to("/meme/$img");
            }
        }
    }

    public function mediaButtons($img){
        $vkButton = "<br><script type=\"text/javascript\">document.write(VK.Share.button({url: \"http://puertodela.xyz/meme/img/". $img .
            "\",title:\"Create Your Meme!\" ,image: \"http://puertodela.xyz/img/". $img ."\",noparse:false},{type: \"round\", text: \"Поделиться\"}));</script>";

        $fbButton = "<iframe src=\"https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Fpuertodela.xyz%2Fmeme%2Fimg%2F" .
        $img . "&layout=box_count&size=small&mobile_iframe=true&width=95&height=40&appId\" width=\"95\" height=\"40\" style=\"border:none;overflow:hidden\" scrolling=\"no\" frameborder=\"0\" allowTransparency=\"true\"></iframe>";

        $twiButton = "<iframe
                  src=\"https://platform.twitter.com/widgets/tweet_button.html?size=l&url=http%3A%2F%2Fpuertodela.xyz%2Fmeme%2Fimg%2F" . $img .
                "&text=Meme%20Creator%20Example&hashtags=ineedajob%2Cplease\"
                width=\"140\"
                height=\"40\"
                title=\"Twitter Tweet Button\"
                style=\"border: 0; overflow: hidden;\">
                   </iframe>";

        return view('meme.share',['vkButton'=>$vkButton, 'fbButton'=>$fbButton,'twiButton'=>$twiButton]);
    }


}