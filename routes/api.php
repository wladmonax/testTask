<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => 'Api',
    'prefix' => 'notifications'
], function ($router) {
    $router->get('/', 'NotificationController@index')
        ->name('notifications.index');
    $router->post('/', 'NotificationController@store')
        ->name('notifications.store');
    $router->delete('{id}', 'NotificationController@delete')
        ->name('notifications.delete');
});
