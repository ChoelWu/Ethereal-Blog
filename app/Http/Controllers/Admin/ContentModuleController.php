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
    public function index()
    {
        $title = ['title' => '模块管理', 'sub_title' => '模块列表'];
        $content_module = ContentModule::where('status', '1')->get();
        $nav_list = Nav::select('id', 'name', 'parent_id', 'level')->where('status', '1')->get();
        $nav_list = getMenu($nav_list, 0, 1);
        $nav_json_list = json_encode($nav_list, JSON_UNESCAPED_UNICODE);
        return view('admin.module.index', ['menu_list' => session('menu'), 'title' => $title, 'content_module' => $content_module, 'nav_list' => $nav_list, 'nav_json_list' => $nav_json_list]);
    }

    public function modify(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $modify_data = [];
        foreach ($data as $key1 => $item) {
            foreach ($item as $key2 => $d) {
                $modify_data[$key2][$key1] = $d;
            }
        }
        try {
            foreach ($modify_data as $item) {
                if ('0' == $item['id']) {
                    $item['id'] = setModelId('ContentModule');
                    ContentModule::create($item);
                } else {
                    $id = $item['id'];
                    unset($item['id']);
                    ContentModule::where('id', $id)->update($item);
                }
            }
        } catch (\Exception $e) {

        }
    }
}