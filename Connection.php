<?php

namespace DB;

require 'ConnectionException.php';
require 'ConnectionProperties.php';

abstract class Connection
{

    protected $properties = [];

    protected $dsn = null;

    protected $dbh = null;

    protected $sth = null;

    protected static $instance = null;

    protected function __construct($driver)
    {
        $this->properties = ConnectionProperties::get($driver);
        $this->init();
        $this->connect();
    }

    protected abstract function init();

    public function connect()
    {
        try {
            $user = isset($this->properties['user']) ? $this->properties['user'] : null;
            $passwd = isset($this->properties['password']) ? $this->properties['password'] : null;
            $attributes = isset($this->properties['attributes']) ? $this->properties['attributes'] : [];

            $this->dbh = new \PDO($this->dsn, $user, $passwd, $attributes);

            return $this;

        } catch (\PDOException $e) {
            throw new ConnectionException($e->getMessage());
        }
    }

    public function query($query, $params = null)
    {
       try {
            $this->sth = $this->dbh->prepare($query);
            //$this->sth->setFetchMode(\PDO::FETCH_CLASS);
            $this->sth->execute($params);
        } catch (\PDOException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }

        return $this;
    }

}
