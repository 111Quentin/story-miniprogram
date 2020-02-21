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


// StoryCategory
Route::get('api/StoryCategory/all','api/StoryCat/getAllCategories');
Route::get('api/StoryCategory','api/StoryCat/getCategory');

//Story 
Route::get('api/HotStory/paginate', 'api/Story/getHotStory');
Route::get('api/TopStory/paginate', 'api/Story/getTopStory');
Route::get('api/Story/by_category/paginate','api/Story/getByCategory');
Route::get('api/Story/getprenext','api/Story/getPreNext');
Route::get('api/Story','api/Story/getOne');




//Token
Route::post('api/token/user', 'api/Token/getToken');
Route::post('api/token/app', 'api/Token/getAppToken');
Route::post('api/token/verify', 'api/Token/verifyToken');



// UserInfo
Route::get('api/UserInfo/create', 'api/UserInfo/createUser');

// StoryRecord
Route::get('api/StoryRecord/create', 'api/StoryRecord/createRecord');
Route::get('api/StoryRecord/select', 'api/StoryRecord/select');






// Route::get('think', function () {
//     return 'hello,ThinkPHP5!';
// });

// Route::get('hello/:name', 'index/hello');

// return [

// ];
