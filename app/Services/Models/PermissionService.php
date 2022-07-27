<?php

namespace App\Services\Models;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionPivotGroup;
use App\Services\BaseModelService;

class PermissionService extends BaseModelService
{
    protected $slug = 'url';

    public function __construct()
    {
        parent::__construct(new PermissionGroup(), 'Permission');
    }

    public function changeStatus($id, $action = 'is_active')
    {
        $data = $this->model->query()->findOrFail($id);
        if ($data && $data->id !== 1 && $data->id !== 2):
            $data[$action] = !$data[$action];
            $data->save();
            return $this->resource($data, 'one');
        endif;
        return helper()->exception('Not found');
    }

    public function findPaginateList($resource = false): array
    {
        $data = $this->model
            ->when(request()->query('q'), function ($q) {
                return $q->where('name', 'like', '%' . request()->query('q') . '%');
            })
            ->latest('id')
            ->paginate(request()->query('limit'));

        return [
            'data'  => $this->resource($data, 'table'),
            'total' => $data->total()
        ];
    }

    public function deleteById($id)
    {
        $item = $this->model->query()->findOrFail($id);
        if ($item->id !== 1 && $item->id !== 2)
            return $item->delete();
        return helper()->exception('Not found');
    }

    public function deleteAll()
    {
        return $this->model->query()->whereNotIn('id', [1, 2])->delete();
    }

    public function getPermissionList($group_id): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|array
    {
        return Permission::query()->get()->map(function ($item) use ($group_id) {
            $find       = PermissionPivotGroup::where('permission_id', $item->id)->where('group_id', $group_id)->first();
            $itemOption = collect($item->option)->map(function ($i) {
                return $i['value'];
            });
            $option     = [
                'create' => false,
                'read'   => false,
                'update' => false,
                'delete' => false,
                'action' => false,
            ];
            if ($find):
                $findOption = $find->option_field ? json_decode($find->option_field, true) : [];
                foreach ($itemOption as $value):
                    $option[$value] = $findOption[$value] ?? false;
                endforeach;
            endif;
            return [
                'id'     => $item->id,
                'name'   => $item->name,
                'create' => $option['create'],
                'read'   => $option['read'],
                'update' => $option['update'],
                'delete' => $option['delete'],
                'action' => $option['action'],
            ];
        });
    }

    public function setPermissionOptions($id, $request): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $group = $this->model->query()->findOrFail($id);

        $data = PermissionPivotGroup::query()
            ->wherePermissionId($request->permission_id)
            ->whereGroupId($id)
            ->first();

        \Schema::disableForeignKeyConstraints();
        if ($data):
            $data->update([
                'option_field' => json_encode($request->option)
            ]);
        else:
            $data = PermissionPivotGroup::query()->create([
                'permission_id' => $request->permission_id,
                'group_id'      => $group->id,
                'option_field'  => json_encode($request->option),
            ]);
        endif;
        \Schema::enableForeignKeyConstraints();

        return $data;
    }
}
