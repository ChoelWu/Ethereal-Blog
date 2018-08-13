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
    //登录注销
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout');
    Route::get('auth/check_account', 'AuthController@checkAccount');



    Route::get('send_email', 'MailtestController@sendEmail');

});
