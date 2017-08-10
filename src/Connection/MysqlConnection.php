<?php
namespace Cac\SimpleBase\Connection;

class MysqlConnection
{
    private $dbName = null, $dbHost = null, $dbPass = null, $dbUser = null,$dbh = null;
    private static $instance = null;

    private function __construct($dbDetails = array()) {

        // Please note that this is Private Constructor

        $this->dbName = $dbDetails['dbname'];
        $this->dbHost = $dbDetails['host'];
        $this->dbUser = $dbDetails['username'];
        $this->dbPass = $dbDetails['password'];

        $db = "mysql:host=".$this->dbHost.";dbname=".$this->dbName.";charset=utf8";
        // Your Code here to connect to database //
        $options = array(
            \PDO::ATTR_ERRMODE       => \PDO::ERRMODE_EXCEPTION,
        );
        // Create a new PDO instanace
        $this->dbh = new \PDO($db, $this->dbUser, $this->dbPass, $options);
    }

    /**
     * @return MysqlConnection|null
     */
    public static function connect($dbDetails = array()) {

        // Check if instance is already exists
        if(self::$instance == null) {
            self::$instance = new MysqlConnection($dbDetails);
        }
        return self::$instance;
    }

    /**
     * @return null|\PDO
     */
    public function open()
    {
        return $this->dbh;
    }


    private function __clone() {
        // Stopping Clonning of Object
    }

    private function __wakeup() {
        // Stopping unserialize of object
    }
}
