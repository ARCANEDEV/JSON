<?php

use Arcanedev\Json\Json;

if ( ! function_exists('json')) {

    /**
     * Get the JSON instance.
     *
     * @param  string|null  $path
     *
     * @return Arcanedev\Json\Json
     */
    function json($path = null) {
        return Json::make($path);
    }
}
