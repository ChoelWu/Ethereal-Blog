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
 * | @information        | 用户管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-07-10
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends CommonController
{

    /**
     * 用户列表显示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = ['title' => '用户管理', 'sub_title' => '用户列表'];
        $list = User::with('user')->select('id', 'account', 'nickname', 'status', 'user_id', 'e_mail', 'status', 'phone', 'header_img')->where('id', '<>', '1')->paginate(10);
        return view('admin.user.index', ['menu_list' => $this->setMenu($request), 'list' => $list, 'title' => $title]);
    }

    /**
     * 添加用户
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
                if ($request->has('header_img')) {
                    $file = $request->file('header_img');
                    if ($file->isValid()) {
                        $ext = $file->getClientOriginalExtension();
                        $filename = date('YmdHis', time()) . uniqid() . '.' . $ext;
                        $data['header_img'] = $file->storeAs('uploads/user/header_img', $filename);
                    }
                }
                $role_id = $data['role_id'];
                unset($data['_token']);
                unset($data['role_id']);
                $data['id'] = setModelId("User");
                $user_id = $data['id'];
                $data['password'] = password_encrypt($data["password"], $data["id"]);
                $data['user_id'] = ($request->session()->get('user'))['user_id'];
                $user_role_data = [
                    'id' => setModelId("UserRole"),
                    'user_id' => $user_id,
                    'role_id' => $role_id
                ];
                try {
                    $rel = User::create($data);
                    $rel_ext = UserRole::create($user_role_data);
                    if (!empty($rel) && !empty($rel_ext)) {
                        return $this->returnMessage('success', '用户添加成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
            return $this->returnMessage('error', '用户添加失败！');
        } else {
            $title = ['title' => '用户管理', 'sub_title' => '添加用户'];
            $role_list = Role::select('id', 'role_name')->where('status', '1')->where('id', '<>', '1')->get();
            return view('admin.user.add', ['menu_list' => $this->setMenu($request), 'role_list' => $role_list, 'title' => $title]);
        }
    }

    /**
     * 修改用户
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
                $role_id = $data['role_id'];
                unset($data["role_id"]);
                unset($data["_token"]);
                unset($data["id"]);
                $data['user_id'] = ($request->session()->get('user'))['user_id'];
                if (empty($data["password"])) {
                    unset($data["password"]);
                } else {
                    $data['password'] = password_encrypt($data["password"], $id);
                }
                if ($request->has('header_img')) {
                    $file = $request->file('header_img');
                    if ($file->isValid()) {
                        $ext = $file->getClientOriginalExtension();
                        $filename = date('YmdHis', time()) . uniqid() . '.' . $ext;
                        $data['header_img'] = $file->storeAs('uploads/user/header_img', $filename);
                    }
                }
                $user_role_data = [
                    'role_id' => $role_id
                ];
                $user = User::find($id);
                $user_role = UserRole::where('user_id', $id)->first();
                try {
                    $rel_ext = $user_role->update($user_role_data);
                    $rel = $user->update($data);
                    if ($rel && $rel_ext) {
                        return $this->returnMessage('success', '用户修改成功！');
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }
            }
            return $this->returnMessage('error', '用户修改失败！');
        } else {
            $title = ['title' => '用户管理', 'sub_title' => '修改用户信息'];
            $user = User::select('id', 'account', 'nickname', 'phone', 'e_mail', 'header_img', 'status')->find($id);
            $role_list = Role::select('id', 'role_name')->where('status', '1')->where('id', '<>', '1')->get();
            return view('admin.user.edit', ['menu_list' => $this->setMenu($request), 'title' => $title, 'user' => $user, 'role_list' => $role_list, 'id' => $id]);
        }
    }

    /**
     * 删除用户
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $user = User::find($id);
            $user_role = UserRole::where('user_id', $id)->first();
            try {
                $rel = $user->delete();
                if (!empty($user_role)) {
                    $rel_ext = $user_role->delete();
                    $rel = $rel && $rel_ext;
                }
                if ($rel) {
                    return $this->returnMessage('success', '用户删除成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '用户删除失败！');
    }

    /**
     * 更新状态
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $id = $request->id;
            $user = User::find($id);
            try {
                $user->status == '1' ? $user->status = '0' : $user->status = '1';
                $rel = $user->save();
                if ($rel) {
                    return $this->returnMessage('success', '用户状态修改成功！');
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return $this->returnMessage('error', '用户状态修改失败！');
    }

    public function checkAccount(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $action = $request->action;
            $rel = false;
            if ("edit" == $action) {
                $id = $request->id;
                $account = $request->account;
                $rel = User::where('account', $account)->where('id', '<>', $id)->exists();
            } else if ("add" == $action) {
                $account = $request->account;
                $rel = User::where('account', $account)->exists();
            }
            return json_encode(!$rel);
        }
    }
}