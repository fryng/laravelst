<?php
/**
 * Created by PhpStorm.
 * User: zhy
 * Date: 2017-02-09
 * Time: 21:33
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    public function getBasetest(Request $request)
    {
        $input = $request->input('test');
        echo $input;
    }

    public function getUrl(Request $request)
    {
        if(!$request->is('request/*')){
            abort(404);
        }
        $uri = $request->path();
        $url = $request->url();

        echo $uri;
        echo '</br>';
        echo $url;
    }

    public function getInputData(Request $request){

        $allData = $request->all();
        $onlyData = $request->only('name','hello');
        $exceptData = $request->except('hello');

        echo '<pre>';
        print_r($allData);
        print_r($onlyData);
        print_r($exceptData);
    }

    public function getLastRequest(Request $request){
//        return $request->flash();
        return redirect('/request/current-request')->withInput();
    }

    public function getCurrentRequest(Request $request){
        $lastRequestData = $request->old();
        echo '<pre>';
        print_r($lastRequestData);
    }

    public function getCookie(Request $request){
        $cookies = $request->cookie();
        dd($cookies);
    }

    public function getAddCookie(Request $request)
    {
        $response = new Response();

        //第一个参数是cookie名，第二个参数是cookie值，第三个参数是有效期（分钟）
        $response->withCookie(cookie('website','www.laravel.app',1));

        $response->withCookie(cookie()->forever('name','value'));

        return $response;
    }

    public function getMyCookie(Request $request)
    {
        $cookie = $request->cookie('website');
        echo $cookie;
    }

    //文件上传表单
    public function getFileupload()
    {
        $postUrl = '/request/fileupload';
        $csrf_field = csrf_field();
        $html = <<<CREATE
            <form action="$postUrl" method="POST" enctype="multipart/form-data">
            $csrf_field
            <input type="file" name="file"><br/><br/>
            <input type="submit" value="提交"/>
            </form>
CREATE;
        return $html;
    }

//文件上传处理
    public function postFileupload(Request $request){
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        $destPath = realpath(public_path('images'));

        if(!file_exists($destPath))
            mkdir($destPath,0755,true);
        $filename = $file->getClientOriginalName();
        if(!$file->move($destPath,$filename)){
            exit('保存文件失败！');
        }
        exit('文件上传成功！');
    }
}