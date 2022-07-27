<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SettingRequest;
use App\Interfaces\ApiRequestInterface;
use App\Services\Models\SettingService;

class SettingController extends ApiController
{
    protected array $bindings = [
        ApiRequestInterface::class => SettingRequest::class
    ];

    public function __construct()
    {
        parent::__construct(new SettingService(), 'setting');
    }
}
