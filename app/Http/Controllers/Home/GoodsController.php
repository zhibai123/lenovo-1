<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

// 使用类

use App\Http\Controllers\Controller;

// 商品页控制器
class GoodsController extends Controller
{
    // 商品页

    public function index($id){

        // 设置cookie


        // 获取商品相关数据
        $goods=\DB::table("goods")->where("id",$id)->first();

        // 商品图片表

        $goodsImg=\DB::table("goodsImg")->where("gid",$id)->get();

        // 查询商品对应品论

        $commentTot=\DB::table("comment")->where("gid",$id)->count();
        $goodTot=\DB::table("comment")->where([['gid','=',$id],["start",">",4]])->count();
        $chaTot=\DB::table("comment")->where([['gid','=',$id],["start","<=",2]])->count();
        $zhongTot=$commentTot-$goodTot-$chaTot;

        $arr=array(
            "commentTot"=>$commentTot,
            "goodTot"=>$goodTot,
            "chaTot"=>$chaTot,
            "zhongTot"=>$zhongTot,

        );



        $comment=\DB::table("comment")->where("gid",$id)->get();

        // 格式化数据

        $data=array(

            "goods"=>$goods,
            "goodsImg"=>$goodsImg,
            "arr"=>$arr,
            "comment"=>$comment,
        );

        // 加载页面

        return view("home.goods")->with($data);
    }
}
