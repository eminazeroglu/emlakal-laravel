<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\PermissionOptionRequest;
use App\Http\Requests\PermissionRequest;
use App\Interfaces\ApiRequestInterface;
use App\Services\Models\PermissionService;

class PermissionController extends ApiController
{
    protected array $bindings = [
        ApiRequestInterface::class => PermissionRequest::class
    ];

    public function __construct()
    {
        parent::__construct(new PermissionService(), 'permission');
    }

    public function option($id)
    {
        if (helper()->can($this->permission, 'read'))
            return response()->json($this->service->getPermissionList($id));
        return response()->json($this->forbiddenMessage, 403);
    }

    public function optionSave(PermissionOptionRequest $request, $id)
    {
        if (helper()->can($this->permission, 'read'))
            return response()->json($this->service->setPermissionOptions($id, $request));
        return response()->json($this->forbiddenMessage, 403);
    }
}
