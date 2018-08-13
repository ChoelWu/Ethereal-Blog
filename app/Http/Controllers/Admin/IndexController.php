<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index.index', ['menu_list' => $this->menu_list]);
    }
}