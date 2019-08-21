<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

// 使用类

use App\Http\Controllers\Controller;

// 登录控制器
class LoginController extends Controller
{
    // 登录页

    public function index(){

        // 获取上一个页面

        session(['prevPage'=>$_SERVER['HTTP_REFERER']]);

        // 登陆页面

        return view("home.login");
    }
    // 处理登录

    public function check(Request $request){

        // 接收数据

        $email=$request->input("email");
        $pass=$request->input("pass");

        // 取数据库中进行查询

        $data=\DB::table("user")->where("email","$email")->first();
        // 判断数据是否存在

        if ($data) {
            # code...
            // 判断密码是否正确

            if ($pass==\Crypt::decrypt($data->pass)) {

                session(['lenovoHomeUserInfo.email'=>$data->email]);
                session(['lenovoHomeUserInfo.name'=>$data->name]);
                session(['lenovoHomeUserInfo.id'=>$data->id]);
                # code...
                return redirect(session('prevPage'));
            }else{
                return back();
            }
        }else{
            return back();
        }
    }
    // 退出的方法
    public function logout(Request $request){
        $request->session()->flush();

        return redirect('/');
    }


}
