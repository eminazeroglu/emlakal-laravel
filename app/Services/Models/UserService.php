<?php

namespace App\Services\Models;

use App\Models\User;
use App\Services\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends BaseModelService
{
    public function __construct()
    {
        $this->setFields([
            'photo_path' => $this->uploadPhoto(request()->photo_path),
            'password'   => bcrypt(request()->password)
        ]);
        parent::__construct(new User(), 'User');
    }

    /*
     * Change Status
     * */
    public function changeStatus($id, $action = 'is_active')
    {
        $data = $this->model->query()->findOrFail($id);
        if ($data && $data->email !== 'admin@app.com' && $data->email !== 'support@app.com'):
            $data[$action] = !$data[$action];
            $data->save();
            return $this->resource($data, 'one');
        endif;
        return throw new ModelNotFoundException('Data not found', 404);
    }

    public function findByToken(): \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        return auth()->user();
    }

    public function findPaginateList($resource = false): array
    {
        $data = $this->model
            ->with('permissionGroup:id,translates')
            ->where('email', '!=', 'support@app.com')
            ->when(request()->query('q'), function ($q) {
                return $q->fullNameLike(request()->query('q'));
            })
            ->when(request()->query('fullname'), function ($q) {
                return $q->fullNameLike(request()->query('fullname'));
            })
            ->when(request()->query('email'), function ($q) {
                return $q->emailLike(request()->query('email'));
            })
            ->when(request()->query('type') === 'admin', function ($q) {
                return $q->onlyAdmin();
            })
            ->when(request()->query('type') === 'user', function ($q) {
                return $q->onlyUser();
            })
            ->latest('id')
            ->paginate(request()->query('limit'));

        return [
            'data'  => $this->resource($data, 'table'),
            'total' => $data->total()
        ];
    }

    /*
     * Delete By Id
     * */
    public function deleteById($id)
    {
        $item = $this->model->query()->findOrFail($id);
        if ($item->email !== 'admin@app.com' && $item->email !== 'support@app.com')
            return $item->delete();
        return throw new ModelNotFoundException('Data not found', 404);
    }

    /*
     * Delete All
     * */
    public function deleteAll()
    {
        return $this->model->query()->whereNotIn('email', ['admin@app.com', 'support@app.com'])->delete();
    }
}
