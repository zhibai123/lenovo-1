<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

// 使用类

use App\Http\Controllers\Controller;

// 订单控制器
class OrdersController extends Controller
{
    // 生成订单

    public function index(Request $request){


        // 接收收货地址ID

        $aid=$request->input("aid");

        // 接收

        $ids=$request->input('ids');
        $nums=$request->input('nums');
        $prices=$request->input('prices');

        // 获取用户ID

        $uid=session('lenovoHomeUserInfo.id');

        // 订单号生成

        $code="DZ_".time().rand();

        // 订单生成时间

        $time=time();

        // 生成订单
        for($i=0;$i<count($ids);$i++){

            $data=array();

            $data['code']=$code;
            $data['time']=$time;
            $data['uid']=$uid;
            $data['aid']=$aid;
            $data['sid']=1;
            $data['gid']=$ids[$i];
            $data['num']=$nums[$i];
            $data['price']=$prices[$i];

            \DB::table("orders")->insert($data);
        }

        // 需要删除session中对应数据

        // 获取购物车中所有的商品数据

        $shop=session('shop');

        // 遍历数据

        foreach ($shop as $key => $value) {
            # code...

            foreach ($ids as $k => $v) {
                # code...
                // 判断需要删除的数据

                if ($v==$value['id']) {
                    # code...

                    unset($shop[$key]);
                }
            }
            
        }
        // 写入sessiion
        $request->session()->put('shop', $shop);

        return redirect("pay/$code");
    	
    }

    // 支付页面

    public function pay($code){

        $orders=\DB::table("orders")->where("code",$code)->get();

        return view("home.pay");
    }
}
