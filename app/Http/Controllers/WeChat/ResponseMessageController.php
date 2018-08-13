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
 * | @create-date        | 2018-08-01
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

class ResponseMessageController extends Controller
{
    /**
     * 被动回复文字消息
     * @param $data ['to_user_name', 'from_user_name', 'create_time', 'content']
     */
    public function responseTextMessage($data)
    {
        $msg = "<xml>"
            . "<ToUserName>" . $data['to_user_name'] . "</ToUserName>"
            . "<FromUserName>" . $data['from_user_name'] . "</FromUserName>"
            . "<CreateTime>" . $data['create_time'] . "</CreateTime>"
            . "<MsgType>text</MsgType>"
            . "<Content>" . $data['content'] . "</Content>"
            . "</xml>";
        echo $msg;
    }

    /**
     * 被动回复图片消息
     * @param $data ['to_user_name', 'from_user_name', 'create_time', 'media_id']
     */
    public function responseImageMessage($data)
    {
        $msg = "<xml>"
            . "<ToUserName>" . $data['to_user_name'] . "</ToUserName>"
            . "<FromUserName>" . $data['from_user_name'] . "</FromUserName>"
            . "<CreateTime>" . $data['create_time'] . "</CreateTime>"
            . "<MsgType>image</MsgType>"
            . "<Image><MediaId>" . $data['media_id'] . "</MediaId></Image>"
            . "</xml>";
        echo $msg;
    }

    /**
     * 被动回复语音消息
     * @param $data ['to_user_name', 'from_user_name', 'create_time', 'media_id']
     */
    public function responseVoiceMessage($data)
    {
        $msg = "<xml>"
            . "<ToUserName>" . $data['to_user_name'] . "</ToUserName>"
            . "<FromUserName>" . $data['from_user_name'] . "</FromUserName>"
            . "<CreateTime>" . $data['create_time'] . "</CreateTime>"
            . "<MsgType>voice</MsgType>"
            . "<Voice><MediaId>" . $data['media_id'] . "</MediaId></Voice>"
            . "</xml>";
        echo $msg;
    }

    /**
     * 被动回复视频消息
     * @param $data ['to_user_name', 'from_user_name', 'create_time', 'media_id', 'title', 'description']
     */
    public function responseVideoMessage($data)
    {
        $msg = "<xml>"
            . "<ToUserName>" . $data['to_user_name'] . "</ToUserName>"
            . "<FromUserName>" . $data['from_user_name'] . "</FromUserName>"
            . "<CreateTime>" . $data['create_time'] . "</CreateTime>"
            . "<MsgType>video</MsgType>"
            . "<Video>"
            . "<MediaId>" . $data['media_id'] . "</MediaId>"
            . "<Title>" . $data['title'] . "</Title>"
            . "<Description>" . $data['description'] . "</Description>"
            . "</Video>"
            . "</xml>";
        echo $msg;
    }

    /**
     * 被动回复音乐消息
     * @param $data ['to_user_name', 'from_user_name', 'create_time', 'title', 'description', 'music_url', 'hq_music_url', 'thumb_media_id']
     */
    public function responseMusicMessage($data)
    {
        $msg = "<xml>"
            . "<ToUserName>" . $data['to_user_name'] . "</ToUserName>"
            . "<FromUserName>" . $data['from_user_name'] . "</FromUserName>"
            . "<CreateTime>" . $data['create_time'] . "</CreateTime>"
            . "<MsgType>music</MsgType>"
            . "<Music>"
            . "<Title>" . $data['title'] . "</Title>"
            . "<Description>" . $data['description'] . "</Description>"
            . "<MusicUrl>" . $data['music_url'] . "</MusicUrl>"
            . "<HQMusicUrl>" . $data['hq_music_url'] . "</HQMusicUrl>"
            . "<ThumbMediaId>" . $data['thumb_media_id'] . "</ThumbMediaId>"
            . "</Music>"
            . "</xml>";
        echo $msg;
    }

    /**
     * 被动回复图文消息
     * @param $data ['to_user_name', 'from_user_name', 'create_time', 'article_count', 'articles' => [['title', 'description', 'pic_url', 'url'], ['title', 'description', 'pic_url', 'url'], ...]]
     */
    public function responseNewsMessage($data)
    {
        $articles = '';
        foreach ($data['articles'] as $article) {
            $articles .= "<item>"
                . "<Title>" . $article['title'] . "</Title>"
                . "<Description>" . $article['description'] . "</Description>"
                . "<PicUrl>" . $article['pic_url'] . "</PicUrl>"
                . "<Url>" . $article['url'] . "</Url>"
                . "</item>";
        }
        $msg = "<xml>"
            . "<ToUserName>" . $data['to_user_name'] . "</ToUserName>"
            . "<FromUserName>" . $data['from_user_name'] . "</FromUserName>"
            . "<CreateTime>" . $data['create_time'] . "</CreateTime>"
            . "<MsgType>news</MsgType>"
            . "<ArticleCount>" . $data['article_count'] . "</ArticleCount>"
            . "<Articles>" . $articles . "</Articles>"
            . "</xml>";
        echo $msg;
    }
}