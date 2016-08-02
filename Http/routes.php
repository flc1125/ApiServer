<?php

// API 相关
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function(){
    Route::any('router', 'RouterController@index');  // API 入口
});