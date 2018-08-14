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
 * | @information        | 菜单管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-07-30
 * + --------------------------------------------------------------------
 * |                    |
 * | @remark            |
 * |                    |
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    private $httpCurl;

    /**
     * 初始化所需要的基本支持
     * MenuController constructor.
     */
    public function __construct()
    {
        $this->httpCurl = new HttpCurlController();
    }

    /**
     * 设置菜单
     * @param $data
     * @param $accessToken
     * @return mixed
     */
    public function setMenu($data, $accessToken)
    {
        $menu = json_encode($data, JSON_UNESCAPED_UNICODE);
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $accessToken;
        $output = $this->httpCurl->post($url, $menu);
        return $output;
    }

    /**
     * 根据条件个性化定制菜单
     * @param $data
     * @param $accessToken
     * @return mixed
     */
    public function setConditionalMenu($data, $accessToken)
    {
        $menu = json_encode($data, JSON_UNESCAPED_UNICODE);
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=' . $accessToken;
        $output = $this->httpCurl->post($url, $menu);
        return $output;
    }

    /**
     * 测试个性化菜单匹配结果
     * @param $userId
     * @param $accessToken
     * @return mixed
     */
    public function matchConditionalMenu($userId, $accessToken)
    {
        $data = '{"user_id":"' . $userId . '"}';
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/trymatch?access_token=' . $accessToken;
        $output = $this->httpCurl->post($url, $data);
        return $output;
    }

    /**
     * 删除个性化菜单
     * @param $accessToken
     * @return mixed
     */
    public function deleteConditionalMenu($accessToken)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token=' . $accessToken;
        $output = $this->httpCurl->post($url);
        return $output;
    }

    /**
     * 删除所有菜单（包括个性化菜单）
     * @param $accessToken
     * @return mixed
     */
    public function deleteMenu($accessToken)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=' . $accessToken;
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 获取所有菜单结构（包括个性化菜单）
     * @param $accessToken
     * @return mixed
     */
    public function getMenu($accessToken)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=' . $accessToken;
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 获取自定义菜单配置接口
     * @param $accessToken
     * @return mixed
     */
    public function getMenuConfig($accessToken)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=' . $accessToken;
        $output = $this->httpCurl->get($url);
        return $output;
    }
}