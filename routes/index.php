<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
|
*/

Route::group(['namespace' => 'Index'], function () {
    //前台首页
    Route::get('index/index', 'IndexController@index');
    //文章显示
    Route::get('info/index/{id}', 'InfoController@index');
    //文章列表
    Route::get('list/index', 'ListController@index');
});
