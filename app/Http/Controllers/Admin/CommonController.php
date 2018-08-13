<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class CommonController extends Controller
{
    protected $menu_list;

    public function __construct()
    {
        $menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'url', 'icon')->where('status', '1')->get()->toArray();
        $this->menu_list = getMenu($menu_arr, 0, 1);
    }
}