<?php
class AlbumDao
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
        return $this->conn->query("
            SELECT * FROM album
            INNER JOIN client ON client.client_id = album.client_id
        ");
    }
    public function selectById($album_id)
    {
        return $this->conn->query("SELECT * FROM album WHERE album_id = $album_id");
    }
    public function insert(
        $album_name,
        $album_descr,
        $category_id,
        $client_id
    ) {
        $album_create = date('Y-m-d H:i:s');
        return $this->conn->query("
            INSERT INTO album SET 
                album_name='$album_name',
                album_descr='$album_descr',
                category_id=$category_id,
                album_create='$album_create',
                client_id='$client_id'
        ");
    }
    public function update(
        $album_name,
        $album_descr,
        $category_id,
        $client_id,
        $album_id
    ) {
        return $this->conn->query("
            UPDATE album SET 
                album_name='$album_name',
                album_descr='$album_descr',
                category_id=$category_id,
                client_id='$client_id'
            WHERE album_id = $album_id 
        ");
    }
    public function delete($album_id)
    {
        return $this->conn->query("DELETE FROM album WHERE album_id = $album_id ");
    }
}
