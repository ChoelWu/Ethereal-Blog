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
 * | @information        | 广告标语配置管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-12
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Slogan;
use Illuminate\Http\Request;

class SloganController extends CommonController
{
    public function index()
    {
        $title = ['title' => '广告位管理', 'sub_title' => '广告位列表'];
        $list = Slogan::paginate(5);
        return view('admin.slogan.index', ['menu_list' => session('menu'), 'title' => $title, 'list' => $list]);
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
                        $data['img'] = $file->storeAs('uploads/slogan/img', $filename);
                    }
                }
                unset($data['_token']);
                $data['id'] = setModelId("Slogan");
                try {
                    Slogan::create($data);
                    $rel = [
                        'status' => '200',
                        'message' => '广告位添加成功！'
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "广告位添加失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        }
    }

    /**
     * 删除广告位
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
                $rel = Slogan::destroy($id);
                $is_delete = empty($rel);
                if (!$is_delete) {
                    $rel_arr = [
                        'status' => '200',
                        'message' => '广告位删除成功！'
                    ];
                } else {
                    $rel_arr = [
                        'status' => '400',
                        'message' => '广告位删除失败！'
                    ];
                }
                $rel_arr['title'] = '删除广告位';
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
            $slogan = Slogan::find($id);
            $slogan->is_top == '1' ? $slogan->is_top = '0' : $slogan->is_top = '1';
            $slogan->save();
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
            $slogan = Slogan::select('id', 'status')->find($id);
            $slogan->status == '1' ? $slogan->status = '0' : $slogan->status = '1';
            $slogan->save();
        }
    }
}