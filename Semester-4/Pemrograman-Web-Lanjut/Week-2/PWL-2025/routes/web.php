<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

//--------------------------------Route Concept--------------------------------//
//Route::get() hanya digunakan untuk mendefinisikan route GET request secara manual.//

// Creating Hello Route 
/*Route::get('/hello', function () {
    return'Hello World';
});*/

Route::get('/world', function () {
    return'World';
});

Route::get('/', function () {
    return'Selamat Datang';
});

Route::get('/about', function () {
    return'Baskoro Seno Aji, 2341720063';
});

Route::get('/user/{name}', function ($name) {
    return'Nama Saya' .$name;
});

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return'Pos ke-' .$postId. " Komentar ke-:" .$commentId;
});

Route::get('/article/{id}', function ($articleId) {
    return'Halaman Artikel Dengan ID-' .$articleId;
});

/*Route::get('/user/{name?}', function ($name=null) {
    return'Nama Saya' .$name;
});*/

/*Route::get('/user/{name?}', function ($name='John') {
    return'Nama Saya' .$name;
});*/

Route::get('/user/profile', function () {
    //
})->name('profile');


//--------------------------------Controller Concept--------------------------------//
//----Setelah Class, diisi dengan method atau function yang berada di Controller----//

//Hello Controller -- Welcome Controller in App Folder 
Route::get('/hello', [WelcomeController::class,'hello']);

//Index Controller -- Page Controller in App Folder 
Route::get('/index', [HomeController::class,'index']);

//About Controller -- Page Controller in App Folder 
Route::get('/about', [AboutController::class,'about']);

//Article Controller -- Page Controller in App Folder 
Route::get('/article/{id}', [ArticleController::class,'article']);


//--------------------------------Resources Controller--------------------------------//
//-----------Implementing Eloquent Model for CRUD by using Resource Controller--------//
//Route::resource() digunakan untuk secara otomatis menghasilkan 7 route yang berhubungan dengan operasi CRUD pada suatu model.// 

//Base Resource Route that consists all the CRUD Feature -- PhotoController in App Folder 
Route::resource('photos', PhotoController::class);

//Resource Route with a requirements of only showing the index and show by using "only statement"
Route::resource('photos', PhotoController::class)-> only ([
    'index', 'show'
]);

//Resource Route with a requirements of only showing the index and show by using "only statement"
Route::resource('photos', PhotoController::class)-> except ([
    'create', 'store', 'update', 'destroy'
]);

//--------------------------------Creating View --------------------------------//

// Creating the route for Blade.php by referring to the view name where in here is hello
/*Route::get('/greeting', function(){
    return view('hello', ['name' => 'Baskoro Seno Aji']);
});*/

// Creating the route for Blade.php by referring to the view name and blade name, 
//also we need to state the folder where the blade consist in, where right here is in the blog
Route::get('/greeting', function(){
    return view('blog.hello', ['name' => 'Baskoro Seno Aji']);
});

//Greeting Controller where this controller shown the view function | Routing - Controller - View -- Welcome Controller in App Folder 
Route::get('/greeting', [WelcomeController::class,'greeting']);