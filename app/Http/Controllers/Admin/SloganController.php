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
 * | @information        | 广告管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-11
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Slogan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SloganController extends CommonController
{
    public function index()
    {
        $title = ['title' => '广告管理', 'sub_title' => '广告列表'];
        $list = Slogan::paginate(5);
        return view('admin.slogan.index', ['menu_list' => session('menu'), 'title' => $title, 'list' => $list]);
    }

    public function add(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $is_post = $request->isMethod("post");
            if ($is_post) {
                $data = $request->all();
                if ($request->has('img')) {
                    $file = $request->file('img');
                    if ($file->isValid()) {
                        $ext = $file->getClientOriginalExtension();
                        $filename = date('YmdHis', time()) . uniqid() . '.' . $ext;
                        $data['img'] = $file->storeAs('uploads/slogan/img', $filename);
                    } else {
                        return $this->returnMessage('error', '广告添加失败！');
                    }
                } else {
                    return $this->returnMessage('error', '广告添加失败！');
                }
                unset($data['_token']);
                $data['id'] = setModelId("Slogan");
                try {
                    $rel = Slogan::create($data);
                    if (!empty($rel)) {
                        return $this->returnMessage('success', '广告添加成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
        }
        return $this->returnMessage('error', '广告添加失败！');
    }

    /**
     * 删除广告
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $is_post = $request->isMethod("post");
            if ($is_post) {
                $id = $request->id;
                $slogan = Slogan::find($id);
                try {
                    $rel = $slogan->delete();
                    if ($rel) {
                        return $this->returnMessage('success', '广告删除成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
        }
        return $this->returnMessage('error', '广告删除失败！');
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
            $slogan = Slogan::find($id);
            try {
                $slogan->is_top == '1' ? $slogan->is_top = '0' : $slogan->is_top = '1';
                $rel = $slogan->save();
                if ($rel) {
                    return $this->returnMessage('success', '广告置顶状态修改成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '广告置顶状态修改失败！');
    }

    /**
     * 更改状态
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $slogan = Slogan::find($id);
            try {
                $slogan->status == '1' ? $slogan->status = '0' : $slogan->status = '1';
                $rel = $slogan->save();
                if ($rel) {
                    return $this->returnMessage('success', '广告状态修改成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '广告状态修改失败！');
    }
}