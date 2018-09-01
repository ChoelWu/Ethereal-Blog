<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//网站入口
Route::get('/', 'Admin\AuthController@index');
//登录注销
Route::post('admin/auth/login', 'Admin\AuthController@login');
Route::any('admin/auth/logout', 'Admin\AuthController@logout');
Route::get('admin/auth/check_account', 'Admin\AuthController@checkAccount');
//无权限提示
Route::get('admin/auth/forbidden', 'Admin\AuthController@forbidden')->middleware('menuTree');