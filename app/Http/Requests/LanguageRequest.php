<?php

namespace App\Http\Requests;

class LanguageRequest extends ApiRequest
{
    public function __construct()
    {
        parent::__construct('language');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:languages,name' . ($this->language ? ',' . $this->language : '')],
            'code' => ['required', 'unique:languages,code' . ($this->language ? ',' . $this->language : '')]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => helper()->translate('validator.Required'),
            'name.unique'   => helper()->translate('validator.Unique'),
            'code.required' => helper()->translate('validator.Required'),
            'code.unique'   => helper()->translate('validator.Unique'),
        ];
    }
}
