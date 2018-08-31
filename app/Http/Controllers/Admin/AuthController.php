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
use App\Models\Authorize;
use Cookie;

class AuthController extends Controller
{
    /**
     * 登录页面显示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $identify_cookie = $request->cookie('CMS-IDENTIFY');
        $has_identify_cookie = !empty($identify_cookie);
        if ($has_identify_cookie) {
            $identify_arr = json_decode(base64_decode($identify_cookie), true);
            $user = User::where('identify', $identify_arr['identify'])->first();
            $has_user = !empty($user);
            if (!$has_user) {
                return view('admin.auth.login');
            }
            $is_overtime = $user->deadline <= date('Y-m-d H:i:s', time());
            $is_allow = $user->token == $identify_arr['token'];
            if ($is_overtime || !$is_allow) {
                return view('admin.auth.login');
            }
            $this->storeUser($user->id);
            return view('admin.auth.turn', ['user' => $user]);
        } else {
            return view('admin.auth.login');
        }
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
            // 获取权限
            $token = encrypt_token($user->id, $user->id);
            $minute = 60 * 24 * 7;
            if ('checked' == $remember_me) {
                $data = [
                    'token' => $token,
                    'identify' => $identify,
                    'deadline' => date('Y-m-d H:i:s', time() + $minute * 60)
                ];
                User::where('id', $user->id)->update($data);
                $identify_cookie = base64_encode(json_encode($data));
                Cookie::queue('CMS-IDENTIFY', $identify_cookie, $minute);
            }
            $this->storeUser($user->id);
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

    private function storeUser($user_id)
    {
        $role_id = UserRole::where('user_id', $user_id)->value('role_id');
        $rules_str = Authorize::where('role_id', $role_id)->value('rules');
        $rules = explode(',', $rules_str);
        $session_arr = [
            'user_id' => $user_id,
            'role_id' => $role_id,
            'rules' => $rules
        ];
        session(['user' => base64_encode(json_encode($session_arr))]);
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
        return view('admin.common.forbidden', ['menu_list' => session('menu')]);
    }
}