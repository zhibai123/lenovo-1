<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

// 使用类

use App\Http\Controllers\Controller;

// 后台评论控制器
class CommentController extends Controller
{
    // 评论首页

    public function index(Request $request){

        // 多表查询

        $data=\DB::table("comment")
            ->select("comment.*","goods.title",'goods.img as gimg',"user.name")
            ->join("user","user.id",'=','comment.uid')
            ->join("goods","goods.id",'=','comment.gid')
            ->get();

        // 加载页面

        return view("admin.comment.index")->with("data",$data);
    }

    // ajax修改状态

    public function ajaxStatu(Request $request){

        $arr=$request->except("_token");

        $sql="update comment set statu=$arr[statu] where id=$arr[id]";

        if (\DB::update($sql)) {
            # code...

            return 1;
        }else{
            return 0;
        }

    }

}
