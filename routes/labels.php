<?php

use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth', 'prefix' => 'labels'], function () {
    Route::get('/', [LabelController::class, 'index'])->name('labels.getLabels');
    Route::get('/{label}', [LabelController::class, 'show'])->name('labels.getLabel');
});
