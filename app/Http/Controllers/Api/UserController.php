<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Interfaces\ApiRequestInterface;
use App\Services\Models\UserService;

class UserController extends ApiController
{
    protected array $bindings = [
        ApiRequestInterface::class => UserRequest::class
    ];

    public function __construct()
    {
        parent::__construct(new UserService(), 'user');
    }
}
