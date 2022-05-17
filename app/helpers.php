<?php

use Statamic\Assets\Asset;

if (!function_exists('glide_url')) {
    function glide_url(string|Asset $asset, array $params = [])
    {
        if ($asset instanceof Asset) {
            $asset = $asset->id();
        }

        unset($params['src']);
        unset($params['id']);
        unset($params['path']);

        $params['src'] = $asset;

        return tag('glide', $params);
    }
}

if (!function_exists('zipper_url')) {
    function zipper_url(string $filename, array $files)
    {
        if (!class_exists(\Aerni\Zipper\ZipperController::class)) {
            return null;
        }

        $files = collect($files)->map(function ($item) {
            if ($item instanceof \Statamic\Assets\Asset) {
                return $item->id();
            }

            return $item;
        });

        return action([\Aerni\Zipper\ZipperController::class, 'create'], [
            'filename' => $filename,
            'files' => $files->toArray(),
        ]);
    }
}
