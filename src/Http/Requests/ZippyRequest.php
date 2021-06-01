<?php

namespace DoubleThreeDigital\Zippy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZippyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'query' => ['required', 'string'],
        ];
    }
}
