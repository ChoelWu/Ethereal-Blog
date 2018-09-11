<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    //设置数据库表名
    protected $table = 'poster';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'title', 'img', 'url', 'status', 'is_top', 'summary', 'updated_at', 'created_date'];
}
