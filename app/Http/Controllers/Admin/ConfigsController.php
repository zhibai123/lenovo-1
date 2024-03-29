<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

// 使用类

use App\Http\Controllers\Controller;

// 后台系统控制器
class ConfigsController extends Controller
{
    // 系统首页

    public function index(Request $request){



        // 加载页面

        return view("admin.sys.config.index");

    }

    // 更新配置的方法啊

    public function store(Request $request){
        // 接收原图

        $oldLogo=$request->input('oldLogo');

        // 获取数据
        $arr=$request->except("_token",'oldLogo');

        // 写入文件中

        $str1=var_export($arr,true);

        $str="<?php

return ".$str1." ?>";

        // 写入到指定文件

        file_put_contents('../config/web.php', $str);

        if ($oldLogo==$request->input("logo")) {
            # code...
        }else{
            unlink("./Uploads/sys/".$oldLogo);
        }

        return back();

    }

}
