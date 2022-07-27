<?php

namespace App\Http\Requests;

use App\Rules\ImageBase64Rule;

class SettingRequest extends ApiRequest
{
    public function __construct()
    {
        $this->permission = 'setting';
    }

    public function generalRule(): array
    {
        return [
            'language' => 'required|exists:languages,code'
        ];
    }

    public function logoRule(): array
    {
        return [
            'logo'      => ['nullable', new ImageBase64Rule],
            'footer'    => ['nullable', new ImageBase64Rule],
            'mobile'    => ['nullable', new ImageBase64Rule],
            'favicon'   => ['nullable', new ImageBase64Rule],
            'wallpaper' => ['nullable', new ImageBase64Rule],
        ];
    }

    public function rules(): array
    {
        $method = request()->key . 'Rule';
        return method_exists($this, $method) ? $this->$method() : [];
    }

    public function messages(): array
    {
        return [
            'language.required'     => helper()->translate('validator.Required'),
            'logo.base64image'      => helper()->translate('validator.Image'),
            'footer.base64image'    => helper()->translate('validator.Image'),
            'mobile.base64image'    => helper()->translate('validator.Image'),
            'favicon.base64image'   => helper()->translate('validator.Image'),
            'wallpaper.base64image' => helper()->translate('validator.Image'),
        ];
    }
}
