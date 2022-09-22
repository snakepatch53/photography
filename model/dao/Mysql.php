<?php
// ini_set('xdebug.max_nesting_level', 200);
class Mysql
{
    private $conn;
    private $last_id;
    private $host;
    private $user;
    private $pass;
    private $name;
    private $port;
    public function __construct($proyect)
    {
        $this->host = $proyect['database.host'];
        $this->user = $proyect['database.user'];
        $this->pass = $proyect['database.pass'];
        $this->name = $proyect['database.name'];
        $this->port = $proyect['database.port'];
    }
    public function query($sql)
    {
        $this->conectar();
        $resultado = mysqli_query($this->conn, $sql);
        $this->last_id = mysqli_insert_id($this->conn);
        $this->desconectar();
        return $resultado;
    }
    public function conectar()
    {
        // $this->conn = mysqli_connect("localhost", "root", "", "lottery", "3306");
        $this->conn = mysqli_connect(
            $this->host,
            $this->user,
            $this->pass,
            $this->name,
            $this->port
        );
        mysqli_set_charset($this->conn, "utf8");
        return $this->conn;
    }
    private function desconectar()
    {
        mysqli_close($this->conn);
    }
    public function getLastId()
    {
        return $this->last_id;
    }
}
