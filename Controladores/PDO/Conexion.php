<?php

class Conexion extends PDO
{
    protected $dns = "mysql:host=localhost;dbname=banco_bloqueo;charset=utf8mb4";
    protected $username = "dwes";
    protected $password = "abc123.";
    protected $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ);
    // PDO::ATTR_CASE => PDO::CASE_LOWER

    public function __construct()
    {
        return parent::__construct($this->dns, $this->username, $this->password, $this->options);
    }
}

?>