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

use App\Models\ContentModule;
use App\Models\Nav;
use Illuminate\Http\Request;

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
            $rel = [];
            try {
                if ($has_id) {
                    $id = $request->id;
                    unset($data['id']);
                    ContentModule::where('id', $id)->update($data);
                    $rel["message"] = "模块修改成功！";
                } else {
                    $data['id'] = setModelId('ContentModule');
                    ContentModule::create($data);
                    $rel["message"] = "模块添加成功！";
                }
                $rel["status"] = "200";
            } catch (\Exception $e) {
                dd($e->getMessage());
                $rel = [
                    "status" => "400",
                    "message" => "模块操作失败！"
                ];
            }
            $rel['title'] = "模块管理";
            return $rel;
        }
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
            $id = $request->id;
            $rel = ContentModule::destroy($id);
        }
        $is_delete = empty($rel);
        if (!$is_delete) {
            $rel_arr = [
                'status' => '200',
                'message' => '模块删除成功！'
            ];
        } else {
            $rel_arr = [
                'status' => '400',
                'message' => '模块删除失败！'
            ];
        }
        $rel_arr['title'] = '删除模块';
        return $rel_arr;
    }
}