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
 * | @information        | demo
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WeChatTestController extends Controller
{
    private $wechat;
    private $accessToken;

    public function __construct()
    {
        $this->wechat = new BaseSupportController();
    }

    /**
     * 微信签名校验
     * @param $request
     */
    public function index(Request $request)
    {
        $signature = $request->signature;
        $timestamp = $request->timestamp;
        $nonce = $request->nonce;
        $token = env('wechat_token');
        $echostr = $request->echostr;
        $auth_rel = $this->wechat->auth($token, $timestamp, $nonce, $signature);
        if ($auth_rel) {
            echo $echostr;
        }
        $this->checkAccessToken($this->wechat);
        $xmlData = file_get_contents('php://input');
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $this->actionTriggerCenter($data);
    }

    /**
     * 检查 access_token 是否可用
     * @return bool
     */
    public function checkAccessToken()
    {
        try {
            $is_wechat_access_exists = Storage::disk('local')->exists('wechat.json');
            if ($is_wechat_access_exists) {
                $wechat_access = Storage::get('wechat.json');
                $wechat_access = json_decode($wechat_access, true);
                if ($wechat_access['expires_time'] > time()) {
                    $this->accessToken = $wechat_access['access_token'];
                    return 'ok';
                }
            }
            $access_token = $this->wechat->getAccessToken();
            $this->accessToken = $access_token['access_token'];
            $wechat_access['access_token'] = $access_token['access_token'];
            $wechat_access['expires_time'] = 7000 + time();
            Storage::put('wechat.json', json_encode($wechat_access));
            return 'ok';
        } catch (\Exception $e) {
            $this->resetAccessTokenFile();
            return $e->getMessage();
        }
    }

    /**
     * 删除 access_token 文件（下次接口访问会重新获取access_token）
     */
    public function resetAccessTokenFile()
    {
        $is_wechat_access_exists = Storage::disk('local')->exists('wechat.json');
        if ($is_wechat_access_exists) {
            $rel = Storage::delete('wechat.json');
            return $rel;
        }
        return 'wechat.json does not exist';
    }

    public function actionTriggerCenter($data)
    {
        Log::info($data);
        $message = new MessageController();
        $reply = [
            'to_user' => $data['FromUserName'],
            'from_user' => $data['ToUserName']
        ];
        if ('text' == $data['MsgType']) {
            if ('1' == $data['Content']) {
                $reply['content'] = '哈哈哈哈，就知道你会来';
                $message->replyTextMessage($reply);
            } else if ('2' == $data['Content']) {
                $reply['media_id'] = '33vIWlhJ-cPJVILnaMeTZ6hUbo1V5YinMEDH27q4U566pugWYhdclQcokbvpQgmH';
                $message->replyImageMessage($reply);
            } else if ('3' == $data['Content']) {
                $reply['article_count'] = '2';
                $reply['articles'] = [
                    [
                        'title' => '走开别烦我，凑不要脸滴',
                        'description' => '走开别烦我，凑不要脸滴',
                        'pic_url' => 'http://mmbiz.qpic.cn/mmbiz_jpg/QkVTJUbWPMrqJuPP1dpOo6foYdXibyuq8csXichlJS2TwaNyR3eyPymyTqCPmszIWl7gjUnibHDZXMvPic7SXUdaeA/0',
                        'url' => 'http://9wh5vf.natappfree.cc'
                    ], [
                        'title' => '走开别烦我，凑不要脸滴2',
                        'description' => '走开别烦我，凑不要脸滴2',
                        'pic_url' => 'http://mmbiz.qpic.cn/mmbiz_jpg/QkVTJUbWPMrqJuPP1dpOo6foYdXibyuq8csXichlJS2TwaNyR3eyPymyTqCPmszIWl7gjUnibHDZXMvPic7SXUdaeA/0',
                        'url' => 'http://9wh5vf.natappfree.cc'
                    ]
                ];
                $message->replyNewsMessage($reply);
            } else if ('4' == $data['Content']) {
                $reply['media_id'] = 'U2mcFnbhiCC1rJfeUxUUsJWahLB3wOI-6_0diT7tKmBHg107P18lPXA17CTGNqOg';
                $message->replyVoiceMessage($reply);
            } else if ('5' == $data['Content']) {
                $reply['title'] = '小水果';
                $reply['description'] = 'have a song';
                $reply['music_url'] = 'http://www.phpos.net/music/xsg.mp3';
                $reply['HQ_music_url'] = '';
                $reply['thumb_media_id'] = '33vIWlhJ-cPJVILnaMeTZ6hUbo1V5YinMEDH27q4U566pugWYhdclQcokbvpQgmH';
                $message->replyMusicMessage($reply);
            } else if ('6' == $data['Content']) {
                $reply['title'] = 'choelchoelchoel';
                $reply['description'] = 'have a movie';
                $reply['media_id'] = 'VVbADWTDX6-kO_FJn9-hAf-vJdL9xFpmuh1Y-ZQwq0yV8bAAJK9FmaRsqK85xDWf';
                $message->replyVideoMessage($reply);
            } else {
                $reply['content'] = '走开别烦我，凑不要脸滴';
                $message->replyTextMessage($reply);
            }
        }
    }

    /**
     * 设置自定义菜单---只需要按照格式传入需要的菜单数组即可
     * （存在的菜单类型有：click、view、miniprogram、scancode_waitmsg、scancode_push、
     * pic_sysphoto、pic_photo_or_album、pic_weixin、location_select、view_limited）
     * （规则详见：微信公众平台技术开发文档>>自定义菜单创建接口）
     * @return mixed （{"errcode":0,"errmsg":"ok"}）
     */
    public function setMenuInstance()
    {
        $menu = new MenuController();
        $data = [
            "button" => [
                [
                    "type" => "click",
                    "name" => "今日歌曲",
                    "key" => "V1001_TODAY_MUSIC"
                ], [
                    "name" => "菜单",
                    "sub_button" => [
                        [
                            "type" => "view",
                            "name" => "搜索",
                            "url" => "http://www.soso.com"
                        ], [
                            "type" => "pic_photo_or_album",
                            "name" => "拍照或者相册发图",
                            "key" => "rselfmenu_1_1"
                        ], [
                            "name" => "发送位置",
                            "type" => "location_select",
                            "key" => "rselfmenu_2_0"
                        ]
                    ]
                ], [
                    "name" => "菜单二",
                    "sub_button" => [
                        [
                            "type" => "scancode_waitmsg",
                            "name" => "扫码带提示",
                            "key" => "rselfmenu_0_0"
                        ], [
                            "type" => "scancode_push",
                            "name" => "扫码推事件",
                            "key" => "rselfmenu_0_1"
                        ], [
                            "type" => "pic_weixin",
                            "name" => "微信相册发图",
                            "key" => "rselfmenu_1_2"
                        ]
                    ]
                ]
            ]
        ];
        $this->checkAccessToken();
        $rel = $menu->setMenu($data, $this->accessToken);
        return $rel;
    }

    /**
     * 自定义菜单查询
     * （规则详见：微信公众平台技术开发文档>>自定义菜单查询接口）
     * @return mixed （返回值中menu为默认菜单，conditionalmenu为个性化菜单列表）
     */
    public function getMenuInstance()
    {
        $menu = new MenuController();
        $this->checkAccessToken();
        $rel = $menu->getMenu($this->accessToken);
        return $rel;
    }

    /**
     * 自定义菜单删除
     * （规则详见：微信公众平台技术开发文档>>自定义菜单删除接口）
     * @return mixed （对应创建接口，正确的Json返回结果:{"errcode":0,"errmsg":"ok"}）
     */
    public function deleteMenuInstance()
    {
        $menu = new MenuController();
        $this->checkAccessToken();
        $rel = $menu->deleteMenu($this->accessToken);
        return $rel;
    }

    /**
     * 创建标签
     * （规则详见：微信公众平台技术开发文档>>用户标签管理）
     * @return mixed （返回示例：{"tag": {"id": 100,"name": "第一组"}}）
     */
    public function createTagsInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $rel = $user->createTags($this->accessToken, '第一组');
        return $rel;
    }

    /**
     * 获取公众号已创建的标签
     * （规则详见：微信公众平台技术开发文档>>用户标签管理）
     * @return mixed (返回示例：{"tags":[{"id":2,"name":"\u661f\u6807\u7ec4","count":0},{"id":100,"name":"\u7b2c\u4e00\u7ec4","count":0}]})
     */
    public function getTagsInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $rel = $user->getTags($this->accessToken);
        return $rel;
    }

    /**
     * 编辑标签
     * （规则详见：微信公众平台技术开发文档>>用户标签管理）
     * @return mixed （返回示例：{"errcode":0,"errmsg":"ok"}）
     */
    public function editTagsInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            'id' => 100,
            'name' => '新建'
        ];
        $rel = $user->editTags($this->accessToken, $data);
        return $rel;
    }

    /**
     * 删除标签
     * （请注意，当某个标签下的粉丝超过10w时，后台不可直接删除标签。
     * 此时，开发者可以对该标签下的openid列表，先进行取消标签的操作，直到粉丝数不超过10w后，才可直接删除该标签。）
     * （不能修改0/1/2这三个系统默认保留的标签）
     * （规则详见：微信公众平台技术开发文档>>用户标签管理）
     * @return mixed （返回示例：{"errcode":0,"errmsg":"ok"}）
     */
    public function deleteTagsInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $id = '100';
        $rel = $user->deleteTags($this->accessToken, $id);
        return $rel;
    }

    /**
     * 获取标签下的用户
     * （规则详见：微信公众平台技术开发文档>>用户标签管理）
     * @return mixed （返回示例：{"count":2,"data":{"openid":["ocYxcuAEy30bX0NXmGn4ypqx3tI0","ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"]},
     * "next_openid":"ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"}）
     */
    public function getUserByTagInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            'tag_id' => '101',
            'next_openid' => ''
        ];
        $rel = $user->getUserByTag($this->accessToken, $data);
        return $rel;
    }

    /**
     * 批量给用户添加标签
     * （规则详见：微信公众平台技术开发文档>>用户标签管理）
     * @return mixed （返回示例：{"errcode":0,"errmsg":"ok"}）
     */
    public function addTagsToUserInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            "openid_list" => [//粉丝列表
                "ojBInwd9dqe_9XOZcBCFReeA9yLA",
                "ojBInwdddTmpw-YiD-XwkOzYCeeM",
                "ojBInwUim6a4GNwOBptiAPA_aFj8"
            ],
            "tagid" => '101'
        ];
        $rel = $user->addTagsToUser($this->accessToken, $data);
        return $rel;
    }

    /**
     * 批量给用户取消标签
     * （规则详见：微信公众平台技术开发文档>>用户标签管理）
     * @return mixed （返回示例：{"errcode":0,"errmsg":"ok"}）
     */
    public function cancelTagsToUserInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            "openid_list" => [
                "ojBInwd9dqe_9XOZcBCFReeA9yLA",
                "ojBInwdddTmpw-YiD-XwkOzYCeeM",
                "ojBInwUim6a4GNwOBptiAPA_aFj8"
            ],
            "tagid" => '101'
        ];
        $rel = $user->cancelTagsToUser($this->accessToken, $data);
        return $rel;
    }

    /**
     * 查询用户标签
     * （规则详见：微信公众平台技术开发文档>>用户标签管理）
     * @return mixed (返回示例：{"tagid_list":[134,2]})
     */
    public function getUserTagsInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $open_id = 'ojBInwd9dqe_9XOZcBCFReeA9yLA';
        $rel = $user->getUserTags($this->accessToken, $open_id);
        return $rel;
    }

    /**
     * 设置用户备注名
     * （规则详见：微信公众平台技术开发文档>>设置用户备注名）
     * @return mixed （返回示例：{"errcode":0,"errmsg":"ok"}）
     */
    public function setRemarkInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            'open_id' => 'ojBInwd9dqe_9XOZcBCFReeA9yLA',
            'remark' => '我'
        ];
        $rel = $user->setRemark($this->accessToken, $data);
        return $rel;
    }

    /**
     * 获取用户基本信息
     * （规则详见：微信公众平台技术开发文档>>获取用户基本信息(UnionID机制)）
     * @return mixed （返回示例：{"subscribe": 1,"openid": "ojBInwd9dqe_9XOZcBCFReeA9yLA","nickname": "风儿","sex": 2,"language": "zh_CN",
     * "city": "兰州市","province": "甘肃","country": "中国",
     * "headimgurl": "http://thirdwx.qlogo.cn/mmopen/aqmJ7bg9icrX8kW2EZT90EgCxUf9xyWUPicS1aMQAHBj2EIJpTOyNowOuytcqskJrliaq49wjkbxXhicGrLFd3eHfP0gEAhLibBYM/132",
     * "subscribe_time": 1533109320,"remark": "我","groupid": 0,"tagid_list": [],"subscribe_scene": "ADD_SCENE_QR_CODE",
     * "qr_scene": 0,"qr_scene_str": ""}）
     */
    public function getUserInfoInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            'open_id' => 'ojBInwd9dqe_9XOZcBCFReeA9yLA',
            'lang' => 'zh_CN'
        ];
        $rel = $user->getUserInfo($this->accessToken, $data);
        return $rel;
    }

    /**
     * 获取多个用户基本信息
     * （规则详见：微信公众平台技术开发文档>>获取用户基本信息(UnionID机制)）
     * @return mixed （返回示例：{"user_info_list": [{"subscribe": 1,"openid": "ojBInwdddTmpw-YiD-XwkOzYCeeM",
     * "nickname": "从入门👉 到颈椎病","sex": 1,"language": "zh_CN","city": "兰州市","province": "甘肃","country": "中国",
     * "headimgurl": "http://thirdwx.qlogo.cn/mmopen/KLITgpYWhgLCTvzDhW7oYhuYyJeLym85XePaLxEqTe5ZV5nozLjCj5b5rlSGrsmwQKTPt1bhyt6H9GnwmU1UN0MG6w74ibkKH/132",
     * "subscribe_time": 1533276747,"remark": "","groupid": 0,"tagid_list": [],"subscribe_scene": "ADD_SCENE_QR_CODE",
     * "qr_scene": 0,"qr_scene_str": ""},
     * {"subscribe": 1,"openid": "ojBInwd9dqe_9XOZcBCFReeA9yLA","nickname": "风儿","sex": 2,"language": "zh_CN",
     * "city": "兰州市","province": "甘肃","country": "中国",
     * "headimgurl": "http://thirdwx.qlogo.cn/mmopen/aqmJ7bg9icrX8kW2EZT90EgCxUf9xyWUPicS1aMQAHBj2EIJpTOyNowOuytcqskJrliaq49wjkbxXhicGrLFd3eHfP0gEAhLibBYM/132",
     * "subscribe_time": 1533109320,"remark": "我","groupid": 0,"tagid_list": [],"subscribe_scene": "ADD_SCENE_QR_CODE",
     * "qr_scene": 0,"qr_scene_str": ""}]}）
     */
    public function getMultiUserInfoInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            "user_list" => [
                [
                    "openid" => "ojBInwdddTmpw-YiD-XwkOzYCeeM",
                    "lang" => "zh_CN"
                ], [
                    "openid" => "ojBInwd9dqe_9XOZcBCFReeA9yLA",
                    "lang" => "zh_CN"
                ]
            ]
        ];
        $rel = $user->getMultiUserInfo($this->accessToken, $data);
        return $rel;
    }

    /**
     * 获取用户列表
     * （一次拉取调用最多拉取10000个关注者的OpenID，可以通过多次拉取的方式来满足需求）
     * （规则详见：微信公众平台技术开发文档>>获取用户列表）
     * @return mixed （返回示例：{"total":7,"count":7,"data":{"openid":["ojBInwd9dqe_9XOZcBCFReeA9yLA",
     * "ojBInwdddTmpw-YiD-XwkOzYCeeM","ojBInwUim6a4GNwOBptiAPA_aFj8","ojBInwdPdhvwjRqbsmM0WSRfZ_Y8",
     * "ojBInwRTrcrQ1v9fwuqpgFZMwOEE","ojBInwWZO_7igYl6fWGxdztcsd70","ojBInwUqFOLH9OJl3dBIBMLFKp0s"]},
     * "next_openid":"ojBInwUqFOLH9OJl3dBIBMLFKp0s"}）
     */
    public function getUserListInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $next_open_id = '';
        $rel = $user->getUserList($this->accessToken, $next_open_id);
        return $rel;
    }

    /**
     * 获取公众号的黑名单列表
     * （规则详见：微信公众平台技术开发文档>>黑名单管理）
     * @return mixed （返回示例：{"total":23000,"count":10000,"data":{"openid":["OPENID1","OPENID2",...,"OPENID10000"]},"next_openid":"OPENID10000"}）
     */
    public function getBlackListInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $begin_open_id = '';
        $rel = $user->getBlackList($this->accessToken, $begin_open_id);
        return $rel;
    }

    /**
     * 拉黑用户
     * （规则详见：微信公众平台技术开发文档>>黑名单管理）
     * @return mixed (返回示例：{"errcode":0,"errmsg":"ok"})
     */
    public function putUserInBlackListInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            "openid_list" => [
                'ojBInwdddTmpw-YiD-XwkOzYCeeM',
                'ojBInwd9dqe_9XOZcBCFReeA9yLA'
            ]
        ];
        $rel = $user->putUserInBlackList($this->accessToken, $data);
        return $rel;
    }

    /**
     * 取消拉黑用户
     * （规则详见：微信公众平台技术开发文档>>黑名单管理）
     * @return mixed (返回示例：{"errcode":0,"errmsg":"ok"})
     */
    public function removeUserFromBlackListInstance()
    {
        $user = new UserController();
        $this->checkAccessToken();
        $data = [
            "openid_list" => [
                'ojBInwdddTmpw-YiD-XwkOzYCeeM',
                'ojBInwd9dqe_9XOZcBCFReeA9yLA'
            ]
        ];
        $rel = $user->removeUserFromBlackList($this->accessToken, $data);
        return $rel;
    }

    /**
     * 生成二维码
     * （action_name    二维码类型，QR_SCENE为临时的整型参数值，QR_STR_SCENE为临时的字符串参数值，QR_LIMIT_SCENE为永久的整型参数值，
     * QR_LIMIT_STR_SCENE为永久的字符串参数值）
     * （规则详见：微信公众平台技术开发文档>>生成带参数的二维码）
     * @return mixed （返回示例：{"ticket": "gQEu8DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZ1ZTSDhmY2ljRDExbG91SjFyMUUAAgTYI2RbAwSAOgkA",
     * "expire_seconds": 604800,"url": "http://weixin.qq.com/q/02gVSH8fcicD11louJ1r1E"}）
     */
    public function createQrCodeInstance()
    {
        $account = new AccountController();
        $this->checkAccessToken();
        $data = [
            "action_name" => "QR_LIMIT_STR_SCENE",
            "action_info" => [
                "scene" => [
                    "scene_str" => "test"
                ]
            ]
        ];
        $rel = $account->createQrCode($this->accessToken, $data);
        return $rel;
    }

    /**
     * 展示二维码
     * （规则详见：微信公众平台技术开发文档>>生成带参数的二维码）
     */
    public function showQrCodeInstance()
    {
        $account = new AccountController();
        $ticket = 'gQGJ8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyNERJMjlCY2ljRDExMDAwMGcwN0cAAgTS9GdbAwQAAAAA';
        $rel = $account->showQrCode($ticket);
        $file_name = '/uploads/wechat/qr_code/' . date('YmdHis', time()) . substr(md5($ticket), 8, 16) . '.jpg';
        Storage::put($file_name, $rel);
        echo '<img src="' . $file_name . '" />';
        echo $file_name;
    }

    /**
     * 长链接转短链接接口
     * （规则详见：微信公众平台技术开发文档>>长链接转短链接接口）
     * @return mixed
     */
    public function longUrlToShortInstance()
    {
        $account = new AccountController();
        $this->checkAccessToken();
        $long_url = "http://wap.koudaitong.com/v2/showcase/goods?alias=128wi9shh&spm=h56083&redirect_count=1";
        $rel = $account->longUrlToShort($this->accessToken, $long_url);
        return $rel;
    }

    /**
     * 用户同意授权，获取code
     * （规则详见：微信公众平台技术开发文档>>微信网页授权）
     * @return \Illuminate\Http\RedirectResponse
     * （返回示例'code' => string '001ibzkZ1OtOx11PSJgZ1TKekZ1ibzkN','state' => string 'STATE' ）
     */
    public function getCodeInstance()
    {
        $web = new WebController();
//        $data['scope'] = 'snsapi_userinfo';
        $data['scope'] = 'snsapi_base';
        $data['uri'] = url('wechat/test');
        $rel = $web->getCode($data);
        return $rel;
    }

    /**
     * 通过code换取网页授权access_token
     * （规则详见：微信公众平台技术开发文档>>微信网页授权）
     * @return mixed
     * (返回示例：{"access_token":"12_8gXAzC_DfPEu8eR_LDqcBh9WZWMbtSUTmWLSmfLuH8l0BL1vHq-dnjxGd3cmN1XCRTJxJd14-TMXDKjEBxp61w",
     * "expires_in":7200,
     * "refresh_token":"12_SmaYwlK5yrcV3JdS-SGMb4aLRnPS-DAHOYg9WOnXU8LmBPpXz2IPViFhBaPY1-63Q6xXixSPtF00WIKQPhZR-A",
     * "openid":"ojBInwdddTmpw-YiD-XwkOzYCeeM","scope":"snsapi_userinfo"})
     */
    public function getAccessTokenInstance()
    {
        $web = new WebController();
        $code = '0611bsQd01aVaB17ZsQd0yHsQd01bsQC';
        $rel = $web->getAccessToken($code);
        return $rel;
    }

    /**
     * 刷新access_token（如果需要）
     * （规则详见：微信公众平台技术开发文档>>微信网页授权）
     * @return mixed (返回示例: {"openid": "ojBInwdddTmpw-YiD-XwkOzYCeeM",
     * "access_token": "12_wYhub_PsJSUdKYz4BDh61Wfn92cxtyOxIIV2cqIDoNjkdrPmRxDp1WvKeQe5bj0az0DDcQCCIyOmIVRQs7yBGw",
     * "expires_in": 7200,
     * "refresh_token": "12_Tte3X0sD6v9IT_qzkq58vo7QTX3gg4kbpSDlOcxm2loxla9TS8dppgEVK2kEaCL2zWilAooyW6YzXLtWXgSfPw",
     * "scope": "snsapi_base,snsapi_userinfo,"})
     */
    public function refreshTokenInstance()
    {
        $web = new WebController();
        $refresh_token = '12_Tte3X0sD6v9IT_qzkq58vo7QTX3gg4kbpSDlOcxm2loxla9TS8dppgEVK2kEaCL2zWilAooyW6YzXLtWXgSfPw';
        $rel = $web->refreshToken($refresh_token);
        return $rel;
    }

    /**
     * 拉取用户信息
     * （规则详见：微信公众平台技术开发文档>>微信网页授权）
     * @return mixed （返回示例：{"openid": "ojBInwdddTmpw-YiD-XwkOzYCeeM","nickname": "从入门👉 到颈椎病","sex": 1,"language": "zh_CN",
     * "city": "兰州市","province": "甘肃","country": "中国",
     * "headimgurl": "http://thirdwx.qlogo.cn/mmopen/vi_32/D8bkSANQeKRhItDM1OWcac1ScyaCjhxXP2oNTbsODrshdIFR6RibIV3gU99VQIexfwQEJ0JHULZUkYD8yOlYYzg/132",
     * "privilege": []}）
     */
    public function getUserInfoByWebAuth()
    {
        $web = new WebController();
        $data['open_id'] = 'ojBInwdddTmpw-YiD-XwkOzYCeeM';
        $data['access_token'] = '12_JvlWsF32xrOj7qTvdp1cbKFDwqW0qdPBgho8vL5Acfb3rOtZl0a8owyzvCXK3Ox3__zykMs296CZuu14y6CeTA';
        $data['lang'] = 'zh_CN';
        $rel = $web->getUserInfo($data);
        return $rel;
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * （规则详见：微信公众平台技术开发文档>>微信网页授权）
     * @return mixed (返回示例：{"errcode":0,"errmsg":"ok"})
     */
    public function checkAccessTokenInstance()
    {
        $web = new WebController();
        $access_token = '12_wYhub_PsJSUdKYz4BDh61Wfn92cxtyOxIIV2cqIDoNjkdrPmRxDp1WvKeQe5bj0az0DDcQCCIyOmIVRQs7yBGw';
        $open_id = 'ojBInwdddTmpw-YiD-XwkOzYCeeM';
        $rel = $web->checkAccessToken($access_token, $open_id);
        return $rel;
    }

    /**
     * 新增临时素材
     * （1、临时素材media_id是可复用的。2、媒体文件在微信后台保存时间为3天，即3天后media_id失效。3、上传临时素材的格式、大小限制与公
     * 众平台官网一致。
     * 图片（image）: 2M，支持PNG\JPEG\JPG\GIF格式    语音（voice）：2M，播放长度不超过60s，支持AMR\MP3格式
     * 视频（video）：10MB，支持MP4格式               缩略图（thumb）：64KB，支持JPG格式）
     * （规则详见：微信公众平台技术开发文档>>新增临时素材）
     * @return mixed
     * (返回示例： {"type": "image","media_id": "Pv91I_pCktQ9wMTjCR24vGYQLrCoFYVcDvizz_y9Vp31PqshnirjaRAoFzFSaTr7",
     * "created_at": 1533609967})
     */
    public function addTemporaryMaterialInstance()
    {
        $material = new MaterialController();
        $this->checkAccessToken();
        $data = [
            'access_token' => $this->accessToken,
            'type' => 'voice',
            'path' => 'C:\Users\Choel\Desktop\10420.mp3'
        ];
        $rel = $material->addTemporaryMaterial($data);
        return $rel;
    }

    /**
     * 获取临时素材
     * （请注意文件类型，最好同意文件类型，避免无法查看的问题）
     * （规则详见：微信公众平台技术开发文档>>获取临时素材）
     * （如果返回的是视频消息素材，则内容如下：{"video_url":DOWN_URL}）
     */
    public function getTemporaryMaterialInstance()
    {
        $material = new MaterialController();
        $this->checkAccessToken();
        $media_id = 'Pv91I_pCktQ9wMTjCR24vGYQLrCoFYVcDvizz_y9Vp31PqshnirjaRAoFzFSaTr7';
        $rel = $material->getTemporaryMaterial($this->accessToken, $media_id);
        //3DNMr_trlw0balHOPWAOEgh_nFHb5pIoEi7MieuGTkJbEc8lkHERBoCIfRVWkr77
        $file_name = '/uploads/wechat/material/' . date('YmdHis', time()) . substr(md5($media_id), 8, 16) . '.png';
        Storage::put($file_name, $rel['content']);
//        $type = $rel['content_type'];

        /*----------------------图片素材示例------------------------*/
        echo '<img src="' . $file_name . '" />';
        echo mime_content_type(public_path($file_name));
        echo $file_name;
        /*---------------------------------------------------------*/
    }

    /**
     * 新增其他类型永久素材
     * （1、临时素材media_id是可复用的。2、媒体文件在微信后台保存时间为3天，即3天后media_id失效。3、上传临时素材的格式、大小限制与公
     * 众平台官网一致。
     * 图片（image）: 2M，支持PNG\JPEG\JPG\GIF格式    语音（voice）：2M，播放长度不超过60s，支持AMR\MP3格式
     * 视频（video）：10MB，支持MP4格式               缩略图（thumb）：64KB，支持JPG格式）
     * （规则详见：微信公众平台技术开发文档>>新增临时素材）
     * @return mixed
     * (返回示例： {"media_id": "SPQ8dXZJ7TQ1C607OjuRH9kbZNby07NNDRQtC9vMdMw",
     * "url": "http://mmbiz.qpic.cn/mmbiz_jpg/QkVTJUbWPMrqJuPP1dpOo6foYdXibyuq8G32etB32haqFZXY7SwYD6gxoukroGC0Kl3TB6MsDmL1wtYhHbecbgA/0?wx_fmt=jpeg"})
     */
    public function addPermanentMaterialInstance()
    {
        $material = new MaterialController();
        $this->checkAccessToken();
        $data = [
            'access_token' => $this->accessToken,
            'type' => 'image',
            'path' => 'C:\Users\Choel\Pictures\wallpaper\giFnui8.jpg'
        ];
        $rel = $material->addPermanentMaterial($data);
        return $rel;
    }

    /**
     * 上传图文消息内的图片获取URL
     * （本接口所上传的图片不占用公众号的素材库中图片数量的5000个的限制。图片仅支持jpg/png格式，大小必须在1MB以下。）
     * （规则详见：微信公众平台技术开发文档>>新增永久素材）
     * @return mixed (返回示例：{"url": "http://mmbiz.qpic.cn/mmbiz_jpg/QkVTJUbWPMrqJuPP1dpOo6foYdXibyuq8csXichlJS2TwaNyR3eyPymyTqCPmszIWl7gjUnibHDZXMvPic7SXUdaeA/0"})
     */
    public function addPermanentImageInstance()
    {
        $material = new MaterialController();
        $this->checkAccessToken();
        $path = "C:\Users\Choel\Pictures\wallpaper\giFnui8.jpg";
        $rel = $material->addPermanentImage($this->accessToken, $path);
        return $rel;
    }

    /**
     * 新增永久图文素材
     * （规则详见：微信公众平台技术开发文档>>新增永久素材  或   微信公众平台技术开发文档>>图文消息留言管理接口）
     * @return mixed （返回示例： {"media_id": "SPQ8dXZJ7TQ1C607OjuRH-O9dSIl4fsIi9ThmxXplhE"}）
     */
    public function addPermanentNewsInstance()
    {
        $material = new MaterialController();
        $this->checkAccessToken();
        $data = [
            "articles" => [
                [
                    "title" => "title",
                    "thumb_media_id" => 'SPQ8dXZJ7TQ1C607OjuRH9kbZNby07NNDRQtC9vMdMw',
                    "author" => "AUTHOR",
                    "digest" => "it is the test for function >> addPermanentNews()",
                    "show_cover_pic" => 1,
                    "content" => "图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS,涉及图片url必须来源 
                '上传图文消息内的图片获取URL'接口获取。外部图片url将被过滤。",
                    "content_source_url" => 'http://8vjgf5.natappfree.cc'
                ], [
                    "title" => "title",
                    "thumb_media_id" => 'SPQ8dXZJ7TQ1C607OjuRH6jv-xrdlja-IUKRgsGH-Rg',
                    "author" => "AUTHOR",
                    "digest" => "it is the test for function >> addPermanentNews()",
                    "show_cover_pic" => 0,
                    "content" => "图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS,涉及图片url必须来源 
                '上传图文消息内的图片获取URL'接口获取。外部图片url将被过滤。",
                    "content_source_url" => 'http://8vjgf5.natappfree.cc'
                ],
            ]
        ];
        $rel = $material->addPermanentNews($this->accessToken, $data);
        return $rel;
    }

    /**
     * 获取永久素材
     * （规则详见：微信公众平台技术开发文档>>新增临时素材）
     * @return mixed
     */
    public function getPermanentMaterialInstance()
    {
        $material = new MaterialController();
        $this->checkAccessToken();
        $media_id = 'as_5KKOw0VTBU4KjS1AUSnKa4sAsSJQYcGtLlLRLw8-CArrMBFeeU3dVdHHYfTsc';
        $rel = $material->getPermanentMaterial($this->accessToken, $media_id);
        return $rel;
    }

    /**
     * 群发消息
     * （规则详见：微信公众平台技术开发文档>>群发接口和原创校验）
     * @return mixed
     */
    public function massMessageInstance()
    {
        $massMessage = new MassMessageController();
        $this->checkAccessToken();
//        $data = [
//            "mass_type" => "tag",
//            "post_data" => [
//                "filter" => [
//                    "is_to_all" => true
//                ],
//                "mpnews" => [
//                    "media_id" => "SPQ8dXZJ7TQ1C607OjuRH-O9dSIl4fsIi9ThmxXplhE"
//                ],
//                "msgtype" => "mpnews",
//                "send_ignore_reprint" => 0
//            ]
//        ];
//        $data = [
//            "mass_type" => "tag",
//            "post_data" => [
//                "filter" => [
//                    "is_to_all" => true
//                ],
//                "text" => [
//                    "content" => "群发接口文本消息测试"
//                ],
//                "msgtype" => "text"
//            ]
//        ];
        $data = [
            "mass_type" => "tag",
            "post_data" => [
                "filter" => [
                    "is_to_all" => true
                ],
                "image" => [
                    "media_id" => "33vIWlhJ-cPJVILnaMeTZ6hUbo1V5YinMEDH27q4U566pugWYhdclQcokbvpQgmH"
                ],
                "msgtype" => "image"
            ]
        ];
        $rel = $massMessage->massMessage($this->accessToken, $data);
        return $rel;
    }

    /**
     * 设置所属行业
     * （设置行业可在微信公众平台后台完成，每月可修改行业1次，帐号仅可使用所属行业中相关的模板）
     * （规则详见：微信公众平台技术开发文档>>模板消息接口）
     * @return mixed （返回示例：{"errcode":0,"errmsg":"ok"}）
     */
    public function setIndustryInstance()
    {
        $template = new TemplateController();
        $this->checkAccessToken();
        $data = [
            "primary_industry" => "1",
            "secondary_industry" => "4"
        ];
        $rel = $template->setIndustry($this->accessToken, $data);
        return $rel;
    }

    /**
     * 获取设置的行业信息
     * （规则详见：微信公众平台技术开发文档>>模板消息接口）
     * @return mixed ({"primary_industry": {"first_class": "IT科技","second_class": "互联网|电子商务"},
     * "secondary_industry": {"first_class": "IT科技","second_class": "电子技术"}})
     */
    public function getIndustryInstance()
    {
        $template = new TemplateController();
        $this->checkAccessToken();
        $rel = $template->getIndustryInfo($this->accessToken);
        return $rel;
    }

    /**
     * 获得模板ID
     * （规则详见：微信公众平台技术开发文档>>模板消息接口）
     * @return mixed (返回示例：{"errcode":0,"errmsg":"ok","template_id":"mvGWpXF4sBOlLWK6-aR7xMbOSKjTIwMt49UT9zrXbGA"})
     */
    public function getTemplateIdInstance()
    {
        $template = new TemplateController();
        $this->checkAccessToken();
        $template_id_short = "TM00015";
        $rel = $template->getTemplateId($this->accessToken, $template_id_short);
        return $rel;
    }

    /**
     * 获取模板列表
     * （规则详见：微信公众平台技术开发文档>>模板消息接口）
     * @return mixed (返回示例：{"template_list": [{"template_id": "mvGWpXF4sBOlLWK6-aR7xMbOSKjTIwMt49UT9zrXbGA","title": "订单支付成功",
     * "primary_industry": "IT科技","deputy_industry": "互联网|电子商务","content": "{{first.DATA}}\n\n支付金额：{{orderMoneySum.DATA}}\n商品信息：{{orderProductName.DATA}}\n{{Remark.DATA}}",
     * "example": "我们已收到您的货款，开始为您打包商品，请耐心等待: )\n支付金额：30.00元\n商品信息：我是商品名字\n\n如有问题请致电400-828-1878或直接在微信留言，小易将第一时间为您服务！"
     * }]})
     */
    public function getTemplateListInstance()
    {
        $template = new TemplateController();
        $this->checkAccessToken();
        $rel = $template->getTemplateList($this->accessToken);
        return $rel;
    }

    /**
     * 删除模板
     * （规则详见：微信公众平台技术开发文档>>模板消息接口）
     * @return mixed (返回示例： {"errcode":0,"errmsg":"ok"})
     */
    public function deleteTemplateInstance()
    {
        $template = new TemplateController();
        $this->checkAccessToken();
        $template_id = 'mvGWpXF4sBOlLWK6-aR7xMbOSKjTIwMt49UT9zrXbGA';
        $rel = $template->deleteTemplate($this->accessToken, $template_id);
        return $rel;
    }

    /**
     * 发送模板消息
     * （url和miniprogram都是非必填字段，若都不传则模板无跳转；若都传，会优先跳转至小程序。开发者可根据实际需要选择其中一种跳转方式即可。
     * 当用户的微信客户端版本不支持跳小程序时，将会跳转至url。）
     * （规则详见：微信公众平台技术开发文档>>模板消息接口）
     * @return mixed (返回示例：{"errcode":0,"errmsg":"ok","msgid":412022993116479488})
     */
    public function sendTemplateMessageInstance()
    {
        $template = new TemplateController();
        $this->checkAccessToken();
        $data = [
            "touser" => "ojBInwdddTmpw-YiD-XwkOzYCeeM",
            "template_id" => "pN3861BLMb488BZFnMXYeOZzePsP2G76q9XOiJ4koXo",
            "url" => "http://weixin.qq.com/download",
            "miniprogram" => '',
            "data" => [
                "first" => [
                    "value" => "恭喜你购买成功！",
                    "color" => "#173177"
                ],
                "orderMoneySum" => [
                    "value" => "2",
                    "color" => "#173177"
                ],
                "orderProductName" => [
                    "value" => "巧克力",
                    "color" => "#173177"
                ],
                "remark" => [
                    "value" => "欢迎再次购买！",
                    "color" => "#173177"
                ]
            ]
        ];
        $rel = $template->sendTemplateMessage($this->accessToken, $data);
        return $rel;
    }

    /**
     * 一次性订阅授权
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribeOnceInstance()
    {
        $template = new TemplateController();
        $data = [
            'scene' => '100',
            'template_id' => 'pN3861BLMb488BZFnMXYeOZzePsP2G76q9XOiJ4koXo',
            'url' => 'http://radcfc.natappfree.cc',
            'reserved' => 'test'
        ];
        $rel = $template->subscribeOnce($data);
        return $rel;
    }

    public function getAutoReplyInstance() {
        $base = new BaseSupportController();
        $this->checkAccessToken();
        $rel = $base->getAutoReply($this->accessToken);
        return $rel;
    }

    public function test(Request $request)
    {
        $this->checkAccessToken();
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=' . $this->accessToken;
        $data = '{
             "kf_account" : "test1@gh_a6d05e0980c1",
             "nickname" : "客服1",
             "password" : "pswmd5",
        }';
        $http_curl = new HttpCurlController();
        $rel = $http_curl->post($url, $data);
        return $rel;
    }
}