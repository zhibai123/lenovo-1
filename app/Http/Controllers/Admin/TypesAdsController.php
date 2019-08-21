<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
//后台分类广告管理控制器

class TypesAdsController extends Controller
{
    //分类广告管理首页
    public function index()
    {


        return view("admin.sys.types.index");

    }


}
