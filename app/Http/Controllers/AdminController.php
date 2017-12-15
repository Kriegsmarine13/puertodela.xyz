<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('adm');
    }
    
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
        $newsBody = $_POST['maintext'];
        $imgFolder = 'resources/news_images/';
        $date = date("Y-m-d H:i:s");

        $imageReady = $imgFolder . basename($_FILES['image']['name']);
        $imageFileType = pathinfo($imageReady, PATHINFO_EXTENSION);


        if(move_uploaded_file($_FILES['image']['tmp_name'],$imageReady))
        {
            $sql = DB::table('news')->insert(
                ['id' => 0,
                    'url' => $url,
                    'title' => $title,
                    'news_text' => $newsBody,
                    'img' => $imageReady,
                    'time' => $date]
            );
            header('Refresh: 3; url=/admin/main');
            echo "Файл загружен! Возврат на главную страницу...";
        } else {
            header('Refresh: 3; url=/admin/add-news');
            echo "Запрос не ушёл";
        }
    }

    public function basicInfo()
    {
        $phpVer = phpversion();
        $results = DB::select( DB::raw("select version()"));
        $mysqlVersion = $results[0]->{'version()'};
        return view('admin.info',['phpVer'=>$phpVer,'mysqlVersion'=>$mysqlVersion]);
    }

}