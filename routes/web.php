<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::get(
    'c/{slug}',
    [\App\Http\Controllers\CommunityController::class, 'show']
)
    ->name('communities.show');

Route::get(
    'p/{postId}',
    [\App\Http\Controllers\CommunityPostController::class, 'show']
)
    ->name('communities.posts.show');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('communities', \App\Http\Controllers\CommunityController::class)
        ->except('show');
    Route::resource('communities.posts', \App\Http\Controllers\CommunityPostController::class)
        ->except('show');
    Route::resource('posts.comments', \App\Http\Controllers\PostCommentController::class);
    Route::post('posts/{post_id}/report', [\App\Http\Controllers\CommunityPostController::class, 'report'])->name('post.report');
});
