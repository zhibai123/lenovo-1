<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

// 使用类

use App\Http\Controllers\Controller;

// 购物车控制器
class CarController extends Controller
{
	// 购物车页

	public function index(){

		// 把sessiion中的商品获取到

		$shop=session('shop');




		return view("home.car")->with("shop",$shop);
	}

	// 加入购物车方法

	public function addCar(Request $request){
		// 数据处理

		$data=session('shop')?session('shop'):array();

		$a=0;
		if ($data) {
			foreach ($data as $key => &$value) {
				# code...
				if ($value['id']==$_GET['id']) {

					$value['num']=$value['num']+$_GET['num'];

					$a=1;
				}
			}
		}

		if (!$a) {
			$data[]=array(
				"id"=>$_GET['id'],
				"num"=>$_GET['num'],
				"goodsInfo"=>\DB::table("goods")->where("id",$_GET['id'])->first(),
			);
		}


		// session中追加数据
		$request->session()->put('shop', $data);

		return redirect("car");

	}

	// ajax 购物车添加

	public function CarAdd(Request $request){
		// 获取修改的ID

		$id=$request->input('id');

		// 获取session中的商品数据

		$shop=session('shop');

		// 遍历数据

		foreach ($shop as $key => $value) {
			# code...
			// 修改数量
			if ($value['id']==$id) {
				# code...

				$shop[$key]['num']=++$shop[$key]['num'];
			}
		}

		// 写入session
		$request->session()->put('shop', $shop);

		echo 1;

	}


	// ajax 购物车减少

	public function CarJian(Request $request){
		// 获取修改的ID

		$id=$request->input('id');

		// 获取session中的商品数据

		$shop=session('shop');

		// 遍历数据

		foreach ($shop as $key => $value) {
			# code...
			// 修改数量
			if ($value['id']==$id) {
				# code...

				$shop[$key]['num']=--$shop[$key]['num'];
			}
		}

		// 写入session
		$request->session()->put('shop', $shop);

		echo 1;
	}

	// 购物车的删除

	public function CarDel(Request $request){

		// 接收ID

		$id=$request->input("id");

		// 获取购物车中所有的商品数据

		$shop=session('shop');

		// 遍历数据

		foreach ($shop as $key => $value) {
			# code...

			// 判断需要删除的数据

			if ($value['id']==$id) {
				# code...

				unset($shop[$key]);
			}
		}
		// 写入sessiion
		$request->session()->put('shop', $shop);


		// 返回

		echo 1;
	}

	// 结算方法

	public function jiesuan(Request $request){


		// 查询当前登录者的收货地址

		$uid=session('lenovoHomeUserInfo.id');

		// 查询数据

		$addr=\DB::table("addr")->where("uid",$uid)->get();


		// 接收到商品数据

		$idArr=$request->input('goods');


		// 读取session

		$shop=session("shop");

		// 声明新数组

		$newArr=array();

		// 遍历购物车中所有的商品

		foreach ($idArr as $key => $value) {
			# code...

			foreach ($shop as $k => $v) {
				# code...

				// 判断是否用户选择的商品

				if ($v['id']==$value) {
					# code...

					$newArr[]=$v;
				}
			}
		}


		// 加载结算页面

		return view("home.jiesuan")->with("newShop",$newArr)->with("addr",$addr);
	}

}
