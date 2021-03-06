<?php

namespace DoubleThreeDigital\Blaze\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ConfigController
{
    public function index(Request $request)
    {
        return [
            'config' => Config::get('blaze'),
        ];
    }
}
