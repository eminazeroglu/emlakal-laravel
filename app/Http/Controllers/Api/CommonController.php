<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Services\Models\MenuService;
use App\Services\Models\SeoMetaTagService;
use App\Services\Models\SettingService;

class CommonController extends Controller
{
    public function start(SettingService $settingService, MenuService $menuService): \Illuminate\Http\JsonResponse
    {
        $data      = $settingService->getLogo();
        $menus     = $menuService->findAll();
        $languages = Language::query()->with('translates')->active()->get();
        $result    = [
            'photos'    => [
                'logo'          => url('uploads/photos/setting/' . $data['value']['logo']),
                'footer'        => url('uploads/photos/setting/' . $data['value']['footer']),
                'favicon'       => url('uploads/photos/setting/' . $data['value']['favicon']),
                'wallpaper'     => url('uploads/photos/setting/' . $data['value']['wallpaper']),
                'default_user'  => url('uploads/photos/setting/default_user.webp'),
                'default_photo' => url('uploads/photos/setting/default_photo.webp'),
            ],
            'languages' => $languages
        ];
        if (request()->query('admin')):
            $result['photos']['admin_logo']       = url('uploads/photos/setting/' . $data['value']['admin_logo']);
            $result['photos']['admin_logo_color'] = url('uploads/photos/setting/' . $data['value']['admin_logo_color']);
        else:
            $result['menus'] = $menus;
        endif;
        return response()->json($result);
    }

    public function seo(SeoMetaTagService $seoMetaTagService, $link = null): \Illuminate\Http\JsonResponse
    {
        $data = $seoMetaTagService->findByUrl('/' . $link);
        return response()->json($data);
    }
}
