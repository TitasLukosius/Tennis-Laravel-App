<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('dash');
});

Auth::routes(['verify' => true]);

Route::get('/dash', 'Admin\HomeController@index')->name('home');
Route::get('/info', 'Admin\infoController@index')->name('info');
Route::get('/home', 'Admin\DashController@index')->name('dash');
Route::get('/matches', 'MatchesController@index')->name('matches');
Route::get('/test-list', 'Admin\ListController@index')->name('test');
Route::get('/users-info/{users_info}/sendInvitation', 'UsersInformationController@sendInvitation')->name('users-info.sendInvitation');
Route::get('/invitations/{invitation}/acceptInvitation', 'InvitationController@acceptInvitation')->name('invitations.acceptInvitation');
Route::get('/invitations/{invitation}/declineInvitation', 'InvitationController@declineInvitation')->name('invitations.declineInvitation');
Route::get('/users-info/{users_info}/sendInvitation', 'UsersInformationController@sendInvitation')->name('users-info.sendInvitation');
Route::post('/users-info/filterPlayers', 'UsersInformationController@filterPlayers')->name('users-info.filterPlayers');
Route::resource('achievements', 'AchievementController');
Route::resource('user-info', 'UserInfoController');
Route::resource('users-info', 'UsersInformationController');
Route::resource('invitations', 'InvitationController');

