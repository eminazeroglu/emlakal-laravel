<?php

namespace App\Interfaces;

interface BaseModelServiceInterface
{
    public function uploadPhoto($value, $field = 'photo_name');

    public function resource($data, $type = 'base');

    public function create(ApiRequestInterface $request);

    public function update(ApiRequestInterface $request, $id);

    public function changeStatus($id, $action = 'is_active');

    public function findById($id, $resource = false);

    public function findByUrl($url, $resource = false);

    public function findAll($resource = false);

    public function findPaginateList($resource = false);

    public function findActiveList($resource = false);

    public function findDeActiveList($resource = false);

    public function deleteById($id);

    public function deleteAll();

}
