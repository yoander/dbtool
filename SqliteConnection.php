<?php

namespace DB;

require 'Connection.php';

class SqliteConnection extends Connection
{

    private $dbFile = '';

    protected function __construct()
    {
        parent::__construct(ConnectionProperties::SQLITEDRV);
    }

    private function __clone() {}

    protected function init()
    {
        if (!isset($this->properties['db_file'])) {
            throw new ConnectionException('db_file property is required');
        }

        $this->dbFile = $this->properties['db_file'];

        if (':memory:' !== $this->dbFile) {
            if (!file_exists($this->dbFile)) {
                $this->createDBFile();
            } else if (!is_writable($this->dbFile)) {
                throw new ConnectionException($this->dbFile . ' is not writeable!');
            }
        }

        $this->dsn = 'sqlite:' . $this->dbFile;
    }

	public function createDBFile()
	{
        touch($this->dbFile);
    }

    

    public static function getInstance()
    {
        print_r(get_called_class());
        
        /*if (null === self::$instance) {
            self::$instance = new get_called_class();
        }
        return self::$instance;*/
    }
    
    public function fetchAll()
    {
        return $this->sth->fetchAll();
    }

    public function fetchOne()
    {
        return $this->sth->fetchObject();
    }

    public function dropTable($tableName)
    {
        $this->query("DROP TABLE IF EXISTS $tableName");
    }

}

