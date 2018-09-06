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

class InfoController extends CommonController
{
    public function index($id)
    {
        $article = Article::where('status', '2')->find($id);
        $next_article = Article::where('id', '<', $id)->orderBy('id', 'desc')->first();
        $pre_article = Article::where('id', '>', $id)->orderBy('id', 'asc')->first();
        return view('index.info', ['nav_list' => $this->nav_list, 'article' => $article, 'next_article' => $next_article, 'pre_article' => $pre_article]);
    }
}