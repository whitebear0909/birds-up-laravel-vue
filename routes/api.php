<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HuntersController;
use App\Http\Controllers\DogsController;
use App\Http\Controllers\HuntergroupController;

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

Route::group(['middleware' => 'api'], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/csv', [ExportController::class, 'exportCsvFile']);
    Route::get('/pdf', [ExportController::class, 'exportPdfFile']);
    Route::get('/userProfile', [UserController::class, 'userProfile']);
    Route::get('/getDashboard', [UserController::class, 'getDashboard']); 
    Route::get('/getCourseMetrics', [UserController::class, 'getCourseMetrics']);
    Route::get('/getDogPerformance', [UserController::class, 'getDogPerformance']);
    Route::get('/getMapCovey', [UserController::class, 'getMapCovey']);

    Route::resources([
        'propertynames' => PropertyController::class,
        'coursenames' => CoursesController::class,
        'huntergroup' => HuntergroupController::class,
        'hunternames' => HuntersController::class,
        'dognames' => DogsController::class,
    ]);

});
