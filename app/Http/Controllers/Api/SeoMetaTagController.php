<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SeoMetaTagRequest;
use App\Interfaces\ApiRequestInterface;
use App\Services\Models\SeoMetaTagService;

class SeoMetaTagController extends ApiController
{
    protected array $bindings = [
        ApiRequestInterface::class => SeoMetaTagRequest::class
    ];

    public function __construct()
    {
        parent::__construct(new SeoMetaTagService(), 'seo_meta_tag');
    }
}
