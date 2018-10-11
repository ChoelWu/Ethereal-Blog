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
 * | @information        | 前台模块管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-07
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Nav;
use App\Models\ContentModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContentModuleController extends CommonController
{
    /**
     * 模块列表显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = ['title' => '模块管理', 'sub_title' => '模块列表'];
        $content_module = ContentModule::where('status', '1')->get();
        $nav_list = Nav::select('id', 'name', 'parent_id', 'level')->where('status', '1')->get();
        $nav_list = getMenu($nav_list, 0, 1);
        $nav_json_list = json_encode($nav_list, JSON_UNESCAPED_UNICODE);
        return view('admin.module.index', ['menu_list' => session('menu'), 'title' => $title, 'content_module' => $content_module, 'nav_list' => $nav_list, 'nav_json_list' => $nav_json_list]);
    }

    /**
     * 模块添加和修改
     * @param Request $request
     * @return array
     */
    public function modify(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $has_id = $request->has('id');
            $data = $request->all();
            unset($data['_token']);
            try {
                if ($has_id) {
                    $id = $request->id;
                    unset($data['id']);
                    $module = ContentModule::find($id);
                    $rel = $module->update($data);
                    if ($rel) {
                        return $this->returnMessage('success', '模块修改成功！');
                    }
                } else {
                    $data['id'] = setModelId('ContentModule');
                    $rel = ContentModule::create($data);
                    if (!empty($rel)) {
                        return $this->returnMessage('success', '模块添加成功！');
                    }
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '模块修改失败！');
    }

    /**
     * 删除模块
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
                $module = ContentModule::find($id);
                try {
                    $rel = $module->delete();
                    if ($rel) {
                        return $this->returnMessage('success', '模块删除成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
        }
        return $this->returnMessage('error', '模块删除失败！');
    }
}