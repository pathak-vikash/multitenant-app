<?php
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;

use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

use Hyn\Tenancy\Environment;
//use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});


# domain based routes
Route::pattern('domain', '(vcap.me|localtest.me|beweb.com|yoogle.com|ortkut.com|feacebook.com)');

Route::group(['domain' => '{domain}'], function() {

    Route::get('posts', "PostsController@index");
    Route::get('posts/create', "PostsController@create");
});
/* 
Route::domain("{account}.me")->group(function () {
    # get posts
    Route::get('posts', "PostsController@index");
    Route::get('posts/create', "PostsController@create");
});

Route::domain("{account}.com")->group(function () {
    # get posts
    Route::get('posts', "PostsController@index");
    Route::get('posts/create', "PostsController@create");
}); */


# connect domain
Route::get("{site}/connect", "SitesController@connect");

# switch tenant
Route::get('{site}/switch', "SitesController@switch");

# Tenant Route
Route::middleware('tenancy')->prefix("{site}")->group(function(){

    # crate post
    Route::get('posts/create', "PostsController@create");

    # get posts
    Route::get('posts', "PostsController@index");
});



