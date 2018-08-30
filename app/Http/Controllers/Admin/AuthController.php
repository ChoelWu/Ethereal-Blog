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
 * | @information        | 登录授权
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

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\Authorize;

class AuthController extends Controller
{
    /**
     * 登录页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.auth.login');
    }

    /**
     * 登录校验
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        $account = $request->account;
        $password = $request->password;
        $remember_me = $request->remember_me;
        $user = User::select('id', 'password')->where('account', $account)->first();
        $encrypted_pwd = password_encrypt($password, $user->id);
        if ($user->password === $encrypted_pwd) {
            $role_id = UserRole::where('user_id', $user->id)->value('role_id');
            $rules_str = Authorize::where('role_id', $role_id)->value('rules');
            $rules = explode(',', $rules_str);
            $session_arr = [
                'user_id' => $user->id,
                'token' => encrypt_token($user->id, $user->id),
                'role_id' => $role_id,
                'rules' => $rules
            ];
            session(['user' => base64_encode(json_encode($session_arr))]);
            $menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'url', 'icon')->where('status', '1')->where(function ($query) use ($session_arr) {
                if ('1' != $session_arr['user_id'] && '1' != $session_arr['role_id']) {
                    $query->whereIn('url', $session_arr['rules']);
                }
            })->orderBy('sort', 'asc')->get()->toArray();
            $menu_list = getMenu($menu_arr, 0, 1);
            session(['menu' => $menu_list]);
//            if ('checked' == $remember_me) {
//                $data = [
//                    'token' => $session_arr['token'],
//                    'identify' => 'ok',
//                    'deadline' => ''
//                ];
////                User::where('id', $user->id)->update($data);
//            }
            // 获取权限
//            session(['user.id', ]);
            $rel = [
                'status' => true,
                'message' => "登陆成功，正在为你跳转"
            ];
        } else {
            $rel = [
                'status' => false,
                'message' => "登陆失败，密码错误"
            ];
        }
        return json_encode($rel);
    }

    public function logout()
    {

    }

    /**
     * 检查用户账户是否存在
     * @param Request $request
     * @return string
     */
    public function checkAccount(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $account = $request->account;
            $rel = User::where('account', $account)->exists();
            return json_encode($rel);
        }
    }

    /**
     * 处理沒有授权的操作
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forbidden()
    {
        $menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'url', 'icon')->where('status', '1')->get()->toArray();
        $menu_list = getMenu($menu_arr, 0, 1);
        return view('admin.common.forbidden', ['menu_list' => $menu_list]);
    }
}