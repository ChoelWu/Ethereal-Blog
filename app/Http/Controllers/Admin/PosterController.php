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
use Illuminate\Support\Facades\Log;

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
        if ($is_ajax) {
            $is_post = $request->isMethod("post");
            if ($is_post) {
                $data = $request->all();
                if ($request->has('img')) {
                    $file = $request->file('img');
                    if ($file->isValid()) {
                        $ext = $file->getClientOriginalExtension();
                        $filename = date('YmdHis', time()) . uniqid() . '.' . $ext;
                        $data['img'] = $file->storeAs('uploads/poster/img', $filename);
                    } else {
                        return $this->returnMessage('error', '海报添加失败1！');
                    }
                } else {
                    return $this->returnMessage('error', '海报添加失败2！');
                }
                unset($data['_token']);
                $data['id'] = setModelId("Poster");
                try {
                    $rel = Poster::create($data);
                    if (!empty($rel)) {
                        return $this->returnMessage('success', '海报添加成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
        }
        return $this->returnMessage('error', '海报添加失败3！');
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
            $is_post = $request->isMethod("post");
            if ($is_post) {
                $id = $request->id;
                $poster = Poster::find($id);
                try {
                    $rel = $poster->delete();
                    if ($rel) {
                        return $this->returnMessage('success', '海报删除成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
        }
        return $this->returnMessage('error', '海报删除失败！');
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
            $poster = Poster::find($id);
            try {
                $poster->is_top == '1' ? $poster->is_top = '0' : $poster->is_top = '1';
                $rel = $poster->save();
                if ($rel) {
                    return $this->returnMessage('success', '海报置顶状态修改成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '海报置顶状态修改失败！');
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
            $poster = Poster::find($id);
            try {
                $poster->status == '1' ? $poster->status = '0' : $poster->status = '1';
                $rel = $poster->save();
                if ($rel) {
                    return $this->returnMessage('success', '海报状态修改成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '海报状态修改失败！');
    }
}