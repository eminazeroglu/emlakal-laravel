<?php

namespace App\Services\System;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    protected $imageService;

    public function __construct()
    {
        $this->imageService = new ImageUploadService();
    }

    /*
     * Set Photo
     * */
    public function setPhoto($request)
    {
        $file      = $request->file('file');
        $name      = $request->file_name;
        $path      = $request->path ?? 'default';
        $degree    = $request->degree ?? 0;
        $thumbnail = json_decode($request->thumbnail, true);
        $folder    = date('d-m-Y');

        $image = $this->imageService
            ->setFile($file)
            ->setThumbnail($thumbnail['width'] ?? 200, $thumbnail['height'] ?? 200)
            ->setPath($path . '/' . $folder)
            ->setRotate($degree)
            ->setWatermark('watermark.png')
            ->setRemoveFile($name ?? null)
            ->upload();
        if ($image):
            $imagePath = $this->imageService->getPhoto($path . '/' . $folder, $image);
            return helper()->response('success', [
                'name' => $folder . '/' . $image,
                'link' => $imagePath['thumbnail'] ?? null,
                'hash' => helper()->enCrypto(json_encode([
                    'name' => $folder . '/' . $image,
                    'path' => $path
                ]))
            ]);
        endif;
        return helper()->response('server_error');
    }

    /*
     * Set Editor Photo
     * */
    public function setEditorPhoto($request)
    {
        $image = $this->imageService
            ->setFile($request->file('file'))
            ->setPath('editor')
            ->upload();
        if ($image):
            $imageName = $this->imageService->getPhoto('editor', $image);
            return response()->json([
                'location' => $imageName['original']
            ]);
        endif;
        return helper()->response('server_error');
    }

    /*
     * Photo Remove
     * */
    public function photo_remove($request)
    {
        $validator = validator()->make($request->all(), [
            'hash' => 'required'
        ]);
        if ($validator->fails()):
            return helper()->response('error', $validator->errors());
        endif;
        $hash = json_decode(helper()->deCrypto($request->input('hash')), true);
        $path = $hash['path'] ?? null;
        $name = $hash['name'] ?? null;
        if ($path && $name):
            $delete = $this->imageService->delete($path, $name);
            if ($delete):
                return helper()->response('success');
            endif;
        endif;
        return helper()->response('server_error');
    }

    /*
     * Photo Remove All
     * */
    public function photo_remove_all($request)
    {
        $hash = $request->input('hash');
        if (count($hash) > 0):
            foreach ($hash as $item):
                $decode = json_decode(helper()->deCrypto($item), true);
                $path = @$decode['path'];
                $name = @$decode['name'];
                if ($path && $name):
                    $this->imageService->delete($path, $name);
                endif;
            endforeach;
        endif;
        return helper()->response('success');
    }
}
