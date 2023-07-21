<?php
class AlbumDao
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
        $result = $this->conn->query("
            SELECT * FROM album
            INNER JOIN client ON client.client_id = album.client_id
        ");
        if (mysqli_num_rows($result) == 0) return [];

        $albums = [];
        while ($album = $result->fetch_assoc()) {
            $albums[] = $this->schematize($album);
        }
        return $albums;
    }

    public function selectById($album_id)
    {
        $result = $this->conn->query("SELECT * FROM album WHERE album_id = $album_id");
        if (mysqli_num_rows($result) == 0) return false;
        return  $this->schematize(mysqli_fetch_assoc($result));
    }

    public function insert(
        $album_name,
        $album_descr,
        $album_photo,
        $album_path,
        $category_id,
        $client_id,
        $album_photos_picked = '[]'
    ) {
        $album_create = date('Y-m-d H:i:s');
        $result = $this->conn->query("
            INSERT INTO album SET 
                album_name='$album_name',
                album_descr='$album_descr',
                album_create='$album_create',
                album_photo='$album_photo',
                album_path='$album_path',
                category_id=$category_id,
                client_id='$client_id',
                album_photos_picked='$album_photos_picked'
        ");
        if (!$result) return false;
        return $this->selectById($this->getLastId());
    }

    public function update(
        $album_name,
        $album_descr,
        $album_photo,
        $album_path,
        $category_id,
        $client_id,
        $album_id
    ) {
        $result = $this->conn->query("
            UPDATE album SET 
                album_name='$album_name',
                album_descr='$album_descr',
                album_photo='$album_photo',
                album_path='$album_path',
                category_id=$category_id,
                client_id='$client_id'
            WHERE album_id = $album_id 
        ");
        if (!$result) return false;
        return $this->selectById($album_id);
    }

    public function delete($album_id)
    {
        $result = $this->conn->query("DELETE FROM album WHERE album_id = $album_id ");
        if (!$result) return false;
        return true;
    }

    public function schematize($row)
    {
        // frontpage
        $album_photo_url = $_ENV['HTTP_DOMAIN'] . '/public/img.albums/' . $row['album_photo'];
        if (!file_exists('./public/img.albums/' . $row['album_photo'])) {
            $album_photo_url = $_ENV['HTTP_DOMAIN'] . '/public/img/notfound.gif';
        }
        $row['album_photo_url'] = $album_photo_url;

        // photos
        $folders = getAlbumsFolder();
        $album_path = $row['album_path'];
        $album_photos = [];
        foreach ($folders as $folder) {
            if ($folder['folder'] == $album_path) {
                $album_photos = $folder['files'];
                break;
            }
        }
        $new_album_photos = [];
        foreach ($album_photos as $album) {
            $tmp_url = $_ENV['HTTP_DOMAIN'] . 'services/album/get_photo/' . $album_path . '/' . $album;
            if (!file_exists('./albums/' . $album_path . '/' . $album)) {
                $tmp_url = $_ENV['HTTP_DOMAIN'] . '/public/img/notfound.gif';
            }
            $tmp = [
                'id' => md5($album),
                'url' => $tmp_url,
                'folder' => $album_path,
                'name' => $album,
                'picked' => (strpos($album, "(selected)") !== false) ? true : false,
            ];
            $new_album_photos[] = $tmp;
        }
        $row['album_photos'] = $new_album_photos;
        return $row;
    }
}
