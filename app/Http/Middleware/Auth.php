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
 * | @information        | 授权检查
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-28
 * + --------------------------------------------------------------------
 * | @remark             |
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Middleware;

use Closure;

class Auth
{
    /**
     * 权限处理
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user_session = session('user');
        $auth_session = session('auth');
        $has_privileges = !empty($user_session) && !empty($auth_session);
        // 判断是否处于登录状态
        if (!$has_privileges) {
            return redirect('/');
        }
        // 权限控制只针对于非超级管理员
        if ('1' != $user_session['role_id']) {
            $path = $request->path();
            // 只获取请求路由的前三个路由关键字
            $path_raw_arr = explode('/', $path);
            $path_arr = [];
            foreach($path_raw_arr as $key => $path_raw) {
                $path_arr[$key] = $path_raw;
                if($key >= 2) {
                    break;
                }
            }
            $path = implode('/', $path_arr);
            $is_path_in = in_array($path, $auth_session['rule']);
            if (!$is_path_in) {
                $is_ajax = $request->ajax();
                if ($is_ajax) {
                    $rel_arr = [
                        'title' => '权限提示',
                        'status' => '400',
                        'message' => '您没有该操作的权限！'
                    ];
                    return response()->json($rel_arr);
                }
                return redirect('admin/auth/forbidden');
            }
        }
        return $next($request);
    }
}
