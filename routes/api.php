<?php

use App\Subject;
use App\Tutorial;
use App\User;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;

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

//Users

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::get('subjects', 'SubjectController@index');
Route::get('subjects/{subject}', 'SubjectController@show');

Route::get('comments', 'CommentController@index');


Route::group(['middleware' => ['jwt.verify']], function() {

    //usuario
    Route::get('users', 'UserController@index');
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('users/{user}', 'UserController@show');
    Route::put('users/{user}', 'UserController@update');
    Route::delete('users/{user}', 'UserController@delete');

    //Tutorias
    Route::get('tutorials', 'TutorialController@index');
    Route::get('tutorials/{tutorial}', 'TutorialController@show');
    Route::post('tutorials', 'TutorialController@store');
    Route::put('tutorials/{tutorial}', 'TutorialController@update');
    Route::delete('tutorials/{tutorial}', 'TutorialController@delete');
    Route::get('tutorials/{tutorial}/image', 'TutorialController@image');

    //Comments
    Route::get('comments/{comment}', 'CommentController@show');
    Route::post('comments', 'CommentController@store');
    Route::put('comments/{comment}', 'CommentController@update');
    Route::delete('comments/{comment}', 'CommentController@delete');

    //Subjects
    Route::get('subjects/{subject}', 'SubjectController@show');
    Route::post('subjects', 'SubjectController@store');
    Route::put('subjects/{subject}', 'SubjectController@update');
    Route::delete('subjects/{subject}', 'SubjectController@delete');

    //Turoria teacher
    Route::post('tutorials/{tutorial}/teachers', 'TutorialController@accept');

});



