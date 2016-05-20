<?php

namespace DBTool\DB;

abstract class Connection
{

    /**
    *
    * Connection properties
    *
    */
    protected $properties = [];

    /**
    * Data source name
    *
    */
    protected $dsn = null;

    /**
    *
    * Data base handler
    *
    */
    protected $dbh = null;

    /**
    *
    * Stament handler
    *
    */
    protected $sth = null;


    /**
    *
    * Instances storages
    *
    */
    protected static $instances = [];

    protected function __construct($driver, $connectionName = null)
    {

        $this->properties = ConnectionProperties::get($driver, $connectionName);

        if (empty($this->properties)) {
			$this->throwException(new ConnectionException('No Connection properties are defined' . !empty($connectionName) ? ": for $connectioName" : ''));
		}

        $this->init();
        $this->connect();
    }

    private function __clone() {;}

    protected abstract function init();

    public static function getInstance($connectionName = null)
    {
        $className = get_called_class();
        $instanceKey = $className . $connectionName;


        if (!array_key_exists($instanceKey, self::$instances)) {
            self::$instances[$instanceKey] = new $className($connectionName);
        }

        return self::$instances[$instanceKey];
    }

    public function connect()
    {
        try {
            $user = isset($this->properties['user']) ? $this->properties['user'] : null;
            $passwd = isset($this->properties['password']) ? $this->properties['password'] : null;
            $attributes = isset($this->properties['attributes']) ? $this->properties['attributes'] : [];

            $this->dbh = new \PDO($this->dsn, $user, $passwd, $attributes);

            return $this;

        } catch (\PDOException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode());
        }
    }

    public function query($query, $params = null)
    {
       try {
            $this->sth = $this->dbh->prepare($query);
            $this->sth->execute($params);
        } catch (\PDOException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }

        return $this;
    }

    public function getAffectedRows()
    {
		return $this->sth->countRow();
	}

	public function getLastId($name = null)
	{
		return $this->dbh->lastInsertId($name);
	}

    public function fetchAll($className = 'stdClass', $ctorArgs = array())
    {
        return $this->sth->fetchAll($className, $ctorArgs);
    }

    public function fetchOne($className = 'stdClass', $ctorArgs = array())
    {
        return $this->sth->fetchObject();
    }

	public function dump()
	{
		var_dump(self::$instances);
	}

    public abstract function throwException(\Exception $e);
}
