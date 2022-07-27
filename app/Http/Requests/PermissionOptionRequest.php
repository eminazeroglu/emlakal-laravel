<?php

namespace App\Http\Requests;

class PermissionOptionRequest extends ApiRequest
{
    public function __construct()
    {
        $this->permission = 'permission';
    }

    public function rules(): array
    {
        return [
            'permission_id' => 'required|integer|exists:permissions,id',
            'option.create' => 'required|boolean',
            'option.read'   => 'required|boolean',
            'option.update' => 'required|boolean',
            'option.delete' => 'required|boolean',
            'option.action' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'permission_id.required' => helper()->translate('validator.Required'),
            'permission_id.integer'  => helper()->translate('validator.Integer'),
            'permission_id.exists'   => helper()->translate('validator.Exists'),
            'group_id.required'      => helper()->translate('validator.Required'),
            'group_id.integer'       => helper()->translate('validator.Integer'),
            'group_id.exists'        => helper()->translate('validator.Exists'),
            'option.create.required' => helper()->translate('validator.Required'),
            'option.read.required'   => helper()->translate('validator.Required'),
            'option.update.required' => helper()->translate('validator.Required'),
            'option.delete.required' => helper()->translate('validator.Required'),
            'option.action.required' => helper()->translate('validator.Required'),
        ];
    }
}
