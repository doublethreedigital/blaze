<?php

namespace DoubleThreeDigital\Blaze\Http\Controllers;

use DoubleThreeDigital\Blaze\Http\Requests\BlazeRequest;
use DoubleThreeDigital\Blaze\Blaze;

class BlazeController
{
    public function index(BlazeRequest $request)
    {
        return Blaze::search($request->get('query'));
    }
}
