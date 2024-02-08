<?php

class Conexion extends mysqli
{
    private $host = "localhost";
    private $user = "dwes";
    private $pass = "abc123.";
    private $db = "banco_bloqueo";
    public function __construct()
    {
        parent::__construct($this->host, $this->user, $this->pass, $this->db);
    }

    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

?>