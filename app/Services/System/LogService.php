<?php

namespace App\Services\System;

/*
 * Log Service
 *
 * */

use Illuminate\Support\Facades\File;

class LogService
{
    /*
     * Write
     * */
    private function write($name, $message = null, $data = null)
    {
        $file_name = $name . '.log';
        $path = storage_path('logs/' . $file_name);
        $log = [
            'date' => now()->format('Y-m-d H:i:s'),
        ];
        if ($message):
            $log['message'] = $message;
        endif;
        if ($data):
            $log['data'] = $data;
        endif;
        File::append($path, json_encode($log) . "\n");
        return true;
    }

    /*
     * Read
     * */
    public static function read($name)
    {
        $result = [];
        $path = storage_path('logs/' . $name . '.log');
        $file = fopen($path, 'r');
        while (!feof($file)):
            $jsonLine = json_decode(fgets($file), true);
            if ($jsonLine != ''):
                $result[] = $jsonLine;
            endif;
        endwhile;
        return collect($result);
    }

    /*
     * Payment
     * */
    public static function payment($message, $data = null)
    {
        (new LogService)->write('payment', $message, $data);
    }

    /*
     * Info
     * */
    public static function info($message, $data = null)
    {
        (new LogService)->write('info', $message, $data);
    }

    /*
     * Danger
     * */
    public static function danger($message, $data = null)
    {
        (new LogService)->write('danger', $message, $data);
    }

}
