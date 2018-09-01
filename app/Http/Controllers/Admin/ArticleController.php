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

class ArticleController extends CommonController
{
    public function index()
    {
        $title = ['title' => '文章管理', 'sub_title' => '文章列表'];
        $list = Article::with(['nav' => function($query) {
            $query->select('id', 'name');
        }, 'tag' => function($query) {
            $query->select('id', 'name');
        }])->where('status', '<>', '0')->orderBy('id', 'desc')->paginate(3);
        return view('admin.article.index', ['menu_list' => session('menu'), 'list' => $list, 'title' => $title]);
    }

    public function add() {

    }

    public function edit() {

    }

    public function delete() {

    }

    public function publish() {

    }
}