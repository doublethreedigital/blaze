<?php

namespace DoubleThreeDigital\Zippy\Http\Controllers;

use DoubleThreeDigital\Zippy\Http\Requests\ZippyRequest;
use DoubleThreeDigital\Zippy\Zippy;

class ZippyController
{
    public function index(ZippyRequest $request)
    {
        return Zippy::search($request->get('query'));
    }
}
