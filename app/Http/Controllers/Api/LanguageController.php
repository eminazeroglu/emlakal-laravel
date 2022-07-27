<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LanguageRequest;
use App\Http\Requests\TranslateAddKeyRequest;
use App\Http\Requests\TranslateRemoveKeyRequest;
use App\Http\Requests\TranslateRequest;
use App\Interfaces\ApiRequestInterface;
use App\Services\Models\LanguageService;

class LanguageController extends ApiController
{
    protected array $bindings = [
        ApiRequestInterface::class => LanguageRequest::class
    ];

    public function __construct()
    {
        parent::__construct(new LanguageService(), 'language');
    }

    public function translate()
    {
        return response()->json($this->service->translateFindAll());
    }

    public function translateKeys()
    {
        return response()->json($this->service->translateKeyList());
    }

    public function translateChange(TranslateRequest $request)
    {
        return response()->json($this->service->changeTranslate($request));
    }

    public function translateAddKey(TranslateAddKeyRequest $request)
    {
        return response()->json($this->service->changeTranslate($request));
    }

    public function translateRemove(TranslateRemoveKeyRequest $request)
    {
        return response()->json($this->service->removeTranslate($request->key));
    }
}
