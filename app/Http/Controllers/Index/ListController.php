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
use App\Models\Tag;
use Illuminate\Http\Request;

class ListController extends CommonController
{
    public function index(Request $request)
    {
        $article_list = Article::where(function($query) use ($request) {
            $has_keyboard = $request->has('keyboard');
            if($has_keyboard) {
                $keyboard = $request->keyboard;
                $tag = Tag::where('name', 'like', '%' . $keyboard . '%')->pluck('id');
                $query->whereIn('tag_id', $tag)->orWhere('title', 'like', '%' . $keyboard . '%');
            }
        })->where(['status' => '2'])->paginate(1);
        return view('index.list', ['nav_list' => $this->nav_list, 'article_list' => $article_list]);
    }
}