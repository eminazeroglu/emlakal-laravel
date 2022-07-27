<?php

namespace App\Http\Resources;

use App\Services\Models\LanguageService;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslateTableResource extends JsonResource
{
    public function toArray($request): array
    {
        $result = [];
        foreach ((new LanguageService())->findActiveList(false) as $language):
            $result[$language->code] = $this->key;
        endforeach;
        return $result;
    }
}
