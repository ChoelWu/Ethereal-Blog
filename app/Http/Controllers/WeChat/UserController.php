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
 * | @information        | 用户管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-03
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

class UserController extends Controller
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
     * 创建标签
     * @param $accessToken
     * @param $name
     * @return mixed
     */
    public function createTags($accessToken, $name)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=" . $accessToken;
        $post_data = '{"tag":{"name" : "' . $name . '"} }';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取公众号已创建的标签
     * @param $accessToken
     * @return mixed
     */
    public function getTags($accessToken)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token=' . $accessToken;
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 编辑标签
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function editTags($accessToken, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token=' . $accessToken;
        $post_data = '{"tag":{"id":' . $data['id'] . ',"name":"' . $data['name'] . '"}}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 删除标签
     * @param $accessToken
     * @param $id
     * @return mixed
     */
    public function deleteTags($accessToken, $id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=' . $accessToken;
        $post_data = '{"tag":{"id":' . $id . '}}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取标签下的用户
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function getUserByTag($accessToken, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=' . $accessToken;
        $post_data = '{"tagid":' . $data['tag_id'] . ',"next_openid":"' . $data['next_openid'] . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 批量为用户添加标签
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function addTagsToUser($accessToken, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=' . $accessToken;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 批量为用户取消标签
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function cancelTagsToUser($accessToken, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=' . $accessToken;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 查询用户的标签
     * @param $accessToken
     * @param $open_id
     * @return mixed
     */
    public function getUserTags($accessToken, $open_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=' . $accessToken;
        $post_data = '{"openid":"' . $open_id . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 设置用户备注
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function setRemark($accessToken, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=' . $accessToken;
        $post_data = '{"openid":"' . $data['open_id'] . '","remark":"' . $data['remark'] . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取用户基本信息（包括UnionID机制）
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function getUserInfo($accessToken, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $accessToken . '&openid=' . $data['open_id'] . '&lang=' . $data['lang'];
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     * 批量获取用户基本信息
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function getMultiUserInfo($accessToken, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=' . $accessToken;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 获取用户列表
     * @param $accessToken
     * @param $next_open_id
     * @return mixed
     */
    public function getUserList($accessToken, $next_open_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=' . $accessToken . '&next_openid=' . $next_open_id;
        $output = $this->httpCurl->get($url);
        return $output;
    }

    /**
     *  获取公众号的黑名单列表
     * @param $accessToken
     * @param $begin_open_id
     * @return mixed
     */
    public function getBlackList($accessToken, $begin_open_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=' . $accessToken;
        $post_data = '{"begin_openid":"' . $begin_open_id . '"}';
        $output = $this->httpCurl->post($url, $post_data);
        return $output;
    }

    /**
     * 拉黑用户
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function putUserInBlackList($accessToken, $data) {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=' . $accessToken;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;

    }

    /**
     * 取消拉黑用户
     * @param $accessToken
     * @param $data
     * @return mixed
     */
    public function removeUserFromBlackList($accessToken, $data) {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token=' . $accessToken;
        $post_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $output = $this->httpCurl->post($url, $post_data);
        return $output;

    }
}