<?php
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 7/31/2017
 * Time: 6:14 PM
 */

namespace App\Classes;

class AssetsVersioning
{
    public function __construct()
    {
        $contents = file_get_contents(base_path() . '/../public_html/css/release/rev-manifest.json');

        session(['static_asset_versioning' => json_decode($contents)]);
    }
}
