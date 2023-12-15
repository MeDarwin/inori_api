<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('thumbnail/{path}', function ($path) {
    $filename = $path;
    $file = Storage::get('thumbnail/' . $filename);
    $type = Storage::mimeType('thumbnail/' . $filename);

    if (!Storage::fileExists('thumbnail/' . $path)) {
        abort(404);
    }
    
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});