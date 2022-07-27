<?php

namespace App\Http\Requests;

class TranslateAddKeyRequest extends ApiRequest
{
    public function __construct()
    {
        $this->permission = 'language';
    }

    public function rules(): array
    {
        return [
            '*.text' => 'required',
            '*.key'  => 'required|unique:translates,key'
        ];
    }

    public function messages(): array
    {
        return [
            '*.text.required' => helper()->translate('validator.Required'),
            '*.key.required'  => helper()->translate('validator.Required'),
            '*.key.unique'    => helper()->translate('validator.Unique'),
        ];
    }
}
