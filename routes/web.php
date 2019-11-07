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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'ChatkitController@index');
Route::post('/', 'ChatkitController@join');
Route::get('chat', 'ChatkitController@chat')->name('chat');
Route::post('logout', 'ChatkitController@logout')->name('logout');

Route::post('createroom','ChatkitController@Room');

Route::get('newchat','ChatController@createChatroom');

Route::get('room','ChatController@getroom');
Route::get('userroom','ChatController@getusersroom');

Route::get('chatroom/{roomId}/{userId}','ChatController@createChatroom');
Route::get('chatroom/{roomId}','ChatController@joinChatroom');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('privatechat','OneToOneController@createChatroom')->name('privatechat');
// Route::post('privatechat','OneToOneController@Chat')->name('privatechat');
Route::get('users','OneToOneController@users');
Route::post('groupchat','ChatController@groupChat')->name('groupchat');
Route::post('creategroup','ChatController@createGroupchat')->name('creategroupchat');