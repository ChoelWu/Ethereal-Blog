<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //设置数据库表名
    protected $table = 'comment';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'user_id', 'article_id', 'content', 'status', 'type', 'is_top', 'praise', 'response_id', 'updated_at', 'created_date'];

    //获取文章信息
    public function article()
    {
        return $this->belongsTo('\App\Models\Article');
    }

    //获取用户信息
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
