<?php

class mysql
{
    private static $context;
    public static function getContext()
    {
        if (!self::$context) {
            self::$context = new mysql();
        }

        return self::$context;
    }

    private $dbh;

    private function connect()
    {
        $this->dbh = mysqli_connect($this->dbhost, $this->user, $this->pass, $this->dbname);
        mysqli_set_charset($this->dbh, 'utf8');
    }

    public function __construct($user = DB_USER, $pass = DB_PASS, $dbhost = DB_HOST, $dbname = DB_NAME)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->dbhost = $dbhost;
        $this->dbname = $dbname;

        $this->connect();
    }

    public function getMysql() {
        return $this->dbh;
    }

    public function execute($query, $param = [])
    {
        try {
            if (!$this->dbh) {
                $this->connect();
            }
            $stmt = $this->setStatement($query, $param);
            if ($stmt != NULL) {
                $stmt->execute();
                $this->result = $stmt->get_result();
            }
        } catch (Exception $e) {
            exit;
        }

        return $this->result;
    }

    private function setStatement($query, $param)
    {
        try {
            $stmt = $this->dbh->prepare($query);
            $ref = new ReflectionClass('mysqli_stmt');
            if (count($param) != 0) {
                $method = $ref->getMethod('bind_param');
                $method->invokeArgs($stmt, $param);
            }
        } catch (Exception $e) {
            if ($stmt != null) {
                $stmt->close();
            }
        }
        return $stmt;
    }

    public function fetch_result()
    {
        if (!$this->result) {
            die();
        }

        $row = mysqli_fetch_assoc($this->result);

        return $row;
    }
}
