<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Statamic\Facades\Glide;
use Statamic\Http\Controllers\GlideController;
use Statamic\Statamic;

class GliderController extends GlideController
{
    /**
     * Generate a manipulated image by a path.
     *
     * @param string $path
     *
     * @return array
     */
    public function generateByPath($path)
    {
        // Convert :: in url to /
        $path = Str::replaceFirst('::', '/', $path);

        // Convert first / in url back to :: as we will base the ID from that.
        $path = Str::replaceFirst('/', '::', $path);

        $params = request()->except(['src', 'id', 'path']);

        $glideUrl = Glide::cacheStore()->rememberForever('asset::'.$path.'::'.md5(json_encode($params)), function () use ($path, $params) {
            return Statamic::tag('glide')->params(array_merge(['src' => $path], $params))->fetch();
        });

        if ($glideUrl) {
            $glideUrl = Str::startsWith($glideUrl, Glide::url()) ? $glideUrl : Glide::url().'/'.$glideUrl;
        }

        if (Str::startsWith($glideUrl, Glide::url())) {
            return redirect($glideUrl, 302);
        }

        return abort(401);
    }
}
