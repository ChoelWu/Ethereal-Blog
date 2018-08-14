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
 * | @information        | 消息回复
 * + --------------------------------------------------------------------
 * | @create-date        | 2018-08-07
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

class MessageController extends Controller
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
     * 回复文本消息
     * @param $data
     */
    public function replyTextMessage($data)
    {
        $message = '<xml>'
            . '<ToUserName>' . $data['to_user'] . '</ToUserName>'
            . '<FromUserName>' . $data['from_user'] . '</FromUserName>'
            . '<CreateTime>' . time() . '</CreateTime>'
            . '<MsgType>text</MsgType>'
            . '<Content>' . $data['content'] . '</Content>'
            . '</xml>';
        echo $message;
    }

    /**
     * 回复图片消息
     * @param $data
     */
    public function replyImageMessage($data)
    {
        $message = '<xml>'
            . '<ToUserName>' . $data['to_user'] . '</ToUserName>'
            . '<FromUserName>' . $data['from_user'] . '</FromUserName>'
            . '<CreateTime>' . time() . '</CreateTime>'
            . '<MsgType>image</MsgType>'
            . '<Image>'
            . '<MediaId>' . $data['media_id'] . '</MediaId>'
            . '</Image>'
            . '</xml>';
        echo $message;
    }

    /**
     * 回复图文消息
     * @param $data
     */
    public function replyNewsMessage($data)
    {
        $articles = '';
        foreach ($data['articles'] as $article) {
            $articles .= '<item>'
                . '<Title>' . $article['title'] . '</Title>'
                . '<Description>' . $article['description'] . '</Description>'
                . '<PicUrl>' . $article['pic_url'] . '</PicUrl>'
                . '<Url>' . $article['url'] . '</Url>'
                . '</item>';
        }
        $message = '<xml>'
            . '<ToUserName>' . $data['to_user'] . '</ToUserName>'
            . '<FromUserName>' . $data['from_user'] . '</FromUserName>'
            . '<CreateTime>' . time() . '</CreateTime>'
            . '<MsgType>news</MsgType>'
            . '<ArticleCount>' . $data['article_count'] . '</ArticleCount>'
            . '<Articles>' . $articles . '</Articles>'
            . '</xml>';
        echo $message;
    }

    /**
     * 回复语音消息
     * @param $data
     */
    public function replyVoiceMessage($data)
    {
        $message = '<xml>'
            . '<ToUserName>' . $data['to_user'] . '</ToUserName>'
            . '<FromUserName>' . $data['from_user'] . '</FromUserName>'
            . '<CreateTime>' . time() . '</CreateTime>'
            . '<MsgType>voice</MsgType>'
            . '<Voice>'
            . '<MediaId>' . $data['media_id'] . '</MediaId>'
            . '</Voice>'
            . '</xml>';
        echo $message;
    }

    /**
     * 回复音乐消息
     * @param $data
     */
    public function replyMusicMessage($data)
    {
        $message = '<xml>'
            . '<ToUserName>' . $data['to_user'] . '</ToUserName>'
            . '<FromUserName>' . $data['from_user'] . '</FromUserName>'
            . '<CreateTime>' . time() . '</CreateTime>'
            . '<MsgType>music</MsgType>'
            . '<Music>'
            . '<Title>' . $data['title'] . '</Title>'
            . '<Description>' . $data['description'] . '</Description>'
            . '<MusicUrl>' . $data['music_url'] . '</MusicUrl>'
            . '<HQMusicUrl>' . $data['HQ_music_url'] . '</HQMusicUrl>'
            . '<ThumbMediaId>' . $data['thumb_media_id'] . '</ThumbMediaId>'
            . '</Music>'
            . '</xml>';
        echo $message;
    }

    /**
     * 回复视频消息
     * @param $data
     */
    public function replyVideoMessage($data)
    {
        $message = '<xml>'
            . '<ToUserName>' . $data['to_user'] . '</ToUserName>'
            . '<FromUserName>' . $data['from_user'] . '</FromUserName>'
            . '<CreateTime>' . time() . '</CreateTime>'
            . '<MsgType>video</MsgType>'
            . '<Video>'
            . '<MediaId>' . $data['media_id'] . '</MediaId>'
            . '<Title>' . $data['title'] . '</Title>'
            . '<Description>' . $data['description'] . '</Description>'
            . '</Video>'
            . '</xml>';
        echo $message;
    }
}