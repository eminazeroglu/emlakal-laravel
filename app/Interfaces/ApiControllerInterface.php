<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ApiControllerInterface
{
    public function index();

    public function select();

    public function show($id);

    public function store(ApiRequestInterface $request);

    public function update(ApiRequestInterface $request, $id);

    public function destroy($id);

    public function destroyAll();

    public function action(Request $request, $id);
}
