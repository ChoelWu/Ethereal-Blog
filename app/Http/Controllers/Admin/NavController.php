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
 * | @information        | 导航管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-09-01
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Nav;
use Illuminate\Http\Request;

class NavController extends CommonController
{
    /**
     * 导航列表显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = ['title' => '导航管理', 'sub_title' => '导航列表'];
        $nav_arr = Nav::select('id', 'name', 'level', 'parent_id', 'status', 'sort', 'url', 'icon')->orderBy('sort', 'asc')->get();
        $list = getMenu($nav_arr, 0, 1);
        return view('admin.nav.index', ['menu_list' => session('menu'), 'list' => $list, 'title' => $title]);
    }

    /**
     * 添加导航
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
                if ('0' == $data['parent_id']) {
                    $data['level'] = '1';
                } else {
                    $parent_nav_level = Nav::where('id', $data['parent_id'])->value('level');
                    empty($parent_nav_level) ? $data['level'] = '1' : $data['level'] = $parent_nav_level + 1;
                }
                $data['id'] = setModelId("Nav");
                unset($data['_token']);
                try {
                    Nav::create($data);
                    $rel = [
                        "status" => "200",
                        "message" => "导航添加成功！"
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "导航添加失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '导航管理', 'sub_title' => '添加导航'];
            $parent_nav_arr = Nav::select('id', 'name', 'level', 'parent_id', 'status', 'sort', 'url', 'icon')->get()->toArray();
            $parent_nav_list = getMenu($parent_nav_arr, 0, 1);
            return view('admin.nav.add', ['menu_list' => session('menu'), 'parent_nav_list' => $parent_nav_list, 'title' => $title]);
        }
    }

    /**
     * 修改导航
     * @param Request $request
     * @param string $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id = '')
    {
        $is_ajax = $request->ajax();
        $is_post = $request->isMethod("post");
        if ($is_ajax) {
            if ($is_post) {
                $data = $request->all();
                $id = $data['id'];
                unset($data['_token']);
                unset($data['id']);
                try {
                    Nav::where('id', $id)->update($data);
                    $rel = [
                        "status" => "200",
                        "message" => "导航修改成功！"
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "导航修改失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '导航管理', 'sub_title' => '修改导航'];
            $parent_nav_arr = Nav::select('id', 'name', 'level', 'parent_id', 'status', 'sort', 'url', 'icon')->get()->toArray();
            $parent_nav_list = getMenu($parent_nav_arr, 0, 1);
            $nav = Nav::select('id', 'name', 'parent_id', 'sort', 'url', 'sort', 'status', 'icon')->find($id);
            return view('admin.nav.edit', ['menu_list' => session('menu'), 'parent_nav_list' => $parent_nav_list, 'nav' => $nav, 'title' => $title]);
        }
    }

    /**
     * 修改导航状态
     * @param Request $request
     */
    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $nav_id = $request->nav_id;
            $nav = Nav::select('id', 'status')->find($nav_id);
            $nav->status == '1' ? $nav->status = '0' : $nav->status = '1';
            $nav->save();
        }
    }

    /**
     * 删除导航
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        $rel = '';
        if ($is_ajax) {
            $nav_id = $request->nav_id;
            $rel = Nav::destroy($nav_id);
        }
        $is_delete = empty($rel);
        if (!$is_delete) {
            $rel_arr = [
                'status' => '200',
                'message' => '导航删除成功！'
            ];
        } else {
            $rel_arr = [
                'status' => '400',
                'message' => '导航删除失败！'
            ];
        }
        $rel_arr['title'] = '删除导航';
        return $rel_arr;
    }

    /**
     * 获取导航级别
     * @param Request $request
     * @return string
     */
    public function getNavLevel(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $nav_id = $request->nav_id;
            $level = Nav::where('id', $nav_id)->value('level');
            empty($level) ? $level = '0' : $level;
            return $level;
        }
    }
}