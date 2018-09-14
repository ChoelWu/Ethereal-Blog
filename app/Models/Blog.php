<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //设置数据库表名
    protected $table = 'blog';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'title', 'footer', 'slogan', 'user_name', 'created_at', 'updated_at', 'user_open_img', 'user_profession', 'user_announce', 'user_bak', 'user_wechat', 'user_QQ', 'user_weibo', 'user_email', 'user_github', 'status'];
}
