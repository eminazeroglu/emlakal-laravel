<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\MenuRequest;
use App\Interfaces\ApiRequestInterface;
use App\Services\Models\MenuService;

class MenuController extends ApiController
{
    protected array $bindings = [
        ApiRequestInterface::class => MenuRequest::class
    ];

    public function __construct()
    {
        parent::__construct(new MenuService(), 'menu');
    }
}
