<?php

use App\Http\Controllers\RecurringTaskTemplateController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth'], function () {
    Route::get('/recurring', [RecurringTaskTemplateController::class, 'recurring'])
        ->name('recurring.recurringTemplates');
});
