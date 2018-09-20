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
 * | @information        | 标签管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-05
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends CommonController
{

    /**
     * 标签列表显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = ['title' => '标签管理', 'sub_title' => '标签列表'];
        $list = Tag::select('id', 'name', 'status')->get();
        return view('admin.tag.index', ['menu_list' => session('menu'), 'list' => $list, 'title' => $title]);
    }

    /**
     * 添加标签
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $is_post = $request->isMethod("post");
            if ($is_post) {
                $data = $request->all();
                unset($data['_token']);
                $data['id'] = setModelId('Tag');
                try {
                    $rel = Tag::create($data);
                    if (!empty($rel)) {
                        return $this->returnMessage('success', '标签添加成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
            return $this->returnMessage('error', '标签添加失败！');
        } else {
            $title = ['title' => '标签管理', 'sub_title' => '添加标签'];
            return view('admin.tag.add', ['menu_list' => session('menu'), 'title' => $title]);
        }
    }

    /**
     * 修改标签
     * @param Request $request
     * @param null $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $is_post = $request->isMethod("post");
            if ($is_post) {
                $data = $request->all();
                $id = $data['id'];
                unset($data["_token"]);
                unset($data["id"]);
                $tag = Tag::find($id);
                try {
                    $rel = $tag->update($data);
                    if ($rel) {
                        return $this->returnMessage('success', '标签修改成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
            return $this->returnMessage('error', '标签修改失败！');
        } else {
            $title = ['title' => '标签管理', 'sub_title' => '修改标签信息'];
            $tag = Tag::select('id', 'name', 'status')->find($id);
            return view('admin.tag.edit', ['menu_list' => session('menu'), 'title' => $title, 'tag' => $tag, 'id' => $id]);
        }
    }

    /**
     * 删除标签
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $tag = Tag::find($id);
            try {
                $rel = $tag->delete();
                if ($rel) {
                    return $this->returnMessage('success', '标签删除成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '标签除失败！');
    }

    /**
     * 更新状态
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $tag = Tag::find($id);
            try {
                $tag->status == '1' ? $tag->status = '0' : $tag->status = '1';
                $rel = $tag->save();
                if ($rel) {
                    return $this->returnMessage('success', '标签状态修改成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '标签状态修改失败！');
    }

    /**
     * 检查标签名是否存在
     * @param Request $request
     * @return string
     */
    public function checkTag(Request $request)
    {
        $is_ajax = $request->ajax();
        $rel = true;
        if($is_ajax) {
            $action = $request->action;
            $name = $request->name;
            if("edit" == $action) {
                $id = $request->id;
                $rel = Tag::where('name', $name)->where('id', '<>', $id)->exists();
            } else if("add" == $action) {
                $rel = Tag::where('name', $name)->exists();
            }
        }
        return json_encode(!$rel);
    }
}