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
 * | @information        | 菜单管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-07-18
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends CommonController
{
    private $modelName;
    public function __construct()
    {
        $this->modelName = 'Menu';
    }

    /**
     * 菜单列表显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = ['title' => '菜单管理', 'sub_title' => '菜单列表'];
        $menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'status', 'sort', 'url', 'icon')->orderBy('sort', 'asc')->get();
        $list = getMenu($menu_arr, 0, 1);
        return view('admin.menu.index', ['menu_list' => session('menu'), 'list' => $list, 'title' => $title]);
    }

    /**
     * 添加菜单
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
                    $parent_menu_level = Menu::where('id', $data['parent_id'])->value('level');
                    empty($parent_menu_level) ? $data['level'] = '1' : $data['level'] = $parent_menu_level + 1;
                }
                $data['id'] = setModelId("Menu");
                unset($data['_token']);
                try {
                    Menu::create($data);
                    $rel = [
                        "status" => "200",
                        "message" => "菜单添加成功！"
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "菜单添加失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '菜单管理', 'sub_title' => '添加菜单'];
            $parent_menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'status', 'sort', 'url', 'icon')->get()->toArray();
            $parent_menu_list = getMenu($parent_menu_arr, 0, 1);
            return view('admin.menu.add', ['menu_list' => session('menu'), 'parent_menu_list' => $parent_menu_list, 'title' => $title]);
        }
    }

    /**
     * 修改菜单
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
                $menu = Menu::find($id);
                $rel = $this->commonEdit($menu, $data,"菜单");
                return json_encode($rel);
            }
        } else {
            $title = ['title' => '菜单管理', 'sub_title' => '修改菜单'];
            $parent_menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'status', 'sort', 'url', 'icon')->get()->toArray();
            $parent_menu_list = getMenu($parent_menu_arr, 0, 1);
            $menu = Menu::select('id', 'name', 'parent_id', 'sort', 'url', 'sort', 'status', 'icon')->find($id);
            return view('admin.menu.edit', ['menu_list' => session('menu'), 'parent_menu_list' => $parent_menu_list, 'menu' => $menu, 'title' => $title]);
        }
    }

    /**
     * 修改菜单状态
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $menu = Menu::find($id);
            $rel = $this->commonUpdateStatus($menu, "菜单");
            return json_encode($rel);
        }
    }

    /**
     * 删除菜单
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $menu = Menu::find($id);
            $rel = $this->commonDelete($menu, "菜单");
            return json_encode($rel);
        }
    }

    /**
     * 获取菜单级别
     * @param Request $request
     * @return string
     */
    public function getMenuLevel(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $menu_id = $request->menu_id;
            $level = Menu::where('id', $menu_id)->value('level');
            empty($level) ? $level = '0' : $level;
            return $level;
        }
    }
}