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
use Illuminate\Http\Request;
use App\Models\User;

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
            if ('checked' == $remember_me) {
                $session_arr = [
                    'user_id' => $user->id,
                    'token' => encrypt_token($user->id, $user->id)
                ];
                session(['user' => base64_encode(json_encode($session_arr))]);
                $data = [
                    'token' => $session_arr['token'],
                    'identify' => 'ok',
                    'deadline' => ''
                ];
                User::where('id', $user->id)->update($data);
            }
            // 获取权限
            // @TODO
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
}