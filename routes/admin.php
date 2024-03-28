<?php

use App\AppPlugin\AppPuzzle\AppPuzzleController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\WordPressController;
use Illuminate\Support\Facades\Route;


Route::get('/',[DashboardController::class,'Dashboard'])->name('admin.Dashboard');
Route::get('/testpdf',[DashboardController::class,'testpdf'])->name('admin.testpdf');
Route::get('/adminTest/{model}',[DashboardController::class,'adminTest'])->name('admin.adminTest');

Route::get('/ImportPostsCategory',[WordPressController::class,'ImportPostsCategory'])->name('admin.ImportPostsCategory');
Route::get('/ImportPosts',[WordPressController::class,'ImportPosts'])->name('admin.ImportPosts');
Route::get('/syncBlogCategory',[WordPressController::class,'syncBlogCategory'])->name('admin.syncBlogCategory');
Route::get('/ImportTags',[WordPressController::class,'ImportTags'])->name('admin.ImportTags');
Route::get('/CountSlug',[WordPressController::class,'CountSlug'])->name('admin.CountSlug');
Route::get('/UpdateTags',[WordPressController::class,'UpdateTags'])->name('admin.UpdateTags');
Route::get('/CheckId',[WordPressController::class,'CheckId'])->name('admin.CheckId');
Route::get('/CheckUser',[WordPressController::class,'CheckUser'])->name('admin.CheckUser');

Route::get('/AppPuzzle/List',[AppPuzzleController::class,'IndexModel'])->name('AppPuzzle.IndexModel');
Route::get('/AppPuzzle/Info/{model}',[AppPuzzleController::class,'InfoModel'])->name('AppPuzzle.InfoModel');
Route::get('/AppPuzzle/Copy/{model}',[AppPuzzleController::class,'CopyModel'])->name('AppPuzzle.Export');
Route::get('/AppPuzzle/Remove/{model}',[AppPuzzleController::class,'RemoveModel'])->name('AppPuzzle.Remove');
Route::get('/AppPuzzle/Import/{model}',[AppPuzzleController::class,'ImportModel'])->name('AppPuzzle.Import');
