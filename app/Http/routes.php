<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


//管理员登陆
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 管理员注册
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//重置密码

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


//上传
Route::post('upload', 'UploadController@store');

//后台  , 'middleware' => 'auth'
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'IndexController@index');


    //商品品牌，除去show方法
    Route::group(['prefix' => 'brand'], function () {
        Route::get('/search', 'BrandController@search');
        Route::patch('/sort', 'BrandController@sort');
    });
    Route::resource('brand', 'BrandController', ['except' => ['show']]);

    //商品类型
    Route::resource('type', 'TypeController', ['except' => ['show']]);

    //商品属性，需要加入商品类型的id
    Route::group(['prefix' => 'type/{type_id}'], function () {
        Route:
        delete('del_all', [
            'as' => 'admin.type.{type_id}.attribute.del_all', 'uses' => 'AttributeController@del_all'
        ]);
        Route::resource('attribute', 'AttributeController', ['except' => ['show']]);
    });

    //栏目管理
    Route::resource('category', 'CategoryController', ['except' => ['show']]);


    //商品管理
    Route::group(['prefix' => 'good'], function () {
        Route::get('/trash', 'GoodController@trash');
        Route::get('/{good}/restore', [
            'as' => 'admin.good.restore', 'uses' => 'GoodController@restore'
        ]);
        Route::delete('/{good}/force_destroy', [
            'as' => 'admin.good.force_destroy', 'uses' => 'GoodController@force_destroy'
        ]);
    });
    Route::resource('good', 'GoodController');

    Route::resource('comment', 'CommentController');

});
