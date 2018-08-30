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
use App\Models\Menu;

class MenuTree
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user_session = json_decode(base64_decode(session('user')));
        $menu_arr = Menu::select('id', 'name', 'level', 'parent_id', 'url', 'icon')->where('status', '1')->where(function ($query) use ($user_session) {
            if ('1' != $user_session->user_id && '1' != $user_session->role_id) {
                $query->whereIn('url', $user_session->rules)->orWhere('level', '1');
            }
        })->orderBy('sort', 'asc')->get()->toArray();
        $menu_list = getMenu($menu_arr, 0, 1);
        if ('1' != $user_session->user_id && '1' != $user_session->role_id) {
            foreach ($menu_list as $key => $menu_level1) {
                if (empty($menu_level1['children']) && '#' == $menu_level1['url']) {
                    unset($menu_list[$key]);
                }
            }
        }
        session()->flash('menu', $menu_list);
        return $next($request);
    }
}
