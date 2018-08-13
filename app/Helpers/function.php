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
 * | @create-date        | 2018-07-03
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

/**
 * 获取菜单树
 * @param $menuArr
 * @param $parentId
 * @param $level
 * @return array
 */
function getMenu($menuArr, $parentId, $level)
{
    $result_arr = [];

    foreach ($menuArr as $menuItem) {
        if ($menuItem['parent_id'] == $parentId && $menuItem['level'] == $level) {
            $menuItem['children'] = getMenu($menuArr, $menuItem['id'], $level + 1);
            $result_arr[] = $menuItem;
        }
    }

    return $result_arr;
}

/**
 * 为模型构造ID
 * @param $tableName
 * @return string
 */
function setModelId($tableName)
{
    $id = strtoupper($tableName) . "_" . date("YmdHis", time()) . rand(1000, 9999);
    return $id;
}

/**
 * 密码加密
 * @param $seed
 * @param $att
 * @return string
 */
function password_encrypt($seed, $salt)
{
    $rel = md5($seed . md5($salt, true));
    return $rel;
}

/**
 * 制作token
 * @param $seed
 * @param $salt
 * @return string
 */
function encrypt_token($seed, $salt)
{
    if (is_array($seed)) {
        ksort($seed);
        $seed = implode(",", $seed);
    }
    $rel = md5($seed . md5($salt));
    return $rel;
}