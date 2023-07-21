<?php
class PhotoDao
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
        $result = $this->conn->query("SELECT * FROM photo");
        if ($result->num_rows == 0) return false;

        $photos = [];
        while ($photo = $result->fetch_assoc()) {
            $photos[] = $photo;
        }
        return $photos;
    }

    public function selectById($photo_id)
    {
        return $this->conn->query("SELECT * FROM photo WHERE photo_id = $photo_id");
    }

    public function selectByAlbum_id($album_id)
    {
        $result = $this->conn->query("SELECT * FROM photo WHERE album_id = $album_id");
        if ($result->num_rows == 0) return false;

        $photos = [];
        while ($photo = $result->fetch_assoc()) {
            $photos[] = $photo;
        }
        return $photos;
    }

    public function selectAlbum($album_id)
    {
        $result = $this->conn->query("SELECT * FROM photo WHERE album_id = $album_id");
        if ($result->num_rows == 0) return false;

        $photos = [];
        while ($photo = $result->fetch_assoc()) {
            $photos[] = $photo;
        }
        return $photos;
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
