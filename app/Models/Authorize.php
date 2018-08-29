<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authorize extends Model
{
    //设置数据库表名
    protected $table = 'authorize';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'role_id', 'rules', 'created_at', 'updated_at'];

    //获得角色
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }
}
