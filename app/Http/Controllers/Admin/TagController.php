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
        $is_post = $request->isMethod("post");
        if ($is_ajax) {
            if ($is_post) {
                $data = $request->all();
                unset($data['_token']);
                $data['id'] = setModelId('Tag');
                try {
                    Tag::create($data);
                    $rel = [
                        'status' => '200',
                        'message' => '标签添加成功！'
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "标签添加失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
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
        $is_post = $request->isMethod("post");
        if ($is_ajax) {
            if ($is_post) {
                $data = $request->all();
                $id = $data['id'];
                unset($data["_token"]);
                unset($data["id"]);
                try {
                    Tag::where('id', $id)->update($data);
                    $rel= [
                        'status' => '200',
                        'message' => '标签修改成功！'
                    ];
                } catch(\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "标签修改失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
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
        $rel = '';
        $tag_id = $request->tag_id;
        if ($is_ajax) {
            $rel = Tag::destroy($tag_id);
        }
        $is_delete = empty($rel);
        if (!$is_delete) {
            $rel_arr = [
                'status' => '200',
                'message' => '标签删除成功！'
            ];
        } else {
            $rel_arr = [
                'status' => '400',
                'message' => '标签删除失败！'
            ];
        }
        $rel_arr['title'] = '删除标签';
        return $rel_arr;
    }

    /**
     * 更新状态
     * @param Request $request
     */
    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $tag_id = $request->tag_id;
            $tag = Tag::select('id', 'status')->find($tag_id);
            $tag->status == '1' ? $tag->status = '0' : $tag->status = '1';
            $tag->save();
        }
    }
}