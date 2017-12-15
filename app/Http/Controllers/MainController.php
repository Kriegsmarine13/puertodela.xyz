<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MainController extends Controller
{

    public function getIndex()
    {
        $metrics = $this->includeMetrics();

        $sql = DB::table('news')->get();
        return view('main.index',[
            'metrics'=>$metrics,
            'data'=>$sql
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

}