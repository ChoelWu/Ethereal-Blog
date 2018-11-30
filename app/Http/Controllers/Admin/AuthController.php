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

use App\Models\BlogUser;
use Illuminate\Http\Request;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Role;
use App\Models\Authorize;
use App\Models\Menu;
use Cookie;

class AuthController extends CommonController
{
    /**
     * 登录页面显示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 获取用户历史登录cookie信息
        $identify_cookie = $request->cookie('CMS-IDENTIFY');
        $has_identify_cookie = !empty($identify_cookie);
        // 如果存在用户历史cookie信息，直接验证信息，免登录，若不存在则定向用户到登录页面
        if ($has_identify_cookie) {
            $identify_arr = json_decode(base64_decode($identify_cookie), true);
            $user = User::select('id', 'password', 'nickname', 'header_img')->where('identify', $identify_arr['identify'])->first();
            $has_user = !empty($user);
            // 根据cookie在数据库中未找到用户，重定向到登录页面
            if (!$has_user) {
                return view('admin.auth.login');
            }
            // 检查cookie是否有效
            $is_overtime = $user->deadline >= date('Y-m-d H:i:s', time() - 300);
            // 检查令牌是否有效
            $is_allow = $user->token == $identify_arr['token'];
            // cookie信息无效，重新登录
            if ($is_overtime || !$is_allow) {
                return view('admin.auth.login');
            }
            // 完成登录，存储用户必要的session信息
            $this->storeUserInfo($user, $request);
            // 重定向到首页
            return view('admin.auth.turn', ['user' => $user]);
        } else {
            return view('admin.auth.login');
        }
    }

    /**
     * 登录校验
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $account = $request->account;
        $password = $request->password;
        $remember_me = $request->remember_me;
        // 验证用户的登录信息
        $user = User::select('id', 'password', 'nickname', 'header_img')->where('account', $account)->first();
        $encrypted_pwd = password_encrypt($password, $user->id);
        if ($user->password === $encrypted_pwd) {
            // 用户勾选记住密码，下次静默登录
            if ('checked' == $remember_me) {
                $token = encrypt_token($user->id, $user->id);
                $identify = base64_encode(md5($user->account . time() . rand(100, 999)));
                // cooki有效时间1周
                $minute = 60 * 24 * 7;
                $data = [
                    'token' => $token,
                    'identify' => $identify,
                    'deadline' => date('Y-m-d H:i:s', time() + $minute * 60)
                ];
                // 更新用户的静默登录信息
                User::where('id', $user->id)->update($data);
                $identify_cookie = base64_encode(json_encode($data));
                // 保存静默登录cookie
                Cookie::queue('CMS-IDENTIFY', $identify_cookie, $minute);
            }
            // 保存用户的session信息
            $this->storeUserInfo($user, $request);
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
        return $rel;
    }

    /**
     * 存储用户信息到session中
     * @param $user
     * @param $request
     */
    private function storeUserInfo($user, $request)
    {
        // 用户角色信息
        $role_id = UserRole::where('user_id', $user->id)->value('role_id');
        $role_name = Role::where('id', $role_id)->value('role_name');
        // 权限信息
        $rules_str = Authorize::where('role_id', $role_id)->value('rules');
        $blog_id = BlogUser::where('user_id', $user->id)->value('blog_id');
        $rules = explode(',', $rules_str);
        // 用户基本信息
        $user_session_arr = [
            'user_id' => $user->id,
            'nickname' => $user->nickname,
            'role_name' => $role_name,
            'header_img' => $user->header_img,
            'role_id' => $role_id,
            'blog_id' => $blog_id
        ];
        // 菜单列表
        $menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'url', 'icon')->where('status', '1')->where(function ($query) use ($user_session_arr, $rules) {
            if ('1' != $user_session_arr['user_id'] && '1' != $user_session_arr['role_id']) {
                $query->whereIn('url', $rules)->orWhere('url', '#');
            }
        })->orderBy('sort', 'asc')->get()->toArray();
        $menu_list = getMenu($menu_arr, 0, 1);
        // 非超级管理员时清理没有连接地址的父菜单（清理没有权限的父级菜单）
        if ('1' != $user['user_id'] && '1' != $user['role_id']) {
            foreach ($menu_list as $key => $menu_level1) {
                if (empty($menu_level1['children']) && '#' == $menu_level1['url']) {
                    unset($menu_list[$key]);
                }
            }
        }
        // 权限信息
        $auth_session_arr = [
            'menu' => $menu_list,
            'rule' => $rules
        ];
        // 存储用户和权限信息
        $request->session()->put('user', $user_session_arr);
        $request->session()->put('auth', $auth_session_arr);
    }

    /**
     * 注销登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        $cookie = Cookie::forget('CMS-IDENTIFY');
        return redirect('/')->withCookie($cookie);
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forbidden(Request $request)
    {
        return view('admin.common.forbidden', ['menu_list' => $this->setMenu($request)]);
    }
}