<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //设置数据库表名
    protected $table = 'article';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'title', 'is_title_bold', 'title_color', 'sub_title', 'view_number', 'thumb_img', 'is_top', 'summary', 'source', 'content', 'status', 'publish_date', 'created_at', 'updated_date'];

    //获取导航信息
    public function nav()
    {
        return $this->belongsTo('\App\Models\Nav');
    }

    //获取导航信息
    public function tag()
    {
        return $this->belongsTo('\App\Models\Tag');
    }
}
