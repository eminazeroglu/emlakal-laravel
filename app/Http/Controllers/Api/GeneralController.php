<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Models\LanguageService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{
    public function start(LanguageService $languageService): \Illuminate\Http\JsonResponse
    {
        $driver    = env('FILESYSTEM_DRIVER');
        $languages = $languageService->getListWithTranslate();
        $language  = env('APP_LANG');
        return response()->json([
            'languages' => $languages,
            'language'  => $language,
            'photos'    => [
                'default'          => $driver == 's3' ? Storage::url('uploads/photos/setting/default_photo.webp') : url('uploads/photos/setting/default_photo.webp'),
                'user'             => $driver == 's3' ? Storage::url('uploads/photos/setting/default_user.webp') : url('uploads/photos/setting/default_user.webp'),
                'admin_logo'       => $driver == 's3' ? Storage::url('uploads/photos/setting/admin-logo.png') : url('uploads/photos/setting/admin-logo.png'),
                'admin_logo_color' => $driver == 's3' ? Storage::url('uploads/photos/setting/admin-logo-color.jpg') : url('uploads/photos/setting/admin-logo-color.jpg'),
            ]
        ], 200);
    }

    public function artisan($params = null): string
    {
        helper()->cacheRemove('translates');
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        return '<b style="color: green; font-size: 18px">Success</b>';
    }
}
