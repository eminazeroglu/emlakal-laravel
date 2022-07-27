<?php

namespace App\Http\Controllers;

use App\Interfaces\ApiControllerInterface;
use App\Interfaces\ApiRequestInterface;
use App\Services\BaseModelService;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

abstract class ApiController extends Controller implements ApiControllerInterface
{
    protected       $service;
    protected array $bindings         = [];
    protected array $events           = [];
    protected       $permission       = null;
    protected       $forbiddenMessage = 'You are not authorized to do this operation.';

    public function __construct(BaseModelService $service, $permission)
    {
        $this->service    = $service;
        $this->permission = $permission;
        $this->addBindings();
    }

    public function index()
    {
        if (helper()->can($this->permission, 'read'))
            return response()->json($this->service->findPaginateList(true));
        return response()->json($this->forbiddenMessage, 403);
    }

    public function select()
    {
        if (helper()->can($this->permission) > 1)
            return response()->json($this->service->findAll(true));
        return response()->json($this->forbiddenMessage, 403);
    }

    public function show($id)
    {
        if (helper()->can($this->permission) > 1)
            return response()->json($this->service->findById($id, true));
        return response()->json($this->forbiddenMessage, 403);
    }

    public function store(ApiRequestInterface $request)
    {
        $data = $this->service->create($request);
        if (isset($this->events['store'])) event(new $this->events['store']($data, 'store'));
        return response()->json($data);
    }

    public function update(ApiRequestInterface $request, $id)
    {
        $data = $this->service->update($request, $id);
        if (isset($this->events['update'])) event(new $this->events['update']($data, 'update'));
        return response()->json($data);
    }

    public function destroy($id)
    {
        if (helper()->can($this->permission, 'delete')):
            $data = $this->service->deleteById($id);
            if (isset($this->events['destroy'])) event(new $this->events['destroy']($data, 'destroy'));
            return response()->json($data);
        endif;
        return response()->json($this->forbiddenMessage, 403);
    }

    public function destroyAll()
    {
        if (helper()->can($this->permission, 'delete')):
            $data = $this->service->deleteAll();
            return response()->json($data);
        endif;
        return response()->json($this->forbiddenMessage, 403);
    }

    public function action(Request $request, $id)
    {
        if (helper()->can($this->permission, 'action')):
            $data = $this->service->changeStatus($id, $request->action);
            return response()->json($data);
        endif;
        return response()->json($this->forbiddenMessage, 403);
    }

    private function addBindings(): void
    {
        $app = Container::getInstance();
        foreach ($this->getBindings() as $abstract => $concrete):
            $app->bind($abstract, $concrete);
        endforeach;
    }

    private function getBindings(): array
    {
        return $this->bindings;
    }
}
