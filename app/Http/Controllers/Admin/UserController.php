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
 * | @create-date        | 2018-07-10
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends CommonController
{

    public function index()
    {
        $title = ['title' => '用户管理', 'sub_title' => '用户列表'];
        $list = User::select('id', 'nickname', 'status', 'e_mail', 'status', 'phone', 'header_img')->get();
        return view('admin.user.index', ['menu_list' => $this->menu_list, 'list' => $list, 'title' => $title]);
    }

    public function add(Request $request)
    {
        $is_ajax = $request->ajax();
        $is_post = $request->isMethod("post");
        if ($is_ajax) {
            if ($is_post) {
                $data = $request->all();
                if ($request->has('header_img')) {
                    $file = $request->file('header_img');
                    if ($file->isValid()) {
                        $ext = $file->getClientOriginalExtension();
                        $filename = date('YmdHis', time()) . uniqid() . '.' . $ext;
                        $data['header_img'] = $file->storeAs('user/header_img', $filename);
                    }
                }
                unset($data['_token']);
                $data['id'] = setModelId("User");
                $data['password'] = password_encrypt($data["password"], $data["id"]);
                try {
                    User::create($data);
                    $rel = [
                        'status' => '200',
                        'message' => '用户添加成功！'
                    ];
                } catch (\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "用户添加失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '用户管理', 'sub_title' => '添加用户'];
            return view('admin.user.add', ['menu_list' => $this->menu_list, 'title' => $title]);
        }
    }

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
                if(empty($data["password"])) {
                    unset($data["password"]);
                } else {
                    $data['password'] = password_encrypt($data["password"], $id);
                }
                if ($request->has('header_img')) {
                    $file = $request->file('header_img');
                    if ($file->isValid()) {
                        $ext = $file->getClientOriginalExtension();
                        $filename = date('YmdHis', time()) . uniqid() . '.' . $ext;
                        $data['header_img'] = $file->storeAs('user/header_img', $filename);
                    }
                }
                try {
                    User::where('id', $id)->update($data);
                    $rel= [
                        'status' => '200',
                        'message' => '用户修改成功！'
                    ];
                } catch(\Exception $e) {
                    $rel = [
                        "status" => "400",
                        "message" => "用户修改失败！" . $e->getMessage()
                    ];
                }
                return $rel;
            }
        } else {
            $title = ['title' => '用户管理', 'sub_title' => '修改用户信息'];
            $user = User::select('id', 'account', 'nickname', 'phone', 'e_mail', 'header_img', 'status')->find($id);
            return view('admin.user.edit', ['menu_list' => $this->menu_list, 'title' => $title, 'user' => $user, 'id' => $id]);
        }
    }

    public function delete(Request $request)
    {
        $is_ajax = $request->ajax();
        $rel = '';
        if ($is_ajax) {
            $user_id = $request->user_id;
            $rel = User::destroy($user_id);
        }
        $is_delete = empty($rel);
        if (!$is_delete) {
            $rel_arr = [
                'status' => '200',
                'message' => '用户删除成功！'
            ];
        } else {
            $rel_arr = [
                'status' => '400',
                'message' => '用户删除失败！'
            ];
        }
        $rel_arr['title'] = '删除用户';
        return $rel_arr;
    }

    public function updateStatus(Request $request)
    {
        $is_ajax = $request->ajax();
        if ($is_ajax) {
            $user_id = $request->user_id;
            $user = User::select('id', 'status')->find($user_id);
            $user->status == '1' ? $user->status = '0' : $user->status = '1';
            $user->save();
        }
    }
}