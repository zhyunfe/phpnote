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

Route::any('/','IndexController@index');
Route::any('/phpinfo','IndexController@getPhpinfo');
Route::any('/yar','IndexController@yar');

Route::any('/test','IndexController@test');
Route::any('excel', 'ToolsController@excelExample');
Route::any('haxi', 'ToolsController@haxi');
Route::any('dts/canbuy', 'TestController@dts_canbuy');
Route::any('boot', 'BootController@index');
Route::any('boot/file', 'BootController@fileHandle');
Route::any('nginx', 'NginxController@index');
Route::any('nginx/fastcgi', 'NginxController@fastcgi');
Route::any('nginx/location', 'NginxController@location');
Route::any('nginx/xdebug', 'NginxController@xdebug');
Route::any('source', 'SourceCodeController@index');
Route::any('source/memoey', 'SourceCodeController@memoey');
Route::any('file/index', 'FileSystemController@index');
Route::any('file/upload', 'IndexController@upload');
Route::any('office', 'OfficeController@index');
Route::any('office/create', 'OfficeController@create');
Route::any('office/setSheet', 'OfficeController@setSheet');
Route::any('office/getExcel', 'OfficeController@getExcel');

