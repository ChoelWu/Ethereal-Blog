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
 * | @information        | 文章管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-01
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Nav;

class ArticleController extends CommonController
{
    public function index()
    {
        $title = ['title' => '文章管理', 'sub_title' => '文章列表'];
        $list = Article::with(['nav' => function ($query) {
            $query->select('id', 'name');
            $query->select('id', 'name');
        }])->where('status', '<>', '0')->orderBy('id', 'desc')->paginate(3);
        $tag_list = Tag::select('id', 'name')->where('status', '1')->get();
        $nav_list = Nav::select('id', 'name', 'parent_id', 'level')->where('status', '1')->get();
        $nav_list = getMenu($nav_list, 0, 1);
        return view('admin.article.index', ['menu_list' => session('menu'), 'list' => $list, 'tag_list' => $tag_list, 'nav_list' => $nav_list, 'title' => $title]);
    }

    public function add(Request $request)
    {
        $is_post = $request->isMethod('post');
        if ($is_post) {
            $data = $request->all();
            unset($data['_token']);
            $data['id'] = setModelId("Menu");
            try {
                Article::create($data);
                $rel = [
                    "status" => "200",
                    "message" => "文章添加成功！"
                ];
            } catch (\Exception $e) {
                $rel = [
                    "status" => "400",
                    "message" => "文章添加失败！"
                ];
            }
            return $rel;
        } else {
            $title = ['title' => '文章管理', 'sub_title' => '新增文章'];
            return view('admin.article.add', ['menu_list' => session('menu'), 'title' => $title]);
        }
    }

    public function edit()
    {

    }

    public function delete()
    {

    }

    public function publish()
    {

    }
}