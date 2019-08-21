<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

// 使用类

use App\Http\Controllers\Controller;

// 后台广告控制器
class AdsController extends Controller
{
    // 广告首页

    public function index(Request $request){

        // 从数据库查询数据

        $data=\DB::table("ads")->orderBy("sort",'desc')->paginate(10);

        // 加载页面

        return view("admin.sys.ads.index")->with("data",$data);

    }

    // 广告添加方法

    public function create(){
        // 加载页面

        return view("admin.sys.ads.add");
    }

    // 广告的处理方法


    public function store(Request $request){
        // 去除字段

        $arr=$request->except("_token");

        // 插入数据库

        if (\DB::table("ads")->insert($arr)) {
            # code...
            return redirect("admin/sys/ads");
        }else{
            return back();
        }
    }

}
