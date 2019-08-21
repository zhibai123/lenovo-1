<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

// 使用类

use App\Http\Controllers\Controller;

// 分类页控制器
class TypesController extends Controller
{
    // 分类页

    public function index($id){

        // 查询所有的顶级分类

        $types=\DB::table('types')->where("pid",0)->get();

        // 查询当前分类

        $type=\DB::table("types")->where("id",$id)->first();
        // 将path路径处理成数组

        $arr=explode(',', $type->path);

        $size=count($arr)-1;

        switch($size){
            case '1':
                # code...
                $erClass=\DB::table("types")->where([["path","like","%,$id,%"],['pid','!=',$id]])->get();

                $newArr=array();
                foreach ($erClass as $key => $value) {
                    # code...
                    $newArr[]=$value->id;
                }

                $goods=\DB::table("goods")->whereIn("cid",$newArr)->get();
                break;
            case '2':
                # code...
                $goodsClass=\DB::table("types")->where("pid",$id)->get();

                $newArr=array();
                foreach ($goodsClass as $key => $value) {
                    # code...
                    $newArr[]=$value->id;
                }

                $goods=\DB::table("goods")->whereIn("cid",$newArr)->get();
                break;
            case '3':
                $goods=\DB::table("goods")->where("cid",$id)->get();
                break;
        }


        // 顶级分类

        $ding=$arr[1]?$arr[1]:$id;

        // 加载页面

        // 格式化数据

        $data=array(
            "types"=>$types,
            "ding"=>$ding,
            "goods"=>$goods,

        );

        return view("home.types")->with($data);
    }
}
