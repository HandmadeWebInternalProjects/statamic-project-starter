<?php

namespace App\Http\Controllers;

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

        $params = request()->except(['id', 'src', 'path']);
        $params['src'] = $path;

        $glideUrl = Statamic::tag('glide')->params($params)->fetch();

        return redirect($glideUrl, 302);
    }
}
