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
 * | @information        | 海报管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-11
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Poster;
use Illuminate\Http\Request;

class PosterController extends CommonController
{
    public function index()
    {
        $title = ['title' => '海报管理', 'sub_title' => '海报列表'];
        $list = Poster::paginate(5);
        return view('admin.poster.index', ['menu_list' => session('menu'), 'title' => $title, 'list' => $list]);
    }

    public function add(Request $request)
    {
        $is_ajax = $request->ajax();
        $is_post = $request->isMethod("post");
        if ($is_ajax) {
            if ($is_post) {
                $data = $request->all();
                if ($request->has('img')) {
                    $file = $request->file('img');
                    if ($file->isValid()) {
                        $ext = $file->getClientOriginalExtension();
                        $filename = date('YmdHis', time()) . uniqid() . '.' . $ext;
                        $data['img'] = $file->storeAs('uploads/poster/img', $filename);
                    }
                }
                unset($data['_token']);
                $data['id'] = setModelId("Poster");
                try {
                    Poster::create($data);
                    $rel = [
                        'status' => '200',
                        'message' => '海报添加成功！'
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "海报添加失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        }
    }

    /**
     * 删除海报
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $is_get = $request->isMethod("get");
            if ($is_get) {
                $id = $request->id;
                $rel = Poster::destroy($id);
                $is_delete = empty($rel);
                if (!$is_delete) {
                    $rel_arr = [
                        'status' => '200',
                        'message' => '海报删除成功！'
                    ];
                } else {
                    $rel_arr = [
                        'status' => '400',
                        'message' => '海报删除失败！'
                    ];
                }
                $rel_arr['title'] = '删除海报';
                return $rel_arr;
            }
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
            $id = $request->id;
            $poster = Poster::find($id);
            $poster->is_top == '1' ? $poster->is_top = '0' : $poster->is_top = '1';
            $poster->save();
        }
    }

    /**
     * 更改状态
     * @param Request $request
     */
    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $poster = Poster::select('id', 'status')->find($id);
            $poster->status == '1' ? $poster->status = '0' : $poster->status = '1';
            $poster->save();
        }
    }
}