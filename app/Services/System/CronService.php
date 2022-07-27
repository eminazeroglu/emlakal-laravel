<?php

namespace App\Services\System;

/*
 * /usr/bin/php /usr/www/users/ftp_name/folder_name/laravel/artisan schedule:run
 * Serverde cron-un islemesi linki
 * */

/*
 * Cron Service
 *
 * */

class CronService
{
    public function __invoke()
    {
        self::backup();
    }

    /*
     * Backup
     * */
    public static function backup()
    {
        $backup = new BackupService();
        $backup->showTables();
        return true;
    }
}
