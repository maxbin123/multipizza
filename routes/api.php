<?php

use App\Http\Controllers\LoginController;
use App\Http\Resources\BranchCollection;
use App\Http\Resources\BranchResource;
use App\Http\Resources\CategoryResource;
use App\Models\Branch;
use App\Models\Category;
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


Route::group(['prefix' => 'v1'], function () {
    Route::post('otp', [LoginController::class, 'getOtp']);
    Route::post('login', [LoginController::class, 'loginWithOtp']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    Route::get('branch', function () {
        return new BranchCollection(Branch::all());
    });
    Route::get('branch/{branch}', function (Branch $branch) {
        return new BranchResource($branch);
    });

});
