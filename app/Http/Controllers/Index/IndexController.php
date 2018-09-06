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

namespace App\Http\Controllers\Index;

use App\Models\Article;

class IndexController extends CommonController
{
    public function index()
    {
        $article_list = Article::where('status', '2')->get();
        return view('index.index', ['nav_list' => $this->nav_list, 'article_list' => $article_list]);
    }
}