<?php

namespace App\Services\System;

/*
 * Backup
 *
 * */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BackupService
{
    protected $sql;

    private function dumpTriggers()
    {
        $triggers = DB::select('SHOW TRIGGERS');
        if (count($triggers) > 0) {
            $this->sql .= '-- TRIGGERS (' . count($triggers) . ')' . str_repeat(PHP_EOL, 2);
            $this->sql .= 'DELIMITER //' . PHP_EOL;
            foreach ($triggers as $trigger) {
                $query = collect(DB::select('SHOW CREATE TRIGGER ' . [$trigger['Trigger']]))->toArray();
                $this->sql .= $query['SQL Original Statement'] . '//' . PHP_EOL;
            }
            $this->sql .= 'DELIMITER ;' . str_repeat(PHP_EOL, 5);
        }
    }

    private function dumpFunctions()
    {
        $functions = collect(DB::select('SHOW FUNCTION STATUS WHERE DB = ' . env('DB_DATABASE')))->toArray();
        if (count($functions) > 0) {
            $this->sql .= '-- FUNCTIONS (' . count($functions) . ')' . str_repeat(PHP_EOL, 2);
            $this->sql .= 'DELIMITER //' . PHP_EOL;
            foreach ($functions as $function) {
                $query = collect(DB::select('SHOW CREATE FUNCTION', $function['Name']))->toArray();
                $this->sql .= $query['Create Function'] . '//' . PHP_EOL;
            }
            $this->sql .= 'DELIMITER ;' . str_repeat(PHP_EOL, 5);
        }
    }

    private function dumpProcedures()
    {
        $procedures = collect(DB::select('SHOW PROCEDURE STATUS WHERE Db = ' . env('DB_DATABASE')));
        if (count($procedures) > 0) {
            $this->sql .= '-- PROCEDURES (' . count($procedures) . ')' . str_repeat(PHP_EOL, 2);
            $this->sql .= 'DELIMITER //' . PHP_EOL;
            foreach ($procedures as $procedure) {
                $query = collect(DB::select('SHOW CREATE PROCEDURE ', $procedure['Name']))->toArray();
                $this->sql .= $query['Create Procedure'] . '//' . PHP_EOL;
            }
            $this->sql .= 'DELIMITER ;' . str_repeat(PHP_EOL, 5);
        }
    }

    public function showTables()
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $this->sql .= 'SET FOREIGN_KEY_CHECKS=0;' . PHP_EOL;
            foreach ($tables as $table):
                $tableName = current($table);
                $rows = collect(DB::select('SELECT * FROM ' . $tableName))->toArray();

                $this->sql .= '-- ----------------------------
-- Table structure for ' . $tableName . '
-- ----------------------------' . PHP_EOL;

                $tableDetail = current(DB::select('SHOW CREATE TABLE ' . $tableName));
                $tableDetail = collect($tableDetail)->toArray();
                $this->sql .= 'DROP TABLE IF EXISTS `' . $tableName . '`;' . PHP_EOL;
                $this->sql .= $tableDetail['Create Table'] . ';' . str_repeat(PHP_EOL, 3);

                if (count($rows) > 0) {
                    $columns = collect(DB::select('SHOW COLUMNS FROM ' . $tableName))->map(function ($item) {
                        return $item->Field;
                    })->toArray();

                    $this->sql .= '-- ----------------------------
-- Records of ' . $tableName . '
-- ----------------------------' . PHP_EOL;

                    $this->sql .= 'INSERT INTO `' . $tableName . '` (`' . implode('`,`', $columns) . '`) VALUES' . PHP_EOL;

                    $columnsData = [];
                    foreach ($rows as $row):
                        $row = collect($row)->map(function ($item) {
                            return DB::connection()->getPdo()->quote($item);
                        })->toArray();
                        $columnsData[] = '(' . implode(',', $row) . ')';
                    endforeach;

                    $this->sql .= implode(',' . PHP_EOL, $columnsData) . ';' . str_repeat(PHP_EOL, 5);
                }

                $this->dumpTriggers();

            endforeach;

            $path = storage_path('backup');
            $name = \Carbon\Carbon::now()->format('Y-m-d');
            if (!File::isDirectory($path))
                File::makeDirectory($path);
            $path_name = $path . '/' . $name;
            if (!File::isDirectory($path_name))
                File::makeDirectory($path_name);
            $sql = $path_name . '/mysql.sql';
            if (File::isFile($sql)):
                File::delete($sql);
            endif;
            File::put($sql, $this->sql);

            $uploads = public_path('uploads');
            if (File::isDirectory($uploads)):
                File::copyDirectory($uploads, $path_name . '/uploads');
            endif;

            return [
                'status' => 'success',
                'files' => [
                    'folder' => 'uploads',
                    'file' => 'mysql.sql'
                ]
            ];
        } catch (\Exception $e) {

        }
    }

    /*
     * Backup List
     * */
    public static function backupList()
    {

    }
}
