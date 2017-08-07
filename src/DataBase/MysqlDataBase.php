<?php
namespace Cac\SimpleBase\DataBase;

use Cac\SimpleBase\Connection\MysqlConnection;

abstract class MysqlDataBase
{
    private $stmt;
    private $params;
    private $query;
    private $db;

    /**
     * MysqlDataBse constructor.
     */
    public function __construct()
    {
        $connect  = MysqlConnection::connect(config('app.database.mysql'));
        $this->db = $connect->open();
    }

    /**
     * @param $query
     * @return $this
     */
    public function query($query)
    {
        $this->query= $this->query.$query;
        $this->stmt = $this->db->prepare($this->query);
        return $this;
    }

    /**
     * @param $param
     * @param $value
     * @return $this
     */
    public function bind($param, $value)
    {
        $this->params[$param] = $value;
        return $this;
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $this->stmt->execute($this->params);
        $this->claerParams();
        $this->claerQuery();
        return $this;
    }

    /**
     * @param null $class
     * @return mixed
     */
    public function results($class = null)
    {
        if (is_object($class)) {
            return $this->execute()
                   ->stmt->fetchAll(\PDO::FETCH_CLASS, get_class($class));
        }
        return $this->execute()->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param null $class
     * @return mixed
     */
    public function single($class = null)
    {
        if (is_object($class)) {
            return $this->execute()
                ->stmt->fetchObject(get_class($class));
        }
        return $this->execute()->stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * @return $this
     */
    public function beginTransaction()
    {
        $this->db->beginTransaction();
        return $this;
    }

    /**
     * @return $this
     */
    public function endTransaction()
    {
        $this->db->commit();
        return $this;
    }

    /**
     * @return $this
     */
    public function cancelTransaction()
    {
        $this->db->rollBack();
        return $this;
    }

    /**
     * @return mixed
     */
    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }

    /***
     * @return mixed
     */
    public function nameColumns()
    {
        return $this->execute()->stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @return $this
     */
    private function claerParams()
    {
        $this->params = [];
        return $this;
    }

    /**
     * @return $this
     */
    private function claerQuery()
    {
        $this->query = '';
        return $this;
    }
}

