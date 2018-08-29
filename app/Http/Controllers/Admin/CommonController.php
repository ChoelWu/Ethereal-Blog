<?php
/**
 * + ====================================================================
 * | @author             | Choel
 * + --------------------------------------------------------------------
 * | @e-mail             | choel_wu@foxmail.com
 * + --------------------------------------------------------------------
 * | @copyright          | Choel
 * + --------------------------------------------------------------------
 * | @version            | v-1.0.0
 * + --------------------------------------------------------------------
 * | @information        | 基本类
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-07-10
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class CommonController extends Controller
{
    protected $menu_list;

    public function __construct()
    {
        $menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'url', 'icon')->where('status', '1')->orderBy('sort', 'asc')->get()->toArray();
        $this->menu_list = getMenu($menu_arr, 0, 1);
    }
}