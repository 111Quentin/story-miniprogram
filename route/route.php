<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------





//Banner
Route::get('api/banner', 'api/Banner/getBanner');


//Story 
Route::get('api/Story/paginate', 'api/Story/getHotStory');

//Token
// Route::post('api/token/user', 'api/Token/getToken');
// Route::post('api/token/app', 'api/Token/getAppToken');
// Route::post('api/token/verify', 'api/Token/verifyToken');








// Route::get('think', function () {
//     return 'hello,ThinkPHP5!';
// });

// Route::get('hello/:name', 'index/hello');

// return [

// ];
