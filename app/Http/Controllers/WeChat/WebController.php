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
 * | @information        | 网页授权
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-06
 * + --------------------------------------------------------------------
 * | @remark             |
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;

class WebController extends Controller
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
     * 用户同意授权，获取code
     * @param $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCode($data)
    {
        $app_id = env('wechat_AppID');
        $redirect_uri = urlencode($data['uri']);
        $scope = $data['scope'];
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $app_id . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=' . $scope . '&state=STATE#wechat_redirect';
        return redirect()->away($url);
    }

    /**
     * 通过code换取网页授权access_token
     * @param $code
     * @return mixed
     */
    public function getAccessToken($code)
    {
        $app_id = env('wechat_AppID');
        $secret = env('wechat_AppSecret');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $app_id . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        $rel = $this->httpCurl->get($url);
        return $rel;
    }

    /**
     * 刷新access_token（如果需要）
     * @param $refreshToken
     * @return mixed
     */
    public function refreshToken($refreshToken)
    {
        $app_id = env('wechat_AppID');
        $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=' . $app_id . '&grant_type=refresh_token&refresh_token=' . $refreshToken;
        $rel = $this->httpCurl->get($url);
        return $rel;
    }

    /**
     * 拉取用户信息
     * @param $data
     * @return mixed
     */
    public function getUserInfo($data)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $data['access_token'] . "&openid=" . $data['open_id'] . "&lang=" . $data['lang'];
        $rel = $this->httpCurl->get($url);
        return $rel;
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * @param $accessToken
     * @param $openId
     * @return mixed
     */
    public function checkAccessToken($accessToken, $openId)
    {
        $url = 'https://api.weixin.qq.com/sns/auth?access_token=' . $accessToken . '&openid=' . $openId;
        $rel = $this->httpCurl->get($url);
        return $rel;
    }
}