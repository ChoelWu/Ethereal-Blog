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
 * | @information        | 基本类
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-07-10
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    protected $menu_list;

    public function __construct()
    {
    }

    public function commonAdd($model, $data, $name) {
        unset($data['_token']);
    }

    public function commonEdit($model, $data, $name)
    {
        unset($data['_token']);
        unset($data['id']);
        try {
            $rel = $model->update($data);
            if ($rel) {
                $result = [
                    "status" => "200",
                    "message" => $name . "修改成功！"
                ];
            } else {
                $result = [
                    "status" => "400",
                    "message" => $name . "修改失败！" . $e->getMessage()
                ];
            }
        } catch (\Exception $e) {
            $result = [
                "status" => "400",
                "message" => $name . "修改失败！" . $e->getMessage()
            ];
            Log::info($e->getMessage());
        }
        return $result;
    }

    public function commonDelete($itemModel, $name)
    {
        try {
            $rel = $itemModel->delete();
            if ($rel) {
                $result = [
                    "status" => "200",
                    "message" => $name . "删除成功！"
                ];
            } else {
                $result = [
                    "status" => "400",
                    "message" => $name . "删除失败！"
                ];
            }
        } catch (\Exception $e) {
            $result = [
                "status" => "400",
                "message" => $name . "删除失败！"
            ];
            Log::info($e->getMessage());
        }
        return $result;
    }

    public function commonUpdateStatus($itemModel, $name)
    {
        try {
            $itemModel->status == '1' ? $itemModel->status = '0' : $itemModel->status = '1';
            $rel = $itemModel->save();
            if ($rel) {
                $result = [
                    "status" => "200",
                    "message" => $name . "状态修改成功！"
                ];
            } else {
                $result = [
                    "status" => "400",
                    "message" => $name . "状态修改失败！"
                ];
            }
        } catch (\Exception $e) {
            $result = [
                "status" => "400",
                "message" => $name . "状态修改失败！"
            ];
            Log::info($e->getMessage());
        }
        return $result;
    }
}