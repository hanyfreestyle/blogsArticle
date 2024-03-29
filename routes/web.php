<?php

use App\Http\Controllers\RouteNotFoundController;
use App\Http\Controllers\web\MainPagesViewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
Auth::viaRemember();
//Auth::logoutOtherDevices('password');

Route::group(['prefix' => LaravelLocalization::setLocale()], function(){
    Route::get('/under-construction', [MainPagesViewController::class, 'UnderConstruction'])->name('UnderConstruction');
});




Route::group(['middleware' => ['UnderConstruction','MinifyHtml']], function() {
    Route::group(['prefix' => LaravelLocalization::setLocale()], function(){
        Route::get('/', [MainPagesViewController::class, 'index'])->name('page_index');
        Route::get('/categories', [MainPagesViewController::class, 'categories'])->name('categories_list');
        Route::get('/category/{slug}', [MainPagesViewController::class, 'CategoryView'])->name('CategoryView');
        Route::get('/tag/{slug}', [MainPagesViewController::class, 'TagView'])->name('TagView');
        Route::get('/author/{slug}', [MainPagesViewController::class, 'AuthorView'])->name('AuthorView');


        Route::get('{slug}{extension}', [MainPagesViewController::class, 'BlogView'])
            ->name('blog_view')->where('slug', '(.*)')->where('extension', '(?:.html)?');



    });
});

Route::fallback(RouteNotFoundController::class);

