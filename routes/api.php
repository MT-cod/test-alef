<?php

use App\Http\Controllers\StudentsController;
use App\Http\Controllers\StudyClassesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource(
    'students',
    StudentsController::class,
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
Route::resource(
    'study_classes',
    StudyClassesController::class,
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
Route::get('study_classes/plan/{study_class}', [StudyClassesController::class, 'getPlan']);
Route::post('study_classes/plan/{study_class}', [StudyClassesController::class, 'setPlan']);
