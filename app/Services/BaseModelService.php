<?php

namespace App\Services;

use App\Interfaces\BaseModelServiceInterface;
use App\Services\System\ImageUploadService;
use Illuminate\Database\Eloquent\Model;

class BaseModelService implements BaseModelServiceInterface
{
    protected array              $fields              = [];
    protected                    $slug;
    protected                    $slug_key            = 'name';
    protected                    $photo_request_field = 'photo';
    protected                    $photo_field         = 'photo_path';
    protected                    $code_field          = 'code';
    protected                    $generateCode        = false;
    protected                    $uploadPhoto         = false;
    protected Model              $model;
    protected mixed              $resource_name;
    protected ImageUploadService $imageService;

    public function __construct(Model $model, $resource_name = null)
    {
        $this->model         = $model;
        $this->resource_name = $resource_name;
        $this->imageService  = new ImageUploadService();
    }

    public function getFields(\App\Interfaces\ApiRequestInterface $request, $data = null): array
    {
        $fields = $request->only($this->model->getFillable());

        if (request()->translates):
            if ($this->slug && !$data?->{$this->slug}):
                $fields[$this->slug] = helper()->createSlug($this->model, array_first((array)request()->translates)[$this->slug_key], $this->slug);
            endif;
        elseif ($this->slug && !$data?->{$this->slug}):
            $fields[$this->slug] = request()->input($this->slug_key);
        endif;

        if ($this->generateCode && !$data?->{$this->code_field}):
            $fields[$this->code_field] = helper()->uniqueNumber($this->model, 8, $this->code_field);
        endif;

        if ($this->uploadPhoto && request()->input($this->photo_request_field)):
            $fields[$this->photo_field] = $this->uploadPhoto(request()->input($this->photo_request_field), $this->photo_field);
        endif;

        if (count($this->fields) > 0):
            $fields = array_merge($fields, $this->fields);
        endif;
        return $fields;
    }

    protected function setFields($fields)
    {
        if (request()->getMethod() === 'POST' || request()->getMethod() === 'PUT'):
            $this->fields = $fields;
        endif;
    }

    public function uploadPhoto($value, $field = 'photo'): ?string
    {
        if ($value):
            $photo = $this->imageService
                ->setFile($value)
                ->setBase64(true)
                ->setPath($this->model->getPath())
                ->setRemoveFile($data[$field] ?? null)
                ->upload();
            if ($photo) return $photo;
        endif;
        return null;
    }

    public function resource($data, $type = null)
    {
        $base = "\\App\\Http\\Resources\\BaseResource";
        if ($type === 'one'):
            return new $base($data);
        else:
            return $base::collection($data);
        endif;
    }

    public function create($request)
    {
        $fields = $this->getFields($request);
        if (in_array('user_id', $this->fields)) $fields['user_id'] = auth()->id();
        $data = $this->model->query()->create($fields);
        return $this->resource($data, 'one');
    }

    public function update($request, $id)
    {
        $data   = $this->model->query()->findOrFail($id);
        $fields = $this->getFields($request, $data);
        if (in_array('user_id', $this->fields)) $fields['user_id'] = auth()->id();
        $data->update($fields);
        return $this->resource($data, 'one');
    }

    public function changeStatus($id, $action = 'is_active')
    {
        $data = $this->model->query()->findOrFail($id);
        if ($data):
            $data[$action] = !$data[$action];
            $data->save();
            return $this->resource($data, 'one');
        endif;
        return false;
    }

    public function findById($id, $resource = false)
    {
        $data = $this->model->query()->findOrFail($id);
        return $resource ? $this->resource($data, 'one') : $data;
    }

    public function findByUrl($url, $resource = false)
    {
        $result = $this->model->query()->where('url', $url)->firstOrFail();
        if (is_array($url))
            $result = $this->model->query()->whereIn('url', $url)->get();
        return $resource ? $this->resource($result) : $result;
    }

    public function findAll($resource = false)
    {
        $data = $this->model->query()->get();
        return $resource ? $this->resource($data, 'list') : $data;
    }

    public function findPaginateList($resource = false)
    {
        $data = $this->model->query()
            ->when(request()->query('q'), function ($q) {
                return $q->nameLike(request()->query('q'));
            })
            ->latest('id')
            ->paginate(request()->query('limit'));

        return [
            'data'  => $this->resource($data),
            'total' => $data->total()
        ];
    }

    public function findActiveList($resource = false)
    {
        $data = $this->model->query()
            ->where('is_active', 1)
            ->latest('id')
            ->get();
        return $resource ? $this->resource($data) : $data;
    }

    public function findDeActiveList($resource = false)
    {
        $data = $this->model->query()
            ->where('is_active', 0)
            ->latest('id')
            ->get();
        return $resource ? $this->resource($data) : $data;
    }

    public function deleteById($id)
    {
        return $this->model->query()->findOrFail($id)->delete();
    }

    public function deleteAll()
    {
        return $this->model->query()->delete();
    }
}
