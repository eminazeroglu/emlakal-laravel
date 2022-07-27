<?php

namespace App\Services\Models;

use App\Http\Resources\TranslateTableResource;
use App\Models\Language;
use App\Models\Translate;
use App\Services\BaseModelService;
use Exception;

class LanguageService extends BaseModelService
{
    public function __construct()
    {
        parent::__construct(new Language(), 'Language');
    }

    public function changeStatus($id, $action = 'is_active')
    {
        $data = $this->model->query()->findOrFail($id);
        if ($data && $data->code !== 'az'):
            $data[$action] = !$data[$action];
            $data->save();
            return $this->resource($data, 'one');
        endif;
        return response()->json('Not found', 404);
    }

    public function findPaginateList($resource = false): array
    {
        $data = $this->model->query()
            ->when(request()->query('q'), function ($q) {
                return $q->nameLike(request()->query('q'));
            })
            ->when(request()->query('code'), function ($q) {
                return $q->codeLike(request()->query('code'));
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
        if ($item->code !== 'az')
            return $item->delete();
        return response()->json('Not found', 404);
    }

    public function deleteAll()
    {
        return $this->model->query()->where('code', '!=', 'az')->delete();
    }

    public function translateFindAll(): array
    {
        $data = Translate::query()
            ->groupBy('key')
            ->when(request()->query('key'), function ($q) {
                $q->where('key', 'like', request()->query('key') . '%');
            })
            ->paginate(request()->query('limit'));

        return [
            'data'  => TranslateTableResource::collection($data),
            'total' => $data->total()
        ];
    }

    public function translateKeyList(): array
    {
        return (new Translate())->getKeys();
    }

    public function changeTranslate($request): array|string
    {
        try {
            $result = [];
            foreach ($request->all() as $lang => $translate):
                $data       = Translate::query()->where('lang', $lang)->where('key', $translate['key'])->first();
                $data       = $data ?? new Translate();
                $data->lang = $lang;
                $data->key  = $translate['key'];
                $data->text = $translate['text'];
                $data->save();
                $result[] = $data;
            endforeach;
            helper()->cacheRemove('translates');
            return $result;
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function removeTranslate($key)
    {
        return Translate::query()->where('key', $key)->delete();
    }

    public function getListWithTranslate()
    {
        return $this->model->query()
            ->with('translates')
            ->active()
            ->get();
    }
}
