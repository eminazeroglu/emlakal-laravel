<?php

namespace App\Http\Requests;

use App\Enums\MenuTypeEnum;
use BenSampo\Enum\Rules\EnumValue;

class MenuRequest extends ApiRequest
{
    public function __construct()
    {
        $this->permission = 'menu';
    }

    public function rules(): array
    {
        return [
            'link'              => ['required', 'unique:menus,link' . ($this->menu ? ',' . $this->menu : '')],
            'type'              => ['required', new EnumValue(MenuTypeEnum::class)],
            'translates'        => ['required'],
            'translates.*'      => ['required'],
            'translates.*.name' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'link.required'              => helper()->translate('validator.Required'),
            'link.unique'                => helper()->translate('validator.Unique'),
            'type.required'              => helper()->translate('validator.Required'),
            'translates.required'        => helper()->translate('validator.Required'),
            'translates.*.required'      => helper()->translate('validator.Required'),
            'translates.*.name.required' => helper()->translate('validator.Required')
        ];
    }
}
