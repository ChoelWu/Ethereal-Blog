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
 * | @information        | 评论管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-11
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends CommonController
{
    /**
     * 显示评论列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = ['title' => '评论管理', 'sub_title' => '评论列表'];
        $user = $request->user;
        $article_title = $request->article_title;
        $list = Comment::select('id', 'article_id', 'user_id', 'praise', 'is_top')->where(function ($query) use ($user) {
            if ('' != $user) {
                $user_id = User::where('nickname', 'like', '%' . $user . '%')->pluck('id');
                $query->whereIn('user_id', $user_id);
            }
        })->where(function ($query) use ($article_title) {
            if ('' != $article_title) {
                $article_id = Article::where('title', 'like', '%' . $article_title . '%')->pluck('id');
                $query->whereIn('article_id', $article_id);
            }
        })->where('status', '1')->paginate(10);
        return view('admin.comment.index', ['menu_list' => $this->setMenu($request), 'list' => $list, 'title' => $title, 'article_title' => $article_title, 'user' => $user]);
    }

    /**
     * 查看评论
     * @param Request $request
     * @return array
     */
    public function view(Request $request)
    {
        $id = $request->id;
        $comment = Comment::select('id', 'user_id', 'article_id', 'content', 'type', 'response_id')->find($id);
        $list = [
            'article_title' => $comment->article->title,
            'user_name' => $comment->user->nickname,
            'content' => $comment->content,
            'type' => $comment->type
        ];
        if ('2' == $comment->type) {
            $response_comment = Comment::select('id', 'user_id', 'content')->find($comment->response_id);
            $list['response'] = [
                'user_name' => $response_comment->user->nickname,
                'content' => $response_comment->content
            ];
        }
        return $list;
    }

    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        $rel_arr = [];
        if ($is_ajax) {
            $comment_id = $request->comment_id;
            $comment = Comment::find($comment_id);
            $comment->status = '0';
            $comment->save();
            $rel_arr = [
                'status' => '200',
                'message' => '评论删除成功！'
            ];
        }
        $rel_arr['title'] = '删除评论';
        return $rel_arr;
    }

    /**
     * 置顶/取消置顶
     * @param Request $request
     */
    public function stick(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->comment_id;
            $value = $request->value;
            $value == '1' ? $value = '0' : $value = '1';
            $comment = Comment::find($id);
            $comment->is_top = $value;
            $comment->save();
        }
    }
}