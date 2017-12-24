<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class MainController extends Controller
{

    public function getIndex()
    {
        $metrics = $this->includeMetrics();
        $top = $this->topFeed();

        $sql = DB::table('news')->where('active', '=', 1)->get();
        return view('main.index',[
            'metrics'=>$metrics,
            'data'=>$sql,
            'top'=>$top
        ]);
    }

    public function getNews($url)
    {
        $metrics = $this->includeMetrics();

        //Находим новость по url
        $uri = $_SERVER['REQUEST_URI'];
        $uri = explode('/', $uri);
        $url = array_pop($uri);
        //На случай природного дебилизма постящего
        //Если в url вставлен пробел, в искомой строке меняем юникод на пробел
        $url = str_replace('%20', ' ', $url);

        $data = DB::table('news')->where('url','=',$url)->get();

        return view('main.single',[
            'metrics' => $metrics,
            'data' => $data
        ]);

    }

    public function getTest()
    {
//        $name = 'jopa';
        $sql = DB::table('news')->get();

        return view('main.index')->with(['name'=>$sql]);
    }
    
    public function getGDInfo(Request $request)
    {
        $inf = gd_info();
        return $inf;
    }

    public function includeMetrics()
    {
        $yandexMetrika = "<script type=\"text/javascript\" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter46807620 = new Ya.Metrika({
                    id:46807620,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName(\"script\")[0],
            s = d.createElement(\"script\"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = \"text/javascript\";
        s.async = true;
        s.src = \"https://mc.yandex.ru/metrika/watch.js\";

        if (w.opera == \"[object Opera]\") {
            d.addEventListener(\"DOMContentLoaded\", f, false);
        } else { f(); }
    })(document, window, \"yandex_metrika_callbacks\");
</script>
<noscript><div><img src=\"https://mc.yandex.ru/watch/46807620\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript>";

        $googleAnalytics = "<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-110294187-1\"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-110294187-1');
    </script>";

        return view('metrika.metrics',['yandex_metrika'=>$yandexMetrika, 'google_analytics'=>$googleAnalytics]);
    }

    public function recieveRates($url)
    {

        $rating = DB::table('news')->where('url',$url)->select('rating')->get();

        return $rating;
    }

    public function postVote($url)
    {
        //Проверка аутентификации для голосования
        if(!Auth::user()){
            echo "Зарегистрируйтесь, чтобы голосовать!";
            die;
        }

        $vote = $_POST['data'];
        $uId = $_POST['id'];

        //Получаем id записи для фиксации голосований
        $sql = DB::table('news')->where('url',$url)->get();
        foreach($sql as $query)
        {
            $aId = $query->id;
        }

        //ОСТОРОЖНО, КОСТЫЛЬНАЯ МАГИЯ, ОПАСНО!
        //Дела такие
        //Проверяем, есть ли запись о том, что конкретный пользователь голосовал в конкретной статье
        $exists = DB::table('votings')->where([['article_id',$aId],['user_id',$uId]])->get();
        //Если нет, то добавляем запись о голосовании
        if(!$exists){
            DB::table('votings')->insert([
                'id' => 0,
                'article_id' => $aId,
                'user_id' => $uId
            ]);
        }

        //Спектакль инвалидности, акт 2
        //Достаем из таблицы с голосами id текущей статьи и передаем его дальше
        $getVoting = DB::table('votings')->where('article_id',$aId)->get();
        foreach($getVoting as $item){
            $newVote = $item->voting;
        }

        //Цирк уродов, акт 3
        //Изначально запись о голосовании создается со значением $voting = 0
        //Соответственно, чтобы избежать повторных голосований, это значение не должно превышать 1 или -1
        //И мы получаем, что 0 = человек не голосовал или отменил свой голос, 1 = +, -1 = -
        //Если человек голосует +
        if($vote == 'upvote')
        {
            //и превышает лимиты по голосованию
            if($newVote + 1 > 1)
            {
                //Оповещаем
                echo "Вы уже голосовали! Текущий Рейтинг: ";
            } else {
                //В ином случае +1 в общий рейтинг и +1 к его статусу голосования
                DB::table('news')->where('url', '=', $url)->increment('rating');
                DB::table('votings')->where('article_id',$aId)->increment('voting');
            }
        } elseif ($vote == 'downvote')
            //для минусования то же самое
        {
            //Смотрим, не превышает ли лимитов
            if($newVote - 1 < -1)
            {
                //Оповещаем, если да
                echo "Вы уже голосовали! Текущий Рейтинг: ";
            } else {
                //Декрементируем в обе таблицы
                DB::table('news')->where('url', '=', $url)->decrement('rating');
                DB::table('votings')->where('article_id',$aId)->decrement('voting');
            }
        }

        //после голосования добавляем запись в таблицу учета голосов


        $rating = $this->recieveRates($this->url());
        foreach($rating as $rate){
            $newRating = $rate->rating;
        }
        echo $newRating;
    }

    public function topFeed()
    {
        $sql = DB::table('news')->orderBy('rating','desc')->limit(5)->get();

        return view('main.header',[
            'top' => $sql
        ]);
    }

    public function url()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = explode('/', $uri);
        $url = array_pop($uri);

        return $url;
    }

}