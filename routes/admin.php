<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
|
*/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    //后台首页
    Route::get('index', 'IndexController@index');
    //菜单管理
    Route::get('menu/index', 'MenuController@index');
    Route::get('menu/add', 'MenuController@add');
    Route::post('menu/add', 'MenuController@add');
    Route::get('menu/edit/id/{id?}', 'MenuController@edit');
    Route::post('menu/edit', 'MenuController@edit');
    Route::get('menu/delete', 'MenuController@delete');
    Route::get('menu/update_status', 'MenuController@updateStatus');
    Route::get('menu/get_menu_level', 'MenuController@getMenulevel');
    //用户管理
    Route::get('user/index', 'UserController@index');
    Route::get('user/add', 'UserController@add');
    Route::post('user/add', 'UserController@add');
    Route::get('user/edit/id/{id?}', 'UserController@edit');
    Route::post('user/edit', 'UserController@edit');
    Route::get('user/upload', 'UserController@upload');
    Route::get('user/delete', 'UserController@delete');
    Route::get('user/update_status', 'UserController@updateStatus');
    //角色管理
    Route::get('role/index', 'RoleController@index');
    Route::get('role/add', 'RoleController@add');
    Route::post('role/add', 'RoleController@add');
    Route::get('role/edit/id/{id?}', 'RoleController@edit');
    Route::post('role/edit', 'RoleController@edit');
    Route::get('role/delete', 'RoleController@delete');
    Route::get('role/update_status', 'RoleController@updateStatus');
    Route::get('role/authorize', 'RoleController@authorizeRole');
    //权限规则管理
    Route::get('rule/index', 'RuleController@index');
    Route::post('rule/index', 'RuleController@index');
    Route::get('rule/add', 'RuleController@add');
    Route::post('rule/add', 'RuleController@add');
    Route::get('rule/edit/id/{id?}', 'RuleController@edit');
    Route::post('rule/edit', 'RuleController@edit');
    Route::get('rule/delete', 'RuleController@delete');
    Route::get('rule/update_status', 'RuleController@updateStatus');
    //登录注销
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout');
    Route::get('auth/check_account', 'AuthController@checkAccount');



    Route::get('send_email', 'MailtestController@sendEmail');

});
