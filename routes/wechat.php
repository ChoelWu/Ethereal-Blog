<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'wechat', 'namespace' => 'WeChat'], function () {
    Route::any('index', 'WeChatTestController@index');
    Route::any('reset_access_token_file', 'WeChatTestController@resetAccessTokenFile');
    //菜单管理
    Route::any('set_menu', 'WeChatTestController@setMenuInstance');
    Route::any('get_menu', 'WeChatTestController@getMenuInstance');
    Route::any('delete_menu', 'WeChatTestController@deleteMenuInstance');
    //用户管理
    Route::any('create_tags', 'WeChatTestController@createTagsInstance');
    Route::any('get_tags', 'WeChatTestController@getTagsInstance');
    Route::any('edit_tags', 'WeChatTestController@editTagsInstance');
    Route::any('delete_tags', 'WeChatTestController@deleteTagsInstance');
    Route::any('get_user_by_tag', 'WeChatTestController@getUserByTagInstance');
    Route::any('add_tags_to_user', 'WeChatTestController@addTagsToUserInstance');
    Route::any('cancel_tags_to_user', 'WeChatTestController@cancelTagsToUserInstance');
    Route::any('get_user_tags', 'WeChatTestController@getUserTagsInstance');
    Route::any('set_remark', 'WeChatTestController@setRemarkInstance');
    Route::any('get_user_info', 'WeChatTestController@getUserInfoInstance');
    Route::any('get_multi_user_info', 'WeChatTestController@getMultiUserInfoInstance');
    Route::any('get_user_list', 'WeChatTestController@getUserListInstance');
    Route::any('get_black_list', 'WeChatTestController@getBlackListInstance');
    Route::any('put_user_in_black_list', 'WeChatTestController@putUserInBlackListInstance');
    Route::any('remove_user_from_black_list', 'WeChatTestController@removeUserFromBlackListInstance');
    //账号管理
    Route::any('create_qr_code', 'WeChatTestController@createQrCodeInstance');
    Route::any('show_qr_code', 'WeChatTestController@showQrCodeInstance');
    Route::any('long_url_2_short', 'WeChatTestController@longUrlToShortInstance');
    //微信网页授权
    Route::any('test', 'WeChatTestController@test');
    Route::any('get_code', 'WeChatTestController@getCodeInstance');
    Route::any('get_access_token', 'WeChatTestController@getAccessTokenInstance');
    Route::any('refresh_token', 'WeChatTestController@refreshTokenInstance');
    Route::any('get_user_info_by_web_auth', 'WeChatTestController@getUserInfoByWebAuth');
    Route::any('check_access_token', 'WeChatTestController@checkAccessTokenInstance');
    //素材管理
    Route::any('add_temporary_material', 'WeChatTestController@addTemporaryMaterialInstance');
    Route::any('get_temporary_material', 'WeChatTestController@getTemporaryMaterialInstance');
    Route::any('add_permanent_material', 'WeChatTestController@addPermanentMaterialInstance');
    Route::any('add_permanent_news', 'WeChatTestController@addPermanentNewsInstance');
    Route::any('add_permanent_image', 'WeChatTestController@addPermanentImageInstance');
    Route::any('get_permanent_material', 'WeChatTestController@getPermanentMaterialInstance');
    //群发消息
    Route::any('mass_message', 'WeChatTestController@massMessageInstance');
    //发送模板消息
    Route::any('set_industry', 'WeChatTestController@setIndustryInstance');
    Route::any('get_industry', 'WeChatTestController@getIndustryInstance');
    Route::any('get_template_id', 'WeChatTestController@getTemplateIdInstance');
    Route::any('get_template_list', 'WeChatTestController@getTemplateListInstance');
    Route::any('delete_template', 'WeChatTestController@deleteTemplateInstance');
    Route::any('send_template_message_instance', 'WeChatTestController@sendTemplateMessageInstance');
});
