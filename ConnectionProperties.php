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

    private static function getConnection($connections, $connectionName = null) 
    {
		//print_r(__FUNCTION__);
		
		print_r("COnnection NAME: $connectionName \n");
		
		if (empty($connectionName)) { // Default connection
			
			return reset($connections);
		
		} else if (array_key_exists($connectionName, $connections)) { // Named connection
			
			return $connections[$connectionName];
		
		} else { // Empty properties
			return array();
		
		}
	}
    
    private static function sqlite($connectionName = null)
    {
        return self::getConnection(
			array(
				'default' => array(
					'db_file' => dirname(__FILE__) . '/resources/sqlite.db',
					'create_dbfile' => true, // Try to create db_file if no exists
					'attributes' => [
						self::ERRMODE => self::ERRMODE_EXCEPTION
					]
				),
				'connection2' => array(
					'db_file' => dirname(__FILE__) . '/resources/sqlite-2.db',
					'create_dbfile' => true, // Try to create db_file if no exists
					'attributes' => [
						self::ERRMODE => self::ERRMODE_EXCEPTION
					]
				)
			), 
			$connectionName
		);
    }

    private function mysql($connectionName = null)
    {
        return self::getConnection(
			array(
				'default' => array(
					'host' => 'localhost',
					'port' => '3306',
					'user' => 'root',
					'password' => '',
					'persistent' => true, // Use persistent connection
					'attributes' => [] 
				),
				'connection2' => array(
					'host' => 'prodsrv',
					'port' => '3306',
					'user' => 'root',
					'password' => '',
					'persistent' => true, // Use persistent connection
					'attributes' => [] 
				)
			), 
			$connectionName
		);
    }

    public function get($driver, $connectionName = null)
    {
        switch ($driver) {
            case self::MYSQLDRV:
                return self::mysql($connectionName);

            case self::SQLITEDRV;
                return self::sqlite($connectionName);

            default:
                return array();
        }
    }
}
