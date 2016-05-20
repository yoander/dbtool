<?php

namespace DBTool\DB;

use DBTool\FileSystem\FileSystemException;

require_once 'FileSystemException.php';

class SqliteConnection extends Connection
{

    private $dbFile = '';

    protected function __construct($connectionName = null)
    {
        parent::__construct(DriverOptions::SQLITEDRV, $connectionName);
    }

    protected function init()
    {
        if (!isset($this->properties['db_file'])) {
            throw new ConnectionException('db_file property is required');
        }

        $this->dbFile = $this->properties['db_file'];

        if (':memory:' !== $this->dbFile) {
            if (!file_exists($this->dbFile)) {
                if (array_key_exists('create_dbfile', $this->properties)
					&& $this->properties['create_dbfile']) {
					$this->createDbFile();
				} else {
					throw new FileSystemException($this->dbFile . ' does not exists!');
				}
            } else if (!is_writable($this->dbFile)) {
                throw new FileSystemException($this->dbFile . ' is not writeable!');
            }
        }

        $this->dsn = 'sqlite:' . $this->dbFile;
    }

	public function createDbFile()
	{
		$dir = dirname($this->dbFile);

    if (!is_writable($dir)) {
			throw new FileSystemException('Could not create ' .
				$this->dbFile .
				', ' .
				$dir .
				' must be writable');
		}

        touch($this->dbFile);
    }

    public function throwException(\Exception $e)
    {
        throw new SqliteException($e->getMessage(), $e->getCode(), $e);
    }
}
