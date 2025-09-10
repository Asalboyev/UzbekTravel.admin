<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('locale')->group(function () {
    Route::get('/posts', [ApiController::class, 'get_posts']);
    Route::get('/posts/{slug}', [ApiController::class, 'show_post']);

    Route::get('/categories', [ApiController::class, 'get_categories']);
    Route::get('/categories/{slug}', [ApiController::class, 'show_categories']);
    Route::get('/categories/filter/{slug}', [ApiController::class, 'show_categor_product']);


    Route::get('/documents', [ApiController::class, 'get_documents']);
    Route::get('/documents/{slug}', [ApiController::class, 'show_documents']);
    Route::get('/documents/filter/{slug}', [ApiController::class, 'show_category_documents']);
    Route::get('/document/{slug}', [ApiController::class, 'show_document']);


    Route::get('/translations', [ApiController::class, 'translations']);
    Route::get('/partners', [ApiController::class, 'get_partners']);
    Route::get('/partners/{id}', [ApiController::class, 'show_partners']);

    Route::get('/file', [ApiController::class, 'get_file']);
    Route::get('/file/{id}', [ApiController::class, 'show_file']);

    Route::get('/file2', [ApiController::class, 'get_file2']);
    Route::get('/file2/{id}', [ApiController::class, 'show_file2']);

    Route::get('/file3', [ApiController::class, 'get_file3']);

    Route::get('/url', [ApiController::class, 'get_url']);

    Route::get('/works', [ApiController::class, 'get_catalogs']);
    Route::get('/works/{slug}', [ApiController::class, 'show_catalogs']);

    Route::get('/banners', [ApiController::class, 'get_banner']);
    Route::get('/langs', [ApiController::class, 'langs']);

    Route::get('siteinfo', [ApiController::class, 'getCompany']);
    Route::get('settings', [ApiController::class, 'settings']);
    Route::post('/contacts', [ApiController::class, 'store']);

});
