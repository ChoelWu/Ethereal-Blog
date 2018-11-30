<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogUser extends Model
{
    //设置数据库表名
    protected $table = 'blog_user';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'user_id', 'blog_id', 'user_github', 'status'];
}
