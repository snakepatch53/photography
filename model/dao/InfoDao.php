<?php
class InfoDao
{
    private $conn;
    public function __construct($proyect)
    {
        $this->conn = new Mysql($proyect);
    }
    public function getLastId()
    {
        return $this->conn->getLastId();
    }
    public function select()
    {
        return $this->conn->query("SELECT * FROM info");
    }
    public function selectById($info_id)
    {
        return $this->conn->query("SELECT * FROM info WHERE info_id = $info_id");
    }
    public function insert(
        $info_name,
        $info_email,
        $info_services
    ) {
        return $this->conn->query("
            INSERT INTO info SET 
                info_name='$info_name',
                info_email='$info_email',
                info_services='$info_services'
        ");
    }
    public function update(
        $info_name,
        $info_email,
        $info_services
    ) {
        return $this->conn->query("
            UPDATE info SET 
                info_name='$info_name',
                info_email='$info_email',
                info_services='$info_services'
        ");
    }
    public function delete($info_id)
    {
        return $this->conn->query("DELETE FROM info WHERE info_id = $info_id ");
    }
}
