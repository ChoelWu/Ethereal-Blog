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
use Illuminate\Support\Facades\Log;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function add(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $is_post = $request->isMethod('post');
            if ($is_post) {
                $data = $request->all();
                unset($data['_token']);
                $data['id'] = setModelId("Article");
                try {
                    $rel = Article::create($data);
                    if (!empty($rel)) {
                        return $this->returnMessage('success', '文章添加成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
            return $this->returnMessage('success', '文章添加失败！');
        } else {
            $title = ['title' => '文章管理', 'sub_title' => '新增文章'];
            return view('admin.article.add', ['menu_list' => session('menu'), 'title' => $title]);
        }
    }

    /**
     * 修改文章
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit(Request $request, $id = '')
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $is_post = $request->isMethod('post');
            if ($is_post) {
                $id = $request->id;
                $data = $request->all();
                $data['status'] = '1';
                unset($data['_token']);
                unset($data['id']);
                $article = Article::find($id);
                try {
                    $rel = $article->update($data);
                    if ($rel) {
                        return $this->returnMessage('success', '文章修改成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
            return $this->returnMessage('error', '文章修改失败！');
        } else {
            $article = Article::find($id);
            $title = ['title' => '文章管理', 'sub_title' => '修改文章'];
            return view('admin.article.edit', ['menu_list' => session('menu'), 'article' => $article, 'title' => $title]);
        }
    }

    /**
     * 删除文章
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $article = Article::find($id);
            $article->status = '0';
            try {
                $rel = $article->save();;
                if ($rel) {
                    return $this->returnMessage('success', '文章删除成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '文章删除失败！');
    }

    /**
     * 发布文章
     * @param Request $request
     * @return string
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
                $article = where('id', $id)->first();
                $data['status'] = '2';
                try {
                    $rel = $article->update($data);
                    if ($rel) {
                        return $this->returnMessage('success', '文章发布成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
                return $this->returnMessage('error', '文章发布失败！');
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
     * @return string
     */
    public function cancelPublish(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $article = Article::find($id);
            $article->status = '1';
            try {
                $rel = $article->save();
                if ($rel) {
                    return $this->returnMessage('success', '文章取消发布操作成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '文章取消发布操作失败！');
    }

    /**
     * 置顶/取消置顶
     * @param Request $request
     * @return string
     */
    public function stick(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $value = $request->value;
            $article = Article::find($id);
            if ($article->is_top == $value) {
                $value == '1' ? $value = '0' : $value = '1';
                $article->is_top = $value;
                try {
                    $rel = $article->save();
                    if ($rel) {
                        return $this->returnMessage('success', '文章置顶成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
        }
        return $this->returnMessage('error', '文章置顶失败！');
    }

    /**
     * 修改文章标题属性（加粗、倾斜）
     * @param Request $request
     * @return string
     */
    public function updateAttribute(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $action = $request->action;
            $article = Article::find($id);
            if ('bold' == $action) {
                $article->is_title_bold == '1' ? $article->is_title_bold = '0' : $article->is_title_bold = '1';
            }
            if ('italic' == $action) {
                $article->is_title_italic == '1' ? $article->is_title_italic = '0' : $article->is_title_italic = '1';
            }
            try {
                $rel = $article->save();
                if ($rel) {
                    return $this->returnMessage('success', '文章修改成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '文章修改失败！');
    }
}