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
 * | @information        | 账号管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-06
 * + --------------------------------------------------------------------
 * | @remark             | 微信认证事件推送接口未处理
 *                       | (微信公众平台技术开发文档>>账号管理>>生成带参数的二维码)
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;

class AccountController extends Controller
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
     * 生成二维码
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function createQrCode($accessToken, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $accessToken;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 展示二维码
     * @param $ticket
     * @return mixed
     */
    public function showQrCode($ticket)
    {
        $ticket = urlencode($ticket);
        $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $ticket;
        $output = $this->httpCurl->getFile($url);
        return $output;
    }

    public function longUrlToShort($accessToken, $longUrl)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token=" . $accessToken;
        $post_data = '{"action":"long2short","long_url":"' . $longUrl . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }
}