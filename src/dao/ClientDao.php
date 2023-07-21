<?php
class ClientDao
{
    private MysqlAdapter $conn;
    public function __construct(MysqlAdapter $mysqlAdapter)
    {
        $this->conn = $mysqlAdapter;
    }

    public function getLastId()
    {
        return $this->conn->getLastId();
    }

    public function select()
    {
        $result =  $this->conn->query("SELECT * FROM client");
        if (mysqli_num_rows($result) == 0) return false;
        $returns = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $returns[] = $row;
        }
        return $returns;
    }

    public function selectById($client_id)
    {
        $result = $this->conn->query("SELECT * FROM client WHERE client_id = $client_id");
        if (mysqli_num_rows($result) == 0) return false;
        return mysqli_fetch_assoc($result);
    }

    public function insert(
        $client_name,
        $client_phone,
        $client_fb,
        $client_mail,
        $client_descr,
        $client_photo
    ) {
        $client_create = date('Y-m-d H:i:s');
        $result = $this->conn->query("
            INSERT INTO client SET 
                client_name='$client_name',
                client_phone='$client_phone',
                client_fb='$client_fb',
                client_mail='$client_mail',
                client_descr='$client_descr',
                client_create='$client_create',
                client_photo='$client_photo'
        ");
        if (!$result) return false;
        return $this->getLastId();
    }

    public function update(
        $client_name,
        $client_phone,
        $client_fb,
        $client_mail,
        $client_descr,
        $client_photo,
        $client_id
    ) {
        $result = $this->conn->query("
            UPDATE client SET 
                client_name='$client_name',
                client_phone='$client_phone',
                client_fb='$client_fb',
                client_mail='$client_mail',
                client_descr='$client_descr',
                client_photo='$client_photo'
            WHERE client_id = $client_id 
        ");
        if (!$result) return false;
        return true;
    }

    public function delete($client_id)
    {
        $result = $this->conn->query("DELETE FROM client WHERE client_id = $client_id ");
        if (!$result) return false;
        return true;
    }
}
