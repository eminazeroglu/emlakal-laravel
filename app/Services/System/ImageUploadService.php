<?php

namespace App\Services\System;

/*
 * Image Upload Service
 *
 * */

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageUploadService
{
    private $driver;
    private $main_folder = '/uploads/photos';
    private $name;
    private $path;
    private $formats;
    private $base64;
    private $url;
    private $quality;
    private $size;
    private $watermark;
    private $thumbnail;
    private $medium;
    private $large;
    private $file;
    private $remove;
    private $rotate;

    public function __construct($file = null)
    {
        $this->driver = env('FILESYSTEM_DRIVER');
        $this->file   = $file;
        $uploadPath   = public_path($this->main_folder);
        if ($this->driver == 's3'):
            if (!Storage::exists($uploadPath)):
                Storage::makeDirectory($uploadPath);
            endif;
        else:
            if (!File::isDirectory($uploadPath)):
                File::makeDirectory($uploadPath, 0777, true, true);
            endif;
        endif;
    }

    /*
     * Set File
     * */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /*
     * Set Name
     * */
    public function setName(string $val)
    {
        $this->name = $val;
        return $this;
    }

    /*
     * Set Path
     * */
    public function setPath(string $val)
    {
        $this->path = $val;
        return $this;
    }

    /*
     * Set Remove File
     * */
    public function setRemoveFile(string $name = null)
    {
        $this->remove = $name;
        return $this;
    }

    /*
     * Set Formats
     * */
    public function setFormats(array $val)
    {
        $this->formats = $val;
        return $this;
    }

    /*
     * Set Base64
     * */
    public function setBase64(bool $val)
    {
        $this->base64 = $val;
        return $this;
    }

    /*
     * Set Url
     * */
    public function setUrl(bool $val)
    {
        $this->url = $val;
        return $this;
    }

    /*
     * Set Quality
     * */
    public function setQuality(int $val = 85)
    {
        $this->quality = $val;
        return $this;
    }

    /*
     * Set Rotate
     * */
    public function setRotate(int $val)
    {
        $this->rotate = $val;
        return $this;
    }

    /*
     * Set Size
     * */
    public function setSize(int $width, int $height)
    {
        $this->size = ['width' => $width, 'height' => $height];
        return $this;
    }

    /*
     * Set Watermark
     * */
    public function setWatermark(string $name, int $resize = 60, string $position = 'center', int $x = 0, $y = 0)
    {
        $this->watermark = [
            'name'     => $name,
            'resize'   => $resize,
            'position' => $position,
            'x'        => $x,
            'y'        => $y,
        ];
        return $this;
    }

    /*
     * Set Thumbnail
     * */
    public function setThumbnail(int $width, int $height)
    {
        $this->thumbnail = [
            'width'  => $width,
            'height' => $height
        ];
        return $this;
    }

    /*
     * Set Medium
     * */
    public function setMedium(int $width, int $height)
    {
        $this->medium = [
            'width'  => $width,
            'height' => $height
        ];
        return $this;
    }

    /*
     * Set Large
     * */
    public function setLarge(int $width, int $height)
    {
        $this->large = [
            'width'  => $width,
            'height' => $height
        ];
        return $this;
    }

    /*
     * Simple Upload
     * */
    public function simple_upload($file, string $path, string $name, string $extension, int $width, int $height, string $type, $rotate = null)
    {
        $result = false;
        $folder = public_path($this->main_folder . $path . '/' . $type);

        if (!File::isDirectory($folder))
            File::makeDirectory($folder);
        $file_path = $folder . '/' . $name . '.' . $extension;

        $Image = Image::make($file);
        if ($rotate)
            $Image = $Image->rotate($rotate);
        $Image = $Image->resize($width, $height, function ($con) {
            $con->aspectRatio();
        });
        $Image->save($file_path);

        $webp = $folder . '/' . $name . '.webp';
        if (File::isFile($file_path)):
            File::copy($file_path, $webp);
            File::delete($file_path);
            $result = $webp;
        endif;
        return $result;
    }

    /*
     * Upload
     * */
    public function upload()
    {
        $result   = false;
        $realPath = $this->driver == 's3' ? $this->main_folder : public_path($this->main_folder);
        /*
         * Yuklenecek melumatin olub olmamasini
         * yoxlayiriq
         * */
        if ($this->file):
            /*
             * Yuklenece melumatin deyerini
             * teyin edirik
             * */
            $tmp = $this->file;
            /*
             * Gelen deyerin base64 formatinda
             * olmasini yoxlayiriq ve base64 formatina
             * gore deyeri deyisirik
             * */
            if ($this->base64)
                $tmp = file_get_contents($this->file);
            /*
             * Gelen deyerin url tipinde olmasini
             * yoxlayiriq. Url formatinda olduqda hemin
             * formata uygun deyeri deyisirik
             * */
            else if ($this->url)
                $tmp = helperFileGetContent($this->file);

            /*
             * Sekilin yuklenece qovluqunu
             * teyin edirik
             * */
            $explodePath = explode('/', $this->path);
            $path        = '';
            foreach ($explodePath as $pt):
                $path .= '/' . $pt;
                if ($this->driver == 's3'):
                    if (!Storage::exists($realPath . $path)):
                        Storage::makeDirectory($realPath . $path);
                    endif;
                else:
                    if (!File::isDirectory($realPath . $path)):
                        File::makeDirectory($realPath . $path);
                    endif;
                endif;
            endforeach;

            /*
             * Sekil yukleme prosessini basladiriq
             * */
            if ($this->base64):
                $pos  = strpos($this->file, ';');
                $mime = explode(':', substr($this->file, 0, $pos))[1];
                if ($mime === 'image/svg+xml'):
                    $image_parts       = explode(";base64,", $this->file);
                    $image_base64      = base64_decode($image_parts[1]);
                    $name              = $this->name ? str()->slug($this->name) : str_shuffle(str_random(20) . time());
                    $nameWithExtension = $name . '.svg';
                    $file_path         = $path . '/' . $nameWithExtension;
                    if ($this->driver == 's3'):
                        $upload = Storage::put($realPath . $file_path, $image_base64);
                    else:
                        $upload = file_put_contents($realPath . $file_path, $image_base64);
                    endif;
                    if ($upload):
                        return $nameWithExtension;
                    endif;
                endif;
            endif;
            /*
             * Sekil yukleme prosessini basladiriq
             * */
            $Image = Image::make($tmp);
            if ($this->rotate)
                $Image = $Image->rotate($this->rotate);
            /*
             * Deyerin base64 ve ya url formatinda
             * olmasini yoxlayiriq ve sekilin uzantisini
             * bu deyerlere esasen tapiriq
             * */
            if ($this->base64 || $this->url):
                $mime = $Image->mime();
                if ($mime == 'image/gif')
                    $extension = 'gif';
                else if ($mime == 'image/jpeg')
                    $extension = 'jpg';
                else if ($mime == 'image/png')
                    $extension = 'png';
                else
                    $extension = 'jpg';
            /*
             * Sekilin esas formatinda oldugunu tapib
             * ona uygun uzantisini aliriq
             * */
            else:
                $extension = $this->file->getClientOriginalExtension();
            endif;
            /*
             * Sekilin yuklene bilecek formatlarini
             * qeyd edirik
             * */
            $formats = $this->formats ? $this->formats : ['jpg', 'png', 'gif'];
            /*
             * Sekilin qeyd etdiyimiz formatlarada olub
             * olmamasini yoxlayiriq
             * */
            if (@in_array($extension, $formats)):
                /*
                 * Sekilin adini teyin ediirk
                 * */
                $name              = $this->name ? str()->slug($this->name) : str_shuffle(str_random(20) . time());
                $nameWithExtension = $name . '.' . $extension;
                /*
                 * Sekilin olculerini teyin edirik
                 * */
                $width  = @$this->size['width'] ? $this->size['width'] : $Image->width();
                $height = @$this->size['height'] ? $this->size['height'] : $Image->height();
                /*
                 * Sekili verdiyimiz deyerlere gore
                 * olculendirib ve yukleyirik
                 * */
                $file_path = $path . '/' . $nameWithExtension;
                /*
                 * Sekile uzerine watermark yazmaq istredikde
                 * asagdaki kodlar isleyir
                 * */
                if ($this->watermark && $this->watermark['name']):
                    $resize         = round($width * ((100 - $this->watermark['resize']) / 100), 2);
                    $watermark_path = public_path('/uploads/photos/setting/' . $this->watermark['name']);
                    $watermark      = Image::make($watermark_path);
                    $watermark      = $watermark->resize($resize, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $Image          = $Image->insert($watermark, $this->watermark['position'], $this->watermark['x'], $this->watermark['y']);
                endif;
                $Image = $Image->resize($width, $height);
                if ($this->driver == 's3'):
                    $upload = Storage::put($realPath . $file_path, $Image->encode());
                else:
                    $upload = $Image->save($realPath . $file_path);
                endif;
                /*
                 * Sekil yuklendikde asagdaki sert
                 * isleyecek
                 * */
                if ($upload):
                    /*
                     * Sekilin thumbnail olculerde-de yuklenmesini
                     * istedikde islyecek kodlar
                     * */
                    if ($this->thumbnail)
                        $this->simple_upload($tmp, $path, $name, $extension, $this->thumbnail['width'], $this->thumbnail['height'], 'thumbnail', $this->rotate);
                    /*
                     * Sekilin medium olculerde-de yuklenmesini
                     * istedikde islyecek kodlar
                     * */
                    if ($this->medium)
                        $this->simple_upload($tmp, $path, $name, $extension, $this->medium['width'], $this->medium['height'], 'medium', $this->rotate);
                    /*
                     * Sekilin large olculerde-de yuklenmesini
                     * istedikde islyecek kodlar
                     * */
                    if ($this->large)
                        $this->simple_upload($tmp, $path, $name, $extension, $this->large['width'], $this->large['height'], 'large', $this->rotate);
                    /*
                     * Sekil yuklendikde silinmesini istediyimiz
                     * sekilin adini yaziriq
                     * */
                    if ($this->remove && ($nameWithExtension !== $this->remove)):
                        $this->delete($path, $this->remove);
                    endif;
                    /*
                     * Geriye sekil adini donuruk
                     * */
                    $result = $nameWithExtension;
                endif;
            endif;
        endif;
        /*
         * Geriye deyer donuruk
         * */
        return $result;
    }

    /*
     * Delete
     * */
    public function delete($path, $name)
    {
        $mainPath = $this->driver == 's3' ? $this->main_folder . '/' : public_path($this->main_folder . '/');
        /*
         * Gelen adi . simvolundan parcalayiri
         * */
        $nameExplode = @explode('.', $name);
        /*
         * Bu method vasitesi ile uzantiyi
         * cixaridiq
         * */
        array_pop($nameExplode);
        /*
         * Seklin adini aliriq
         * */
        $onlyName = implode('', $nameExplode);
        /*
         * Orginal sekili tapib silirik
         * */
        $path = preg_replace('/\/\d{2}-\d{2}-\d{4}/', null, ltrim($path));

        $originalFile = $mainPath . $path . '/' . $name;

        if ($this->driver):
            if (Storage::exists($originalFile)):
                Storage::delete($originalFile);
            endif;
        else:
            if (File::isFile($originalFile)):
                File::delete($originalFile);
            endif;
        endif;

        $subFolder = '{folder}/' . $onlyName;
        if (preg_match('/\d{2}-\d{2}-\d{4}/', $onlyName)):
            $onlyName  = explode('/', $onlyName);
            $subFolder = @$onlyName[0] . '/{folder}/' . @$onlyName[1];
        endif;
        /*
         * Thumbnail sekili tapib silirik
         * */
        $thumbnailFile = $mainPath . $path . '/' . str_replace('{folder}', 'thumbnail', $subFolder) . '.webp';
        if ($this->driver):
            if (Storage::exists($thumbnailFile)):
                Storage::delete($thumbnailFile);
            endif;
        else:
            if (File::isFile($thumbnailFile)):
                File::delete($thumbnailFile);
            endif;
        endif;
        /*
         * Medium sekili tapib silirik
         * */
        $mediumFile = $mainPath . $path . '/' . str_replace('{folder}', 'medium', $subFolder) . '.webp';
        if ($this->driver):
            if (Storage::exists($mediumFile)):
                Storage::delete($mediumFile);
            endif;
        else:
            if (File::isFile($mediumFile)):
                File::delete($mediumFile);
            endif;
        endif;
        /*
         * Large sekili tapib silirik
         * */
        $largeFile = $mainPath . $path . '/' . str_replace('{folder}', 'large', $subFolder) . '.webp';
        if ($this->driver):
            if (Storage::exists($largeFile)):
                Storage::delete($largeFile);
            endif;
        else:
            if (File::isFile($largeFile)):
                File::delete($largeFile);
            endif;
        endif;
        return true;
    }

    /*
     * Get Photo
     * */
    public function getPhoto(string $path, $name, $default_photo = 'default_photo.webp')
    {
        $result = [];
        /*
         * Gelen adi . simvolundan parcalayiri
         * */
        $nameExplode = @explode('.', $name);
        /*
         * Bu method vasitesi ile uzantiyi
         * cixaridiq
         * */
        @array_pop($nameExplode);
        /*
         * Seklin adini aliriq
         * */
        $onlyName = @implode('', $nameExplode);

        $realPath = public_path();
        /*
         * Orginal sekili tapiriq
         * */
        $stringPath   = $this->main_folder . '/' . ltrim($path);
        $originalFile = $stringPath . '/' . $name;
        $originalUrl  = $this->driver == 's3' ? Storage::url(ltrim($originalFile, '/')) : url($originalFile);

        if (File::isFile($realPath . $originalFile) || Storage::exists($originalFile)):
            $result['original'] = $originalUrl;
        else:
            $result['original'] = $this->driver == 's3' ? Storage::url(ltrim($this->main_folder, '/') . '/setting/' . $default_photo) : url($this->main_folder . '/setting/' . $default_photo);
        endif;

        /*
         * Sub Folder
         * */
        $sub_folder = preg_match('/\d{2}-\d{2}-\d{4}/', $name);
        if ($sub_folder) {
            preg_match('/\d{2}-\d{2}-\d{4}/', $name, $date);
            $date       = $date[0];
            $stringPath .= '/' . $date;
            $onlyName   = ltrim(preg_replace('/\d{2}-\d{2}-\d{4}/', null, $onlyName), '/');
        }

        /*
         * Thumbnail sekili tapiriq
         * */
        $thumbnailFile = $stringPath . '/thumbnail/' . $onlyName . '.webp';
        $thumbnailUrl  = $this->driver == 's3' ? Storage::url(ltrim($thumbnailFile, '/')) : url($thumbnailFile);
        if (File::isFile($realPath . $thumbnailFile) || Storage::exists($originalFile)):
            $result['thumbnail'] = $thumbnailUrl;
        endif;
        /*
         * Medium sekili tapiriq
         * */
        $mediumFile = $stringPath . '/medium/' . $onlyName . '.webp';
        $mediumUrl  = $this->driver == 's3' ? Storage::url(ltrim($mediumFile, '/')) : url($mediumFile);
        if (File::isFile($realPath . $mediumFile) || Storage::exists($originalFile)):
            $result['medium'] = $mediumUrl;
        endif;
        /*
         * Large sekili tapiriq
         * */
        $largeFile = $stringPath . '/large/' . $onlyName . '.webp';
        $largeUrl  = $this->driver == 's3' ? Storage::url(ltrim($largeFile, '/')) : url($largeFile);
        if (File::isFile($realPath . $largeFile) || Storage::exists($originalFile)):
            $result['large'] = $largeUrl;
        endif;
        return $result;
    }
}
