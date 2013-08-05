<?php

namespace DB;

class ConnectionProperties
{

    const MYSQLDRV = 'MYSQLDRV';

    const SQLITEDRV = 'SQLITEDRV';

    const ERRMODE = \PDO::ATTR_ERRMODE;

    const ERRMODE_EXCEPTION = \PDO::ERRMODE_EXCEPTION;

    const ERRMODE_WARNING = \PDO::ERRMODE_WARNING;

    const ERRMODE_SILENT = \PDO::ERRMODE_SILENT;

    private static function sqlite()
    {
        return [
            'db_file' => dirname(__FILE__) . '/../config/sqlite.db',
            'persistent' => true,
            'attributes' => [
                self::ERRMODE => self::ERRMODE_EXCEPTION
            ]
        ];
    }

    private function mysql()
    {
        return [
            'host' => 'localhost',
            'port' => '3306',
            'user' => 'root',
            'password' => '',
            'persistent' => true, // Use persistent connection
            'attributes' => []
        ];
    }

    public function get($driver)
    {
        switch ($driver) {
            case self::MYSQLDRV:
                return self::mysql();

            case self::SQLITEDRV;
                return self::sqlite();

            default:
                return array();
        }
    }
}

