<?php

namespace App\Http\Requests;

class PermissionRequest extends ApiRequest
{
    public function __construct()
    {
        $this->permission = 'permission';
    }

    public function rules(): array
    {
        return [
            'translates'        => 'required',
            'translates.*'      => 'required',
            'translates.*.name' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'translates.*.name.required' => helper()->translate('validator.Required')
        ];
    }
}
