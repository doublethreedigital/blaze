<?php

namespace DoubleThreeDigital\Blaze\Http\Controllers;

use DoubleThreeDigital\Blaze\Blaze;
use DoubleThreeDigital\Blaze\Http\Requests\BlazeRequest;

class BlazeController
{
    public function index(BlazeRequest $request)
    {
        return Blaze::search($request->get('query'));
    }
}
