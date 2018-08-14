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
 * | @information        | 基础依赖
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

class BaseSupportController extends Controller
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
     * 微信签名校验
     * @param $token
     * @param $timestamp
     * @param $nonce
     * @param $signature
     * @return bool
     */
    public function auth($token, $timestamp, $nonce, $signature)
    {
        $tmpArr = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($signature == $tmpStr) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取access_token
     * @return mixed
     */
    public function getAccessToken()
    {
        $grant_type = 'client_credential';
        $appid = env('wechat_AppID');
        $secret = env('wechat_AppSecret');
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=' . $grant_type . '&appid=' . $appid . '&secret=' . $secret;
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 获取微信服务器IP地址
     * @return mixed
     */
    public function getWeChatServerIp()
    {
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=" . $access_token['access_token'];
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 获取公众号的自动回复规则
     * @param $access_token
     * @return mixed
     */
    public function getAutoReply($access_token)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info?access_token=' . $access_token;
        $output = $this->httpCurl->get($url);
        return $output;
    }
}