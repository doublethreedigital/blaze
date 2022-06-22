<?php

namespace DoubleThreeDigital\Blaze\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlazeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'query' => ['nullable', 'string'],
        ];
    }
}
