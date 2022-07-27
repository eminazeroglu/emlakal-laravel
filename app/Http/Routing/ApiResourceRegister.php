<?php

namespace App\Http\Routing;

use Illuminate\Routing\ResourceRegistrar;

class ApiResourceRegister extends ResourceRegistrar
{
    protected $resourceDefaults = [
        'select',
        'index',
        'store',
        'show',
        'action',
        'update',
        'destroy',
        'destroyAll',
    ];

    protected function addResourceDestroyAll($name, $base, $controller, $options): \Illuminate\Routing\Route
    {
        $uri    = $this->getResourceUri($name);
        $action = $this->getResourceAction($name, $controller, 'destroyAll', $options);
        return $this->router->delete($uri, $action);
    }

    protected function addResourceAction($name, $base, $controller, $options): \Illuminate\Routing\Route
    {
        $uri    = $this->getResourceUri($name . '/{' . str($name)->singular() . '}/action');
        $action = $this->getResourceAction($name, $controller, 'action', $options);
        return $this->router->post($uri, $action);
    }

    protected function addResourceSelect($name, $base, $controller, $options): \Illuminate\Routing\Route
    {
        $uri    = $this->getResourceUri($name . '/select');
        $action = $this->getResourceAction($name, $controller, 'select', $options);
        return $this->router->get($uri, $action);
    }
}
