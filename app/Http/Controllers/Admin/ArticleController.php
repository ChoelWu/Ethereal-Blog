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
    /**
     * 文章列表显示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = ['title' => '文章管理', 'sub_title' => '文章列表'];
        $article_title = $request->article_title;
        $nav_id = $request->nav_id;
        $tag_id = $request->tag_id;
        $status = $request->status;
        $list = Article::with(['nav' => function ($query) {
            $query->select('id', 'name');
        }, 'tag' => function ($query) {
            $query->select('id', 'name');
        }])->where(function ($query) use ($article_title) {
            if ('' != $article_title) {
                $query->where('title', 'like', '%' . $article_title . '%');
            }
        })->where(function ($query) use ($nav_id) {
            if ('' != $nav_id) {
                $query->where('nav_id', $nav_id);
            }
        })->where(function ($query) use ($tag_id) {
            if ('' != $tag_id) {
                $query->where('tag_id', $tag_id);
            }
        })->where(function ($query) use ($status) {
            if ('' == $status) {
                $query->where('status', '<>', '0');
            } else {
                $query->where('status', $status);
            }
        })->where('status', '<>', '0')->orderBy('id', 'desc')->paginate(10);
        $tag_list = Tag::select('id', 'name')->where('status', '1')->get();
        $nav_list = Nav::select('id', 'name', 'parent_id', 'level')->where('status', '1')->get();
        $nav_list = getMenu($nav_list, 0, 1);
        return view('admin.article.index', ['menu_list' => session('menu'), 'list' => $list,
            'tag_list' => $tag_list, 'nav_list' => $nav_list, 'title' => $title, 'article_title' => $article_title,
            'nav_id' => $nav_id, 'tag_id' => $tag_id, 'status' => $status]);
    }

    /**
     * 添加文章
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $is_post = $request->isMethod('post');
        if ($is_post) {
            $data = $request->all();
            unset($data['_token']);
            $data['id'] = setModelId("Article");
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

    /**
     * 修改文章
     * @param Request $request
     * @param string $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id = '')
    {
        $is_post = $request->isMethod('post');
        if ($is_post) {
            $id = $request->id;
            $data = $request->all();
            $data['status'] = '1';
            unset($data['_token']);
            unset($data['id']);
            try {
                Article::where('id', $id)->update($data);
                $rel = [
                    "status" => "200",
                    "message" => "文章修改成功！"
                ];
            } catch (\Exception $e) {
                $rel = [
                    "status" => "400",
                    "message" => "文章修改失败！"
                ];
            }
            return $rel;
        } else {
            $article = Article::find($id);
            $title = ['title' => '文章管理', 'sub_title' => '新增文章'];
            return view('admin.article.edit', ['menu_list' => session('menu'), 'article' => $article, 'title' => $title]);
        }
    }

    /**
     * 删除文章
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->article_id;
            $article = Article::find($id);
            $article->status = '0';
            $article->save();
            $rel_arr = [
                'status' => '200',
                'message' => '文章删除成功！'
            ];
            return $rel_arr;
        }
    }

    /**
     * 发布文章
     * @param Request $request
     * @return array
     */
    public function publish(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $is_post = $request->isMethod('post');
            if ($is_post) {
                $data = $request->all();
                $id = $data['id'];
                unset($data['_token']);
                unset($data['id']);
                try {
                    $data['status'] = '2';
                    Article::where('id', $id)->update($data);
                    $rel = [
                        "status" => "200",
                        "message" => "文章发布成功！"
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "文章发布失败！"
                    ];
                }
                $rel['title'] = '文章发布';
                return $rel;
            } else {
                $id = $request->id;
                $publish_article_list = Article::find($id);
                return $publish_article_list;
            }
        }
    }

    /**
     * 取消发布文章
     * @param Request $request
     */
    public function cancelPublish(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->article_id;
            $article = Article::find($id);
            $article->status = '1';
            $article->save();
        }
    }

    /**
     * 置顶/取消置顶
     * @param Request $request
     */
    public function stick(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->article_id;
            $value = $request->value;
            $value == '1' ? $value = '0' : $value = '1';
            $article = Article::find($id);
            $article->is_top = $value;
            $article->save();
        }
    }

    /**
     * 修改文章标题属性（加粗、倾斜）
     * @param Request $request
     */
    public function updateAttribute(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->article_id;
            $action = $request->action;
            if ('bold' == $action) {
                $article = Article::find($id);
                $article->is_title_bold == '1' ? $article->is_title_bold = '0' : $article->is_title_bold = '1';
                $article->save();
            }
            if ('italic' == $action) {
                $article = Article::find($id);
                $article->is_title_italic == '1' ? $article->is_title_italic = '0' : $article->is_title_italic = '1';
                $article->save();
            }
        }
    }
}