<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/portfolio', [PortfolioController::class, 'index']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('portfolio.admin');

Route::middleware('portfolio.admin')->group(function () {
	Route::put('/portfolio/hero', [PortfolioController::class, 'updateHero']);
	Route::put('/portfolio/about', [PortfolioController::class, 'updateAbout']);
	Route::put('/portfolio/contact', [PortfolioController::class, 'updateContact']);

	Route::post('/portfolio/projects', [ProjectController::class, 'store']);
	Route::put('/portfolio/projects/{project}', [ProjectController::class, 'update']);
	Route::delete('/portfolio/projects/{project}', [ProjectController::class, 'destroy']);

	Route::post('/portfolio/skills', [SkillController::class, 'store']);
	Route::put('/portfolio/skills/{skill}', [SkillController::class, 'update']);
	Route::delete('/portfolio/skills/{skill}', [SkillController::class, 'destroy']);
});