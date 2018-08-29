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
 * | @information        | 首頁
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-07-17
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class IndexController extends CommonController
{
    public function index()
    {
        $session = session('user');
        dd(json_decode(base64_decode($session)));
        return view('admin.index.index', ['menu_list' => $this->menu_list]);
    }
}