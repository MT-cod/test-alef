<?php

use App\Http\Controllers\LectureController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyClassController;
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
    StudentController::class,
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);

Route::resource(
    'study_classes',
    StudyClassController::class,
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
Route::get('study_classes/plan/{study_class}', [StudyClassController::class, 'getPlan']);
Route::post('study_classes/plan/{study_class}', [StudyClassController::class, 'setPlan']);

Route::resource(
    'lectures',
    LectureController::class,
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
