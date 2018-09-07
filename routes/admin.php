<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
|
*/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    //后台首页
    Route::get('index', 'IndexController@index');
    //菜单管理
    Route::get('menu/index', 'MenuController@index');
    Route::get('menu/add', 'MenuController@add');
    Route::post('menu/add', 'MenuController@add');
    Route::get('menu/edit/{id?}', 'MenuController@edit');
    Route::post('menu/edit', 'MenuController@edit');
    Route::get('menu/delete', 'MenuController@delete');
    Route::get('menu/update_status', 'MenuController@updateStatus');
    Route::get('menu/get_menu_level', 'MenuController@getMenulevel');
    //用户管理
    Route::get('user/index', 'UserController@index');
    Route::get('user/add', 'UserController@add');
    Route::post('user/add', 'UserController@add');
    Route::get('user/edit/{id?}', 'UserController@edit');
    Route::post('user/edit', 'UserController@edit');
    Route::get('user/upload', 'UserController@upload');
    Route::get('user/delete', 'UserController@delete');
    Route::get('user/update_status', 'UserController@updateStatus');
    //角色管理
    Route::get('role/index', 'RoleController@index');
    Route::get('role/add', 'RoleController@add');
    Route::post('role/add', 'RoleController@add');
    Route::get('role/edit/{id?}', 'RoleController@edit');
    Route::post('role/edit', 'RoleController@edit');
    Route::get('role/delete', 'RoleController@delete');
    Route::get('role/update_status', 'RoleController@updateStatus');
    Route::post('role/authorize', 'RoleController@authorizeRole');
    Route::get('role/get_authorize', 'RoleController@getAuthorize');
    //权限规则管理
    Route::get('rule/index', 'RuleController@index');
    Route::post('rule/index', 'RuleController@index');
    Route::get('rule/add', 'RuleController@add');
    Route::post('rule/add', 'RuleController@add');
    Route::get('rule/edit/{id?}', 'RuleController@edit');
    Route::post('rule/edit', 'RuleController@edit');
    Route::get('rule/delete', 'RuleController@delete');
    Route::get('rule/update_status', 'RuleController@updateStatus');
    //基本信息配置
    Route::get('info/index', 'InfoController@index');
    //导航管理
    Route::get('nav/index', 'NavController@index');
    Route::get('nav/add', 'NavController@add');
    Route::post('nav/add', 'NavController@add');
    Route::get('nav/edit/{id?}', 'NavController@edit');
    Route::post('nav/edit', 'NavController@edit');
    Route::get('nav/delete', 'NavController@delete');
    Route::get('nav/update_status', 'NavController@updateStatus');
    Route::get('nav/get_nav_level', 'NavController@getNavlevel');
    //标签管理
    Route::get('tag/index', 'TagController@index');
    Route::get('tag/add', 'TagController@add');
    Route::post('tag/add', 'TagController@add');
    Route::get('tag/edit/{id?}', 'TagController@edit');
    Route::post('tag/edit', 'TagController@edit');
    Route::get('tag/delete', 'TagController@delete');
    Route::get('tag/update_status', 'TagController@updateStatus');
    Route::get('tag/get_nav_level', 'TagController@getNavlevel');
    //文章管理
    Route::get('article/index', 'ArticleController@index');
    Route::get('article/add', 'ArticleController@add');
    Route::post('article/add', 'ArticleController@add');
    Route::get('article/edit/{id?}', 'ArticleController@edit');
    Route::post('article/edit', 'ArticleController@edit');
    Route::get('article/delete', 'ArticleController@delete');
    Route::get('article/update_attribute', 'ArticleController@updateAttribute');
    Route::get('article/stick', 'ArticleController@stick');
    Route::post('article/publish', 'ArticleController@publish');
    Route::get('article/publish', 'ArticleController@publish');
    Route::get('article/cancel_publish', 'ArticleController@cancelPublish');
    //前台模块管理
    Route::get('module/index', 'ContentModuleController@index');
    Route::post('module/add', 'ContentModuleController@add');

    Route::get('send_email', 'MailtestController@sendEmail');

});
