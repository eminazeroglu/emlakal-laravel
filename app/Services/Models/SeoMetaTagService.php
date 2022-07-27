<?php

namespace App\Services\Models;

use App\Models\SeoMetaTag;
use App\Services\BaseModelService;
use Illuminate\Database\Eloquent\Model;

class SeoMetaTagService extends BaseModelService
{
    public function __construct()
    {
        $this->setFields([
            'bots' => json_encode(request()->bots)
        ]);
        parent::__construct(new SeoMetaTag(), 'SeoMetaTag');
    }

    public function getUrl($url, $select = ['*'], $insert = true): Model
    {
        $url = preg_replace(['/&page=\d+/', '/\?page=\d+/', '/&order=\d+/', '/\?order=\d+/'], null, $url);
        if (substr_count($url, '/') === 2) $url = rtrim($url, '/');
        $item           = $this->model
            ->select($select)
            ->url($url)
            ->first();
        $pathInfoLength = strlen(request()->getPathInfo());
        if (strpos($url, '&') === $pathInfoLength) $url = substr_replace($url, '?', $pathInfoLength, 1);
        if ($insert && $url):
            if (!$item):
                $item       = $this->model;
                $item->url  = $url;
                $item->bots = json_encode([
                    "robots"    => 'index, follow, archive',
                    "googlebot" => 'index, follow, archive',
                    "yahoobot"  => 'index, follow, archive',
                    "alexabot"  => 'index, follow, archive',
                    "msnbot"    => 'index, follow, archive',
                    "dmozbot"   => 'index, follow, archive'
                ]);
                $item->save();
            endif;
        endif;
        return $item;
    }

    public function findPaginateList($resource = false): array
    {
        $data = $this->model
            ->when(request()->query('title'), function ($q) {
                return $q->where('title', 'like', '%' . request()->query('title') . '%');
            })
            ->when(request()->query('url'), function ($q) {
                return $q->where('url', 'like', '%' . request()->query('url') . '%');
            })
            ->oldest('title')
            ->latest('id')
            ->paginate(request()->query('limit'));

        return [
            'data'  => $this->resource($data, 'table'),
            'total' => $data->total()
        ];
    }
}
