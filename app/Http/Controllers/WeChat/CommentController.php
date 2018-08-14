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
 * | @information        | 评论管理
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-14
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

class CommentController extends Controller
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
     * 打开已群发文章评论
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function openComment($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/comment/open?access_token=' . $access_token;
        $post_data = '{"msg_data_id":' . $data['msg_data_id'] . ',"index":' . $data['index'] . '}';
        $rel = $this->httpCurl->post($url, $post_data);
        return $rel;
    }

    /**
     * 关闭已群发文章评论
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function closeComment($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/comment/close?access_token=' . $access_token;
        $post_data = '{"msg_data_id":' . $data['msg_data_id'] . ',"index":' . $data['index'] . '}';
        $rel = $this->httpCurl->post($url, $post_data);
        return $rel;
    }

    /**
     * 查看指定文章的评论数据
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function viewComments($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/comment/list?access_token=' . $access_token;
        $post_data = '{"msg_data_id":' . $data['msg_data_id'] . ',"index":' . $data['index'] . ',"begin":' . $data['begin']
            . ',"count":' . $data['count'] . ',"type":' . $data['type'] . '}';
        $rel = $this->httpCurl->post($url, $post_data);
        return $rel;
    }

    /**
     * 将评论标记精选
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function setCommentSelection($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/comment/markelect?access_token=' . $access_token;
        $post_data = '{"msg_data_id":' . $data['msg_data_id'] . ',"index":' . $data['index'] . ',"user_comment_id":' . $data['user_comment_id'] . '}';
        $rel = $this->httpCurl->post($url, $post_data);
        return $rel;
    }

    /**
     * 将评论取消精选
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function cancelCommentSelection($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/comment/unmarkelect?access_token=' . $access_token;
        $post_data = '{"msg_data_id":' . $data['msg_data_id'] . ',"index":' . $data['index'] . ',"user_comment_id":' . $data['user_comment_id'] . '}';
        $rel = $this->httpCurl->post($url, $post_data);
        return $rel;
    }

    /**
     * 删除评论
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function deleteComment($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/comment/delete?access_token=' . $access_token;
        $post_data = '{"msg_data_id":' . $data['msg_data_id'] . ',"index":' . $data['index'] . ',"user_comment_id":' . $data['user_comment_id'] . '}';
        $rel = $this->httpCurl->post($url, $post_data);
        return $rel;
    }

    /**
     * 回复评论
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function replyComment($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/comment/reply/add?access_token=' . $access_token;
        $post_data = '{"msg_data_id":' . $data['msg_data_id'] . ',"index":' . $data['index'] . ',"user_comment_id":' . $data['user_comment_id'] . ',"content": ' . $data['content'] . '}';
        $rel = $this->httpCurl->post($url, $post_data);
        return $rel;
    }

    /**
     * 删除回复
     * @param $access_token
     * @param $data
     * @return mixed
     */
    public function deleteCommentReply($access_token, $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/comment/reply/delete?access_token=' . $access_token;
        $post_data = '{"msg_data_id":' . $data['msg_data_id'] . ',"index":' . $data['index'] . ',"user_comment_id":' . $data['user_comment_id'] . '}';
        $rel = $this->httpCurl->post($url, $post_data);
        return $rel;
    }
}