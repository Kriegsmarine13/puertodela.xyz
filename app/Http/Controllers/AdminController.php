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

        $sql = DB::connection('mysql')->select('SELECT * FROM administration where login=?',[$login]);
        $data[] = (array)$sql[0];
        $check = $data[0]['password'];
        if(password_verify($pass,$check))
        {
            Session::put('login', $data[0]['login']);
            setcookie('adminAuth',hash('sha256',$login.time()),time() + 60 * 60 * 24,'/','puertodela.xyz');
            return redirect()->to('/admin/main');
        }
    }

    public function getMain(Request $request)
    {
        $login = $request->session()->get('login');
        return view('admin.index',['login'=>$login]);
    }

    public function basicInfo()
    {
        $phpVer = phpversion();
        $mysqlVersion = mysql_get_server_info();
        return view('admin.info',['phpVer'=>$phpVer,'mysqlVersion'=>$mysqlVersion]);
    }
}