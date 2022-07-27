<?php

namespace App\Services\System;

/*
 * File Upload Service
 *
 * */

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    private $main_folder = 'files';
    private $path;
    private $name;
    private $base64;
    private $formats;
    private $remove;
    private $file;

    public function __construct($file = null)
    {
        $this->file = $file;
    }

    /*
     * File
     * */
    public function setFile($val)
    {
        $this->file = $val;
        return $this;
    }

    /*
     * Path
     * */
    public function setPath($val)
    {
        $this->path = $val;
        return $this;
    }

    /*
     * Formats
     * */
    public function setFormats(array $val)
    {
        $this->formats = $val;
        return $this;
    }

    /*
     * Name
     * */
    public function setName($val)
    {
        $this->name = $val;
        return $this;
    }

    /*
     * Base64
     * */
    public function setBase64($val)
    {
        $this->base64 = $val;
        return $this;
    }

    /*
     * Remove File
     * */
    public function setRemoveFile($val)
    {
        $this->remove = $val;
        return $this;
    }

    /*
     * Upload
     * */
    public function upload()
    {
        $result = null;
        $base64 = $this->base64 ? $this->base64 : false;
        $tmp = $this->file;
        /*
         * Bu hissede faylin uzantisini aliriq
         * */
        $extension = !$base64 ? @$tmp->getClientOriginalExtension() : null;
        $extension = $extension ? $extension : null;
        if ($base64):
            $tmpExplode = @explode('##@##', $this->file);
            $tmp = @file_get_contents($tmpExplode[1]);
            $extension = @$tmpExplode[0] ? $tmpExplode[0] : null;
        endif;
        /*
         * Yuklene bilecek faylin formatlarini
         * qeyd edirik
         * */
        $formats = $this->formats ? $this->formats : ['doc', 'pdf', 'xls', 'xlsx', 'ppt'];
        /*
         * Faylin formatinin bizim qeyd etdiyimiz
         * formatlara uygunlugunu yoxlayiriq
         * */
        if (@in_array($extension, $formats)):
            /*
             * Faylin yukleneceyi qovluqu teyin edirik
             * */
            $path = $this->path ? $this->path : 'default_folder';
            $upload_folder = $this->main_folder . '/' . $path;
            /*
             * Faylin adini teyin edirik
             * */
            $name = $this->name ? $this->name : str_random(25);
            $name = $name . '.' . $extension;
            /*
             * Fayl base64 formatinda geldikde
             * asagdaki serte uygun yukleyirik
             * */
            $upload_folder = $upload_folder . '/' . $name;
            $upload = Storage::put($upload_folder, $tmp);
            if ($upload):
                $result = $name;
            endif;
            /*
             * Fayl yuklendikde silinmesini istediyimiz
             * kohne fayli yoxlayiriq varsa silirik
             * */
            if ($this->remove)
                $this->delete($path, $this->remove);
        endif;
        /*
         * Geriye deyer donuruk
         * */
        return $result;
    }

    /*
     * Delete
     * */
    public function delete($path, $name, $folder = 'files')
    {
        /*
         * Faylin yolunu qeyd edirik
         * */
        $file = $this->main_folder . '/' . $path . '/' . $name;
        /*
         * Qeyd etdiyimiz fayl movcutdursa hemin
         * fayli silirk.
         * */
        if (Storage::exists($file)):
            Storage::delete($file);
        endif;
        return true;
    }

    /*
     * Get File
     * */
    public function getFile($path, $name, $type = 'link')
    {
        /*
         * Qovluqu / simvolundan bolub sondaki
         * deyeri aliriq ve bu deyeri link yaradanda
         * istifade edirik
         * */
        $main_folder = $this->main_folder . '/' . $path . '/' . $name;
        $main_link = Storage::url($main_folder);

        /*
         * Geriye deyer donuruk
         * */
        return $type === 'folder' ? $main_folder : $main_link;
    }
}
