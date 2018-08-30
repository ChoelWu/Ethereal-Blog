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
 * | @information        | 规则管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-15
 * + --------------------------------------------------------------------
 * | @remark             |
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends CommonController
{
    /**
     * 列表显示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $menu_id = $request->menu_id;
        $route = $request->route;
        $title = ['title' => '规则管理', 'sub_title' => '规则列表'];
        $list = Rule::with('menu.parent')->select('id', 'name', 'route', 'menu_id', 'status', 'sort')->where(function ($query) use ($menu_id) {
            $has_menu_id = !empty($menu_id);
            if ($has_menu_id) {
                $query->where('menu_id', $menu_id);
            }
        })->where(function ($query) use ($route) {
            $has_route = !empty($route);
            if ($has_route) {
                $query->where('route', $route)->orWhere('name', 'like', '%' . $route . '%');
            }
        })->orderBy('sort', 'asc')->paginate(10);;
        return view('admin.rule.index', ['menu_list' => session('menu'), 'list' => $list, 'title' => $title,
            'menu_id' => $menu_id, 'route' => $route]);
    }

    /**
     * 添加规则
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
                $data['id'] = setModelId("Rule");
                if ('0' != $data['menu_id']) {
                    try {
                        Rule::create($data);
                        $rel = [
                            "status" => "200",
                            "message" => "规则添加成功！"
                        ];
                    } catch (\Exception $e) {
                        $rel = [
                            "status" => "400",
                            "message" => "规则添加失败！" . $e->getMessage()
                        ];
                    }
                } else {
                    $rel = [
                        "status" => "400",
                        "message" => "规则添加失败，请选择所属菜单！"
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '规则管理', 'sub_title' => '添加规则'];
            return view('admin.rule.add', ['menu_list' => session('menu'), 'title' => $title]);
        }
    }

    /**
     * 修改方法
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
                if ('0' != $data['menu_id']) {
                    try {
                        Rule::where('id', $id)->update($data);
                        $rel = [
                            'status' => '200',
                            'message' => '规则修改成功！'
                        ];
                    } catch (\Exception $e) {
                        $rel = [
                            "status" => "400",
                            "message" => "规则修改失败！" . $e->getMessage()
                        ];
                    }
                } else {
                    $rel = [
                        "status" => "400",
                        "message" => "规则添加失败，请选择所属菜单！"
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '规则管理', 'sub_title' => '修改规则信息'];
            $rule = Rule::select('id', 'name', 'route', 'menu_id', 'status', 'sort')->find($id);
            return view('admin.rule.edit', ['menu_list' => session('menu'), 'title' => $title, 'rule' => $rule, 'id' => $id]);
        }
    }

    /**
     * 删除方法
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        $rel = '';
        if ($is_ajax) {
            $rule_id = $request->rule_id;
            $rel = Rule::destroy($rule_id);
        }
        $is_delete = empty($rel);
        if (!$is_delete) {
            $rel_arr = [
                'status' => '200',
                'message' => '规则删除成功！'
            ];
        } else {
            $rel_arr = [
                'status' => '400',
                'message' => '规则删除失败！'
            ];
        }
        $rel_arr['title'] = '删除规则';
        return $rel_arr;
    }

    /**
     * 更改状态
     * @param Request $request
     */
    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $rule_id = $request->rule_id;
            $user = Rule::select('id', 'status')->find($rule_id);
            $user->status == '1' ? $user->status = '0' : $user->status = '1';
            $user->save();
        }
    }
}