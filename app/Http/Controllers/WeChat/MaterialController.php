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
 * | @information        | 素材管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-07
 * + --------------------------------------------------------------------
 * | @remark             | 素材管理>>获取临时素材 高清语音素材获取接口  未实现
 *                       | 素材管理>>新增永久素材 新增其他类型永久素材  未实现
 * + --------------------------------------------------------------------
 * |          | @date    |
 * +  @update + ---------------------------------------------------------
 * |          | @content |
 * + ====================================================================
 */

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
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
     * 新增临时素材
     * @param $data
     * @return mixed
     */
    public function addTemporaryMaterial($data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $data['access_token'] . "&type=" . $data['type'];
        $curl_file = new \CURLFile($data['path']);
        $post_data = ['media' => $curl_file];
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取临时素材
     * @param $access_token
     * @param $media_id
     * @return mixed
     */
    public function getTemporaryMaterial($access_token, $media_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=' . $access_token . '&media_id=' . $media_id;
        $output = $this->httpCurl->getFile($url);
        return $output;
    }

    /**
     * 新增永久图文素材
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function addPermanentNews($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=' . $access_token;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 上传图文消息内的图片获取URL
     * @param $access_token
     * @param $path
     * @return mixed
     */
    public function addPermanentImage($access_token, $path)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=" . $access_token;
        $curl_file = new \CURLFile($path);
        $post_data = ['media' => $curl_file];
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 新增其他类型永久素材
     * @param $data
     * @return mixed
     */
    public function addPermanentMaterial($data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=" . $data['access_token'] . "&type=" . $data['type'];
        $curl_file = new \CURLFile($data['path']);
        $post_data = ['media' => $curl_file];
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取永久素材
     * @param $access_token
     * @param $media_id
     * @return mixed
     */
    public function getPermanentMaterial($access_token, $media_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=' . $access_token;
        $post_data = '{"media_id":"' . $media_id . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 删除永久素材
     * @param $access_token
     * @param $media_id
     * @return mixed
     */
    public function deletePermanentMaterial($access_token, $media_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=' . $access_token;
        $post_data = '{"media_id":' . $media_id . '}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 修改永久图文素材
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function updatePermanentMaterial($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=' . $access_token;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);;
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取素材总数
     * @param $access_token
     * @return mixed
     */
    public function getMaterialAmount($access_token)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=' . $access_token;
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 获取素材列表
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function getMaterialList($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=' . $access_token;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);;
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 上传图文消息素材【订阅号与服务号认证后均可用】
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function addNews($access_token, $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=" . $access_token;
        $articles = '';
        foreach ($data as $article) {
            $articles .= '{"thumb_media_id":"' . $article['thumb_media_id'] . '","author":"' . $article['author'] . '",'
                . '"title":"' . $article['title'] . '","content_source_url":"' . $article['content_source_url'] . '","content":"' . $article['content']
                . '","digest":"' . $article['digest'] . '","show_cover_pic":' . $article['show_cover_pic'] . '}, ';
        }
        $post_data = '{"articles":[' . $articles . ']}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }
}