<?php
class PhotoDao
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
        return $this->conn->query("SELECT * FROM photo");
    }
    public function selectById($photo_id)
    {
        return $this->conn->query("SELECT * FROM photo WHERE photo_id = $photo_id");
    }
    public function selectAlbum($album_id)
    {
        return $this->conn->query("SELECT * FROM photo WHERE album_id = $album_id");
    }
    public function insert(
        $photo_name,
        $album_id
    ) {
        $photo_create = date('Y-m-d H:i:s');
        return $this->conn->query("
            INSERT INTO photo SET 
                photo_name='$photo_name',
                album_id='$album_id',
                photo_create='$photo_create'
        ");
    }
    public function update(
        $photo_name,
        $album_id,
        $photo_id
    ) {
        return $this->conn->query("
            UPDATE photo SET 
                photo_name='$photo_name',
                album_id='$album_id'
            WHERE photo_id = $photo_id 
        ");
    }
    public function updateLike(
        $photo_like,
        $photo_id
    ) {
        return $this->conn->query("
            UPDATE photo SET 
                photo_like=$photo_like
            WHERE photo_id = $photo_id 
        ");
    }
    public function delete($photo_id)
    {
        return $this->conn->query("DELETE FROM photo WHERE photo_id = $photo_id ");
    }
}
