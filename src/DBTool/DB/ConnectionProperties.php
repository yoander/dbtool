<?php

namespace DBTool\DB;

require_once 'DriverOptions.php';

class ConnectionProperties
{

    private static function getConnection($connections, $connectionName = null) 
    {
		
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
						DriverOptions::ERRMODE => DriverOptions::ERRMODE_EXCEPTION
					]
				),
				'connection2' => array(
					'db_file' => dirname(__FILE__) . '/resources/sqlite-2.db',
					'create_dbfile' => true, // Try to create db_file if no exists
					'attributes' => [
						DriverOptions::ERRMODE => DriverOptions::ERRMODE_EXCEPTION
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
            case DriverOptions::MYSQLDRV:
                return self::mysql($connectionName);

            case DriverOptions::SQLITEDRV;
                return self::sqlite($connectionName);

            default:
                return array();
        }
    }
}
