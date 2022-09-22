<?php
class ClientDao
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
        return $this->conn->query("SELECT * FROM client");
    }
    public function selectById($client_id)
    {
        return $this->conn->query("SELECT * FROM client WHERE client_id = $client_id");
    }
    public function insert(
        $client_name,
        $client_phone,
        $client_fb,
        $client_mail,
        $client_descr
    ) {
        $client_create = date('Y-m-d H:i:s');
        return $this->conn->query("
            INSERT INTO client SET 
                client_name='$client_name',
                client_phone='$client_phone',
                client_fb='$client_fb',
                client_mail='$client_mail',
                client_descr='$client_descr',
                client_create='$client_create'
        ");
    }
    public function update(
        $client_name,
        $client_phone,
        $client_fb,
        $client_mail,
        $client_descr,
        $client_id
    ) {
        return $this->conn->query("
            UPDATE client SET 
                client_name='$client_name',
                client_phone='$client_phone',
                client_fb='$client_fb',
                client_mail='$client_mail',
                client_descr='$client_descr'
            WHERE client_id = $client_id 
        ");
    }
    public function delete($client_id)
    {
        return $this->conn->query("DELETE FROM client WHERE client_id = $client_id ");
    }
}
