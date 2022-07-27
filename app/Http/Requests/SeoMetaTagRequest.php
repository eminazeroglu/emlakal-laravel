<?php

namespace App\Http\Requests;

class SeoMetaTagRequest extends ApiRequest
{
    public function __construct()
    {
        parent::__construct('seo_meta_tag');
    }

    public function rules(): array
    {
        return [
            'url'         => ['required', 'unique:seo_meta_tags,url' . ($this->seo_meta_tag ? ',' . $this->seo_meta_tag : '')],
            'title'       => ['required', 'max:65'],
            'description' => ['required', 'max:200'],
            'keywords'    => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'url.required'         => helper()->translate('validator.Required'),
            'url.unique'           => helper()->translate('validator.Unique'),
            'title.required'       => helper()->translate('validator.Required'),
            'title.max'            => helper()->translate('validator.Max'),
            'description.required' => helper()->translate('validator.Required'),
            'description.max'      => helper()->translate('validator.Max'),
            'keywords.required'    => helper()->translate('validator.Required'),
            'keywords.max'         => helper()->translate('validator.Max'),
        ];
    }
}
