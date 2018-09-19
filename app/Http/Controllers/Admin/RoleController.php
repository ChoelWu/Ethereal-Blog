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
            if ('1' == $user_session->user_id) {
                $query->select('id', 'menu_id', 'name', 'route')->orderBy('sort', 'asc')->get();
            } else {
                $query->select('id', 'menu_id', 'name', 'route')->whereIn('route', $user_session->rules)->orderBy('sort', 'asc')->get();
            }
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
        if ($is_ajax) {
            $is_post = $request->isMethod("post");
            if ($is_post) {
                $data = $request->all();
                unset($data['_token']);
                $data['id'] = setModelId("Role");
                try {
                    $rel = Role::create($data);
                    if (!empty($rel)) {
                        return $this->returnMessage('success', '角色添加成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
            return $this->returnMessage('error', '角色添加失败！');
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
        if ($is_ajax) {
            $is_post = $request->isMethod("post");
            if ($is_post) {
                $data = $request->all();
                $id = $data['id'];
                $role = Role::find($id);
                unset($data["_token"]);
                unset($data["id"]);
                try {
                    $rel = $role->update($data);
                    if ($rel) {
                        return $this->returnMessage('success', '角色修改成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
            return $this->returnMessage('error', '角色修改失败！');
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
        if ($is_ajax) {
            $id = $request->id;
            $rule = Role::find($id);
            $auth = Authorize::where('role_id', $id)->first();
            try {
                $rel = $rule->delete();
                if(!empty($auth)) {
                    $rel_ext = $auth->delete();
                    $rel = $rel && $rel_ext;
                }
                if ($rel) {
                    return $this->returnMessage('success', '角色删除成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '角色删除失败！');
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
            $role = Role::find($id);
            try {
                $role->status == '1' ? $role->status = '0' : $role->status = '1';
                $rel = $role->save();
                if ($rel) {
                    return $this->returnMessage('success', '角色状态修改成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
            return $this->returnMessage('error', '角色状态修改失败！');
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