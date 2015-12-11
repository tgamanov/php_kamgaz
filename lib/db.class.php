<?php

class DB {
    protected static $_instance;

    protected $connection;

    private  function __construct($host, $user, $password, $db_name)
    {
        $this->connection = new mysqli($host, $user, $password, $db_name);
        mysqli_set_charset($this->connection, "utf-8");
        if (mysqli_connect_error()) {
            throw new DbException('Could not connect to database: '.$host."/".$db_name);
        }
    }

    private function __clone() {}

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new DB(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));
        }
        return self::$_instance;
    }

    public function query($sql) {
        if (!$this->connection) {
            return false;
        }
        $result = $this->connection->query($sql);
        if (mysqli_error($this->connection)) {
            throw new DbException(mysqli_error($this->connection));
        }
        if (is_bool($result)) {
            return $result;
        }

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function escape($str) {
        return mysqli_escape_string($this->connection, $str);
    }


}