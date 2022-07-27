<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray($request): array
    {
        $permission = $this->permissionGroup->permissions ?? [];
        return [
            'permissions' => collect($permission)->map(function ($i) {
                return [
                    'name'    => @$i['permission']['name'] ? helper()->translate($i['permission']['name']) : null,
                    'key'     => @$i['permission']['key'] ? $i['permission']['key'] : null,
                    'options' => json_decode($i['option_field'], true)
                ];
            }),
            'user'        => [
                'id'         => $this->id,
                'email'      => $this->email,
                'fullname'   => $this->fullname,
                'name'       => $this->name,
                'surname'    => $this->surname,
                'photo'      => $this->photo['original'],
                'action'     => $this->action,
                'language'   => $this->language,
                'permission' => $this->permissionGroup ? [
                    'id'   => $this->permissionGroup->id,
                    'name' => $this->permissionGroup->name,
                ] : [],
            ],
        ];
    }
}
