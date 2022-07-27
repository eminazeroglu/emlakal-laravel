<?php

namespace App\Services\Models;

use App\Models\Setting;
use App\Services\BaseModelService;

class SettingService extends BaseModelService
{
    public function __construct()
    {
        parent::__construct(new Setting(), 'Setting');
    }

    /*
    * Get General
    * */
    public function getGeneral()
    {
        return $this->model->query()->key('general')->first();
    }

    /*
     * Get Work Time
     * */
    public function getWorkTime()
    {
        return $this->model->query()->key('work-time')->first();
    }

    /*
     * Get Logo
     * */
    public function getLogo(): array
    {
        $item   = $this->model->query()->key('logo')->first();
        $result = [];
        foreach ($item['value'] as $key => $value):
            if ($value):
                $result[$key . '_path'] = $this->imageService->getPhoto($this->model->getPath(), $value)['original'];
            endif;
        endforeach;
        return [
            'id'    => $item->id,
            'key'   => $item->key,
            'value' => array_merge($item->value, $result),
        ];
    }

    /*
     * Get Html
     * */
    public function getHtml()
    {
        return $this->model->query()->key('html')->first();
    }

    /*
     * Get Mail
     * */
    public function getMail()
    {
        return $this->model->query()->key('mail')->first();
    }

    /*
     * Get Notification
     * */
    public function getNotification()
    {
        return $this->model->query()->key('notification')->first();
    }

    /*
     * Get Social Page
     * */
    public function getSocialPage(): \Illuminate\Support\Collection
    {
        return collect($this->model->query()->key('social-page')->first())->merge(['icon_url' => url('assets/icons/icon.html')]);
    }

    /*
     * Find By Id
     * */
    public function findById($id, $resource = false)
    {
        $method = camel_case('get-' . $id);
        return $this->$method();
    }

    /*
     * Update
     * */
    public function update($request, $id)
    {
        $data = $this->model->query()->where('key', $id)->firstOrFail();

        if ($data->key === 'logo'):
            $result = [];
            foreach ($request->all() as $key => $value):
                $result[$key] = '';
                if ($value):
                    $photo = $this->imageService
                        ->setFile($value)
                        ->setBase64(true)
                        ->setPath($this->model->getPath())
                        ->setName($key)
                        ->setRemoveFile($data->value[$key])
                        ->upload();
                    if ($photo) $result[$key] = $photo;
                endif;
            endforeach;
            $data->update([
                'value_field' => json_encode($result)
            ]);
        else:
            $data->update([
                'value_field' => json_encode($request->all())
            ]);
        endif;

        return $data;
    }
}
