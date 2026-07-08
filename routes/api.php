<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecommendationController;

Route::get('/v1/recommend-advisor', [RecommendationController::class, 'getRecommendations']);
