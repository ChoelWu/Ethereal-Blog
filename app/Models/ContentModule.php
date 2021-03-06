<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentModule extends Model
{
    //设置数据库表名
    protected $table = 'content_module';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'name', 'type', 'nav_id', 'single_length', 'number', 'created_at', 'updated_date'];
}
