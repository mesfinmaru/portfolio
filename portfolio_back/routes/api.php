<?php

use App\Http\Controllers\ProjectApiController;
use Illuminate\Support\Facades\Route;

Route::get('/projects', [ProjectApiController::class, 'index']);