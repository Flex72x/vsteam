<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\TaskController;

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

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/news/{slug}', [HomeController::class, 'show_news'])->name('news.show');
Route::get('/group/{slug}', [HomeController::class, 'show_group'])->name('group.show');
Route::get('/group/{groupSlug}/discipline/{disciplineSlug}/{typeSlug?}', [HomeController::class, 'show_tasks'])->name('task.index');

Route::group(['prefix' => 'apanel'], function() {

    // МАРШРУТЫ ГОСТЯ

    Route::group(['middleware' => 'guest'], function() {
        Route::get('/login', [UserController::class, 'loginGet'])->name('user.login-get');
        Route::post('/login', [UserController::class, 'loginPost'])->name('user.login-post');
    });

    // МАРШРУТЫ АВТОРИЗИРОВАННОГО ПОЛЬЗОВАТЕЛЯ

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/', [HomeController::class, 'index_admin'])->name('admin.index');
        Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

        // Группы

        Route::get('/group', [GroupController::class, 'index'])->name('admin.group.index');
        Route::post('/groupStore', [GroupController::class, 'store'])->name('admin.group.store');
        Route::post('/getGroups', [GroupController::class, 'getGroups'])->name('admin.group.get_groups');
        Route::post('/editGroup', [GroupController::class, 'edit'])->name('admin.group.edit');
        Route::post('/updateGroup', [GroupController::class, 'update'])->name('admin.group.update');
        Route::post('/deleteGroup', [GroupController::class, 'delete'])->name('admin.group.delete');

        // Новости

        Route::get('/news', [NewsController::class, 'index'])->name('admin.news.index');
        Route::post('/newsStore', [NewsController::class, 'store'])->name('admin.news.store');
        Route::post('/getNews', [NewsController::class, 'getNews'])->name('admin.news.get_news');
        Route::post('/deleteNews', [NewsController::class, 'delete'])->name('admin.news.delete');
        Route::post('/editNews', [NewsController::class, 'edit'])->name('admin.news.edit');
        Route::post('/updateNews', [NewsController::class, 'update'])->name('admin.news.update');

        // Дисциплины

        Route::get('/discipline', [DisciplineController::class, 'index'])->name('admin.discipline.index');
        Route::post('/disciplineStore', [DisciplineController::class, 'store'])->name('admin.discipline.store');
        Route::post('/getDisciplines', [DisciplineController::class, 'getDisciplines'])->name('admin.discipline.get_disciplines');
        Route::post('/deleteDiscipline', [DisciplineController::class, 'delete'])->name('admin.discipline.delete');
        Route::post('/editDiscipline', [DisciplineController::class, 'edit'])->name('admin.discipline.edit');
        Route::post('/updateDiscipline', [DisciplineController::class, 'update'])->name('admin.discipline.update');

        Route::get('/task', [TaskController::class, 'index'])->name('admin.task.index');
        Route::post('/taskStore', [TaskController::class, 'store'])->name('admin.task.store');
        Route::post('/getTasks', [TaskController::class, 'getTasks'])->name('admin.task.get_tasks');
        Route::post('/deleteTask', [TaskController::class, 'delete'])->name('admin.task.delete');
        Route::post('/editTask', [TaskController::class, 'edit'])->name('admin.task.edit');
        Route::post('/updateTask', [TaskController::class, 'update'])->name('admin.task.update');
    });
});