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
 * | @information        | 角色管理
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

use App\Models\Role;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\Authorize;
use Log;

class RoleController extends CommonController
{
    /**
     * 列表显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = ['title' => '角色管理', 'sub_title' => '角色列表'];
        $list = Role::select('id', 'role_name', 'status')->where('id', '<>', '1')->get();
        $user_session = json_decode(base64_decode(session('user')));
        $rule_list = Menu::with(['rules' => function ($query) use ($user_session) {
            $query->select('id', 'menu_id', 'name', 'route')->whereIn('name', $user_session->rules)->orderBy('sort', 'asc')->get();
        }])->select('id', 'name', 'sort')->where(function ($query) {
            $parent_id = Menu::where('level', '<>', '1')->pluck('parent_id');
            $query->whereNotIn('id', $parent_id);
        })->orderBy('sort', 'asc')->get();
        return view('admin.role.index', ['menu_list' => session('menu'), 'list' => $list, 'rule_list' => $rule_list, 'title' => $title]);
    }

    /**
     * 添加角色
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
                $data['id'] = setModelId("Role");
                try {
                    Role::create($data);
                    $rel = [
                        "status" => "200",
                        "message" => "角色添加成功！"
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "角色添加失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '角色管理', 'sub_title' => '添加角色'];
            return view('admin.role.add', ['menu_list' => session('menu'), 'title' => $title]);
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
                try {
                    Role::where('id', $id)->update($data);
                    $rel = [
                        'status' => '200',
                        'message' => '角色修改成功！'
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "角色修改失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '角色管理', 'sub_title' => '修改角色信息'];
            $role = Role::select('id', 'role_name', 'status')->find($id);
            return view('admin.role.edit', ['menu_list' => session('menu'), 'title' => $title, 'role' => $role, 'id' => $id]);
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
        $role_id = $request->role_id;
        if ($is_ajax) {
            $rel = Role::destroy($role_id);
        }
        $is_delete = empty($rel);
        if (!$is_delete) {
            Authorize::where('role_id', $role_id)->delete();
            $rel_arr = [
                'status' => '200',
                'message' => '角色删除成功！'
            ];
        } else {
            $rel_arr = [
                'status' => '400',
                'message' => '角色删除失败！'
            ];
        }
        $rel_arr['title'] = '删除角色';
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
            $role_id = $request->role_id;
            $user = Role::select('id', 'status')->find($role_id);
            $user->status == '1' ? $user->status = '0' : $user->status = '1';
            $user->save();
        }
    }

    /**
     * 角色授权
     * @param Request $request
     * @return array
     */
    public function authorizeRole(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $role_id = $request->role_id;
            $rules = $request->rules;
            $data = [
                'id' => setModelId("Authorize"),
                'role_id' => $role_id,
                'rules' => implode(',', $rules)
            ];
            try {
                Authorize::where('role_id', $role_id)->delete();
                Authorize::create($data);
                $rel_arr = [
                    'status' => '200',
                    'message' => '授权成功！'
                ];
            } catch (\Exception $e) {
                $rel_arr = [
                    'status' => '400',
                    'message' => '授权失败！'
                ];
            }
            $rel_arr['title'] = '用户授权';
            return $rel_arr;
        }
    }

    public function getAuthorize(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $role_id = $request->role_id;
            $auth_str = Authorize::where('role_id', $role_id)->value('rules');
            $auth = explode(',', $auth_str);
            return $auth;
        }
    }
}