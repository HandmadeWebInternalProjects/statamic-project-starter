<?php

use App\Http\Controllers\BasicSearchController;
use App\Http\Controllers\GliderController;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Glide;
use Statamic\Facades\Site;
use Statamic\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/search', [BasicSearchController::class, 'index'])->name('basic-search');

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);

/*
* Glide
* On-the-fly URL-based image transforms.
*/
if (!is_bool(config('statamic.assets.image_manipulation.cache'))) {
    Site::all()->map(function ($site) {
        return URL::makeRelative($site->url());
    })->unique()->each(function ($sitePrefix) {
        Route::group(['prefix' => $sitePrefix.'/'.Glide::route()], function () {
            // Route::get('/asset/{container}/{path?}', [GliderController::class, 'generateByAsset'])->where('path', '.*');
            // Route::get('/http/{url}/{filename?}', [GliderController::class, 'generateByUrl']);
            Route::get('{path}', [GliderController::class, 'generateByPath'])->where('path', '.*');
        });
    });
}
