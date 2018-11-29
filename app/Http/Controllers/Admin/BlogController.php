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
 * | @information        | 博客基本信息管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-12
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends CommonController
{
    public function index(Request $request)
    {
        $title = ['title' => '博客基本信息', 'sub_title' => '基本信息配置'];
        $list = Blog::first();
        return view('admin.blog.index', ['menu_list' => $this->setMenu($request), 'title' => $title, 'list' => $list]);
    }

    public function modify(Request $request) {
        $is_ajax = $request->ajax();
        if($is_ajax) {
            $data = $request->all();
            unset($data['_token']);
            try{
                Blog::where('id', '1')->update($data);
            } catch(\Exception $e) {
               dd($e->getMessage());
            }
        }
    }
}