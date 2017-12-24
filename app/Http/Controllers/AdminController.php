<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class AdminController extends Controller
{
    const DEFAULT_ACTIVE_STATE = 1;

    public function __construct()
    {
        $this->middleware('adm');
    }

    //Routes
    
    public function getIndex()
    {
        return view('layouts.admin_page');
    }
    
    public function postIndex()
    {
        $login = $_POST['login'];
        $pass = $_POST['password'];

//        $sql = DB::connection('mysql')->select('SELECT * FROM administration where login=?',[$login]);
        $sql = DB::table('administration')->where('login',$login)->first();
        $password = $sql->password;
        if(password_verify($pass,$password))
        {
            Session::put('login', $login);
            setcookie('adminAuth',hash('sha256', time()),time() + 60 * 60 * 24,'/','puertodela.xyz');
            return redirect()->to('/admin/main');
        } else {
            header('Refresh: 5; Location: /admin');
            echo "Wrong password!";
        }
    }

    public function getMain(Request $request)
    {
        $info = $this->basicInfo();
        $login = $request->session()->get('login');
        return view('layouts.admin_main',['login'=>$login,'info'=>$info]);
    }

    public function getLogout()
    {
        $logout = setcookie('adminAuth', '', time() - 60 * 60 * 24, '/', 'puertodela.xyz');
        if($logout)
        {
            header('Location: /admin');
            echo "Logged out! Refreshing...";
        } else{
            echo "Logout error!";
        }
    }

    public function getAddNews()
    {
        return view('admin.add_news');
    }

    public function postAddNews()
    {
        $title = $_POST['title'];
        $url = $_POST['url'];
        $url = str_replace(' ', '-',$url);
        $newsBody = $_POST['maintext'];
        $imgFolder = 'resources/news_images/';
        $date = date("Y-m-d H:i:s");
        $active = self::DEFAULT_ACTIVE_STATE;
        $theme = $_POST['theme'];

        $imageReady = $imgFolder . basename($_FILES['image']['name']);
//        $imageFileType = pathinfo($imageReady, PATHINFO_EXTENSION);


        if(move_uploaded_file($_FILES['image']['tmp_name'],$imageReady))
        {
            $sql = DB::table('news')->insert(
                [
                    'url' => $url,
                    'title' => $title,
                    'news_text' => $newsBody,
                    'img' => $imageReady,
                    'time' => $date,
                    'active' => $active,
                    'main_theme' => $theme]
            );
            header('Refresh: 3; url=/admin/main');
            echo "Файл загружен! Возврат на главную страницу...";
        } else {
            header('Refresh: 3; url=/admin/add-news');
            echo "Запрос не ушёл";
        }
    }

    public function getNewsList()
    {
        $sql = DB::table('news')->get();

        return view('admin.news_list',[
            'data' => $sql
        ]);
    }

    public function getEditNews($url)
    {
        $url = $this->getUri();

        $sql = DB::table('news')->where('url', '=', $url)->get();

        return view('admin.add_news', [
           'data' => $sql
        ]);
    }

    public function postEditNews()
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $url = $_POST['url'];
        $url = str_replace(' ', '-',$url);
        $newsBody = $_POST['maintext'];
        $imgFolder = 'resources/news_images/';
        $date = date("Y-m-d H:i:s");
        $active = self::DEFAULT_ACTIVE_STATE;
        $theme = $_POST['theme'];

        $imageReady = $imgFolder . basename($_FILES['image']['name']);

        if(!empty($_FILES['image']))
        {
            if(move_uploaded_file($_FILES['image']['tmp_name'],$imageReady))
            {
                $imgQuery = DB::table('news')->where('id','=',$id)->update(
                    [
                        'url' => $url,
                        'title' => $title,
                        'news_text' => $newsBody,
                        'img' => $imageReady,
                        'time' => $date,
                        'active' => $active,
                        'main_theme' => $theme]
                );
                header('Refresh: 3; url=/admin/news-list');
                echo "Новость обновлена вместе с изображением! Перенаправление...";
            } else {
                echo "Ошибка обновления изображения!";
            }
        } else {
            $imgQuery = DB::table('news')->where('id','=',$id)->update(
                [
                    'url' => $url,
                    'title' => $title,
                    'news_text' => $newsBody,
                    'time' => $date,
                    'active' => $active,
                    'main_theme' => $theme
                ]);
            header('Refresh: 3; url=/admin/news-list');
            echo "Новость обновлена! Перенаправление...";
        }
    }

    public function getDeactivate($url)
    {
        $url = $this->getUri();

        $sql = DB::table('news')->where('url','=',$url)->update([
            'active' => 0
        ]);

        if($sql)
        {
            header('Refresh: 3; url= /admin/news-list');
            echo "Новость деактивирована! Перенаправление...";
        } else { echo "Ошибка! Обратитесь к админу"; }
    }

    public function getActivate($url)
    {
        $url = $this->getUri();

        $sql = DB::table('news')->where('url','=',$url)->update([
            'active' => 1
        ]);

        if($sql)
        {
            header('Refresh: 3; url= /admin/news-list');
            echo "Новость активирована! Перенаправление...";
        } else { echo "Ошибка! Обратитесь к админу"; }
    }

    public function getDelete($url)
    {
        $url = $this->getUri();

        $sql = DB::table('news')->where('url','=',$url)->delete();

        if($sql)
        {
            header('Refresh: 3; url=/admin/news-list');
            echo "Новость удалена! Перенаправление...";
        }
    }

    //work functions

    public function basicInfo()
    {
        $phpVer = phpversion();
        $results = DB::select( DB::raw("select version()"));
        $mysqlVersion = $results[0]->{'version()'};
        return view('admin.info',['phpVer'=>$phpVer,'mysqlVersion'=>$mysqlVersion]);
    }

    public function getUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = explode('/', $uri);
        $url = array_pop($uri);

        return $url;
    }

}