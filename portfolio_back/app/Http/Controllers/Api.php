<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portfolio API Routes
|--------------------------------------------------------------------------
|
| Public:
|   GET  /api/portfolio        → full portfolio data (Vue reads this)
|
| Auth (Sanctum token required):
|   POST /api/auth/login       → get token
|   POST /api/auth/logout      → revoke token
|   PUT  /api/portfolio/hero
|   PUT  /api/portfolio/about
|   PUT  /api/portfolio/contact
|   POST /api/portfolio/projects
|   PUT  /api/portfolio/projects/{project}
|   DELETE /api/portfolio/projects/{project}
|   POST /api/portfolio/skills
|   PUT  /api/portfolio/skills/{skill}
|   DELETE /api/portfolio/skills/{skill}
|
*/

// ── Public ────────────────────────────────────────────────────────────────────
Route::get('/portfolio', [PortfolioController::class, 'index']);

// ── Auth ──────────────────────────────────────────────────────────────────────
Route::post('/auth/login',  [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('portfolio.admin');

// ── Protected admin routes ────────────────────────────────────────────────────
Route::middleware('portfolio.admin')->group(function () {

    // Sections
    Route::put('/portfolio/hero',    [PortfolioController::class, 'updateHero']);
    Route::put('/portfolio/about',   [PortfolioController::class, 'updateAbout']);
    Route::put('/portfolio/contact', [PortfolioController::class, 'updateContact']);

    // Projects
    Route::post  ('/portfolio/projects',         [ProjectController::class, 'store']);
    Route::put   ('/portfolio/projects/{project}',[ProjectController::class, 'update']);
    Route::delete('/portfolio/projects/{project}',[ProjectController::class, 'destroy']);

    // Skills
    Route::post  ('/portfolio/skills',        [SkillController::class, 'store']);
    Route::put   ('/portfolio/skills/{skill}',[SkillController::class, 'update']);
    Route::delete('/portfolio/skills/{skill}',[SkillController::class, 'destroy']);
});