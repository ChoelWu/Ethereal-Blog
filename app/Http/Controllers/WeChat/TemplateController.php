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
 * | @create-date        | 2018-08-13
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
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
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
     * 设置所属行业
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function setIndustry($access_token, $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=" . $access_token;
        $post_data = '{"industry_id1":"' . $data['primary_industry'] . '","industry_id2":"' . $data['secondary_industry'] . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取设置的行业信息
     * @param $access_token
     * @return mixed
     */
    public function getIndustryInfo($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=" . $access_token;
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 获得模板ID
     * @param $access_token
     * @param $templateIdShort
     * @return mixed
     */
    public function getTemplateId($access_token, $templateIdShort)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=" . $access_token;
        $post_data = '{"template_id_short":"' . $templateIdShort . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取模板列表
     * @param $access_token
     * @return mixed
     */
    public function getTemplateList($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=" . $access_token;
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 删除模板
     * @param $access_token
     * @param $templateId
     * @return mixed
     */
    public function deleteTemplate($access_token, $templateId)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=" . $access_token;
        $post_data = '{"template_id" : "' . $templateId . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 发送模板消息
     * @param $access_token
     * @param $post
     * @return mixed
     */
    public function sendTemplateMessage($access_token, $post)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        $post_data = json_encode($post, JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }
}