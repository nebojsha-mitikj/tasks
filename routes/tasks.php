<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/today', [TaskController::class, 'today'])->name('tasks.today');
    Route::get('/upcoming', [TaskController::class, 'upcoming'])->name('tasks.upcoming');
    Route::get('/history', [TaskController::class, 'history'])->name('tasks.history');
    Route::put('/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    Route::resource('tasks', TaskController::class)->only(['destroy', 'update', 'store'])
        ->middlewareFor('update', 'can:update,task')
        ->middlewareFor('destroy', 'can:delete,task');
});
