<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $model)
    {
        $model->user_name = helper()->createSlug($model, $model->name . ' ' . $model->surname, 'user_name');
        $model->user_code = 'CTA' . helper()->uniqueNumber($model, 6, 'user_code');
    }

    public function saving(User $model)
    {
        $this->creating($model);
    }
}
