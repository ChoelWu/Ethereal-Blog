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
 * | @create-date        | 2018-07-20
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
use Illuminate\Http\Request;

class RoleController extends CommonController
{
    /**
     * 列表显示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = ['title' => '角色管理', 'sub_title' => '角色列表'];
        $list = Role::select('id', 'role_name', 'status')->get();
        return view('admin.role.index', ['menu_list' => $this->menu_list, 'list' => $list, 'title' => $title]);
    }

    public function add(Request $request)
    {

    }

    public function edit(Request $request, $id = null)
    {

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
            $role_id = $request->role_id;
            $rel = User::destroy($role_id);
        }
        $is_delete = empty($rel);
        if (!$is_delete) {
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
            $user_id = $request->user_id;
            $user = Role::select('id', 'status')->find($user_id);
            $user->status == '1' ? $user->status = '0' : $user->status = '1';
            $user->save();
        }
    }
}