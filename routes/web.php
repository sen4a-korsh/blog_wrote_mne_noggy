<?php


use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikedPostController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
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

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::get('/', [MainController::class, 'index'])->name('main.index');

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'index'])->name('post.index');
    Route::get('/{post}', [PostController::class, 'show'])->name('post.show');

    Route::group(['prefix' => '{post}/comment'], function (){
        Route::post('/', [CommentController::class, 'store'])->name('post.comment.store');
    });

    Route::group(['prefix' => '{post}/like'], function (){
        Route::post('/', [LikedPostController::class, 'store'])->name('post.like.store');
    });
});

Route::group(['prefix' => 'categories'], function (){
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');

    Route::group(['prefix' => '{category}/posts'], function (){
        Route::get('/', [PostController::class, 'indexCategoryPosts'])->name('category.post.index');
    });
});

Route::group(['prefix' => 'personal', 'middleware' => ['auth', 'verified']], function (){

    Route::get('/', [PersonalController::class, 'index'])->name('personal.main.index');

    Route::group(['prefix' => 'liked-post'], function () {
        Route::get('/', [LikedPostController::class, 'index'])->name('personal.liked-post.index');
        Route::delete('/{post}', [LikedPostController::class, 'destroy'])->name('personal.liked-post.delete');
    });
    Route::group(['prefix' => 'comments'], function () {
        Route::get('/', [CommentController::class, 'index'])->name('personal.comment.index');
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('personal.comment.edit');
        Route::patch('/{comment}', [CommentController::class, 'update'])->name('personal.comment.update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('personal.comment.delete');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin', 'verified']], function (){

    Route::get('/', [AdminMainController::class, 'index'])->name('admin.main.index');

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.category.index');
        Route::post('/', [AdminCategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/{category}', [AdminCategoryController::class, 'show'])->name('admin.category.show');
        Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
        Route::patch('/{category}', [AdminCategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.category.delete');
    });

    Route::group(['prefix' => 'tags'], function () {
        Route::get('/', [AdminTagController::class, 'index'])->name('admin.tag.index');
        Route::post('/', [AdminTagController::class, 'store'])->name('admin.tag.store');
        Route::get('/{tag}', [AdminTagController::class, 'show'])->name('admin.tag.show');
        Route::get('/{tag}/edit', [AdminTagController::class, 'edit'])->name('admin.tag.edit');
        Route::patch('/{tag}', [AdminTagController::class, 'update'])->name('admin.tag.update');
        Route::delete('/{tag}', [AdminTagController::class, 'destroy'])->name('admin.tag.delete');
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('admin.post.index');
        Route::get('/create', [AdminPostController::class, 'create'])->name('admin.post.create');
        Route::post('/', [AdminPostController::class, 'store'])->name('admin.post.store');
        Route::get('/{post}', [AdminPostController::class, 'show'])->name('admin.post.show');
        Route::get('/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.post.edit');
        Route::patch('/{post}', [AdminPostController::class, 'update'])->name('admin.post.update');
        Route::delete('/{post}', [AdminPostController::class, 'destroy'])->name('admin.post.delete');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.user.index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin.user.create');
        Route::post('/', [AdminUserController::class, 'store'])->name('admin.user.store');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('admin.user.show');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::patch('/{user}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('admin.user.delete');
    });
});
