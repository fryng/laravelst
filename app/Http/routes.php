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
use Illuminate\Http\Response;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello',function (){
    return 'hello GET';
});

Route::get('/hello/laravelacademy{id}',['as'=>'academy',function($id){
    return 'Hello LaravelAcademy！'.$id;
}]);


Route::group(['as' => 'admin::'],function(){
    Route::get('/dashboard',['as'=>'dashboard',function (){
        return 'dashboard';
    }]);
});

Route::get('/testNamedRoute',function(){
    return route('admin::dashboard');
});

Route::group(['middleware' => 'test:male'],function (){
    Route::get('/update/laravelacademy',function (){

    });
    Route::get('/write/laravelacademy',function(){
        //使用Test中间件
    });
});

Route::get('/age/refuse',['as' => 'refuse',function (){
    return '未成年人禁止入内';
}]);

Route::group(['prefix' => 'laravelacademy/{version}'],function (){
    Route::get('/write',function ($version){
        return 'laravelacademy prefix write'.$version;
    });
});

Route::get('testCsrf',function (){
    $csrf_field = csrf_field();

    $html = <<<GET
        <form method="POST" action="/testCsrf">
            <input type="submit" value="Test"/>
        </form>
GET;
    return $html;
});

Route::post('testCsrf',function (){
    return 'success';
});

Route::resource('post','PostController');
Route::controller('request','RequestController');

Route::get('response',function (){
    $content = 'hello laravel';
    $status = 200;
    $value = 'text/html;charset=utf-8';
    return response()->view('hello',['message'=>'laravel'])->header('Content-Type',$value);
<<<<<<< HEAD
});

Route::get('testResponseRedirect',function (){
    return redirect()->action('PostController@show',1);
=======
>>>>>>> 3857b940b13210ba067e3e93a4e65fd9fcebe50e
});