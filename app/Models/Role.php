<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //设置数据库表名
    protected $table = 'role';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'role_name', 'status', 'updated_at', 'created_date'];
}
