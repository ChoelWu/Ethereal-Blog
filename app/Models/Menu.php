<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //设置数据库表名
    protected $table = 'menu';

    //数值主键非自增
    public $incrementing = false;

    //设置主键类型为字符串类型
    protected $keyType = 'string';

    //设置白名单
    protected $fillable = ['id', 'name', 'level', 'status', 'sort', 'parent_id', 'created_at', 'updated_at', 'icon', 'url'];

    //获取父菜单
    public function parent()
    {
        return $this->belongsTo('\App\Models\Menu', 'parent_id', 'id');
    }

    public function rules() {
        return $this->hasMany('\App\Models\Rule', 'menu_id', 'id');
    }
}
