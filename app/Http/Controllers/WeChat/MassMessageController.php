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
 * | @information        | 消息群发
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-02
 * + --------------------------------------------------------------------
 * |                    | 接口暂时未处理的地方：
 * | @remark            | 1、使用 clientmsgid 参数，避免重复推送
 * |                    | 2、控制群发速度
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;

class MassMessageController extends Controller
{
    private $tagUrl;
    private $httpCurl;
    private $toUserUrl;
    private $previewUrl;
    private $deleteUrl;
    private $queryStatusUrl;
    private $baseSupport;

    /**
     * 初始化接口地址和所需要的基本支持
     * MassMessageController constructor.
     */
    public function __construct()
    {
        $this->baseSupport = new BaseSupportController();
        $this->httpCurl = new HttpCurlController();
        $this->tagUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=';
        $this->toUserUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=';
        $this->previewUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=';
        $this->deleteUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token=';
        $this->queryStatusUrl = 'https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token=';
    }

    /**
     * 群发/预览消息
     * @param $data
     * @return mixed
     */
    public function massMessage($accessToken, $data)
    {
        $url = '';
        if ('tag' == $data['mass_type']) {
            $url = $this->tagUrl . $accessToken;
        } else if ('to_user' == $data['mass_type']) {
            $url = $this->toUserUrl . $accessToken;
        } else if ('user' == $data['mass_type']) {
            $url = $this->previewUrl . $accessToken;
        }
        $post_data = json_encode($data['post_data'], JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 删除群发消息
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function deleteMassMessage($accessToken, $data)
    {
        $post_data = '{"msg_id":' . $data['msg_id'] . ',"article_idx":' . $data['article_idx'] . '}';
        $url= $this->deleteUrl . $accessToken;
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 查询消息状态
     * @param $accessToken
     * @param $msgId
     * @return mixed
     */
    public function queryMessageStatus($accessToken, $msgId)
    {
        $post_data = '{"msg_id": "' . $msgId . '"}';
        $url= $this->queryStatusUrl . $accessToken;
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }
}