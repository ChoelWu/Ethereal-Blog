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

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Nav;

class CommonController extends Controller
{
    protected $nav_list;

    public function __construct()
    {
        $nav_list = Nav::select('id', 'name', 'level', 'parent_id', 'status', 'sort', 'url', 'icon')->get()->toArray();
        $nav_list = getMenu($nav_list, 0, 1);
        $this->nav_list = $nav_list;
    }
}