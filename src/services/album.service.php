<?php
class AlbumService
{

    public static function select($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $albumDao = new AlbumDao($adapter);
        $albums = $albumDao->select();
        echo json_encode([
            'status' => 'success',
            'message' => 'albums obtained successfully',
            'response' => true,
            'data' => $albums
        ]);
    }

    public static function selectById($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $albumDao = new AlbumDao($adapter);

        if (empty($_POST['album_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'album_id is required',
                'response' => false,
                'data' => null
            ]);
            exit();
        }

        $album_id = $_POST['album_id'];

        $albums = $albumDao->selectById($album_id);
        echo json_encode([
            'status' => 'success',
            'message' => 'albums obtained successfully',
            'response' => true,
            'data' => $albums
        ]);
    }

    public static function getFolders($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        echo json_encode([
            'status' => 'success',
            'message' => 'folders obtained successfully',
            'response' => true,
            'data' => getAlbumsFolder()
        ]);
    }

    public static function optimizeImage($DATA, $folder, $photo_name)
    {
        header('Access-Control-Allow-Origin: *');
        $photo_mime = "image/jpeg";
        $photo_quality = 200;
        $photo_size = 400;
        $path = "./albums/" . $folder . "/" . $photo_name;
        if (isset($_GET['photo_quality'])) $photo_quality = $_GET['photo_quality'];
        if (isset($_GET['photo_size'])) $photo_size = $_GET['photo_size'];

        if (file_exists($path)) {
            $photo_mime = getMimeFromPath($path);
            list($width, $height, $type, $attr) = getimagesize($path);
            $base64 = getBase64($path);
            $base64 = qualityBase64img($base64, $photo_mime, $photo_quality);
            if ($width >= $height) {
                $base64 = resizeBase64andScaleHeight($base64, $photo_mime, $photo_size);
            } else {
                $base64 = resizeBase64andScaleWidth($base64, $photo_mime, $photo_size);
            }
            ob_start();
            header("Content-type: $photo_mime");
            echo base64_decode($base64);
        } else {
            ob_start();
            header("Content-type: image/gif");
            readfile($DATA['http_domain'] . "view/img/notfound.gif");
        }
    }

    public static function insert($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $result = [
            'status' => 'error',
            'message' => 'Data not found',
            'response' => false,
            'data' => null
        ];
        if (isset(
            $_POST['album_name'],
            $_POST['album_descr'],
            $_POST['album_path'],
            $_POST['category_id'],
            $_POST['client_id']
        )) {
            $albumDao = new albumDao($adapter);

            $album_name = $_POST['album_name'];
            $album_descr = $_POST['album_descr'];
            $album_path = $_POST['album_path'];
            $category_id = $_POST['category_id'];
            $client_id = $_POST['client_id'];

            $album_photo = "default.png";
            if (isset($_FILES['album_photo'])) {
                if ($_FILES['album_photo']['tmp_name'] != "" or $_FILES['album_photo']['tmp_name'] != null) {
                    $album_photo = uploadFIle($_FILES['album_photo'], './public/img.albums/');
                }
            };

            $album = $albumDao->insert(
                $album_name,
                $album_descr,
                $album_photo,
                $album_path,
                $category_id,
                $client_id
            );
            $result['status'] = 'success';
            $result['message'] = 'Album created successfully';
            $result['response'] = true;
            $result['data'] = $album;
        }
        echo json_encode($result);
    }

    public static function update($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $result = [
            'status' => 'error',
            'message' => 'Data not found',
            'response' => false,
            'data' => null
        ];
        if (isset(
            $_POST['album_name'],
            $_POST['album_descr'],
            $_POST['album_path'],
            $_POST['category_id'],
            $_POST['client_id'],
            $_POST['album_id']
        )) {
            $albumDao = new albumDao($adapter);

            $album_id = $_POST['album_id'];
            $current_album = $albumDao->selectById($album_id);
            if (!$current_album) {
                $result['message'] = 'Album not found';
                echo json_encode($result);
                exit();
            }

            $album_name = $_POST['album_name'];
            $album_descr = $_POST['album_descr'];
            $album_path = $_POST['album_path'];
            $category_id = $_POST['category_id'];
            $client_id = $_POST['client_id'];
            $album_id = $_POST['album_id'];
            $album_photo = $current_album['album_photo'];
            if (isset($_FILES['album_photo'])) {
                if ($_FILES['album_photo']['tmp_name'] != "" or $_FILES['album_photo']['tmp_name'] != null) {
                    if ($album_photo != 'default.png' && $album_photo != '') deleteFile('./public/img.albums/' . $album_photo);
                    $album_photo = uploadFIle($_FILES['album_photo'], './public/img.albums/');
                }
            }
            $album = $albumDao->update(
                $album_name,
                $album_descr,
                $album_photo,
                $album_path,
                $category_id,
                $client_id,
                $album_id
            );
            $result['status'] = 'success';
            $result['message'] = 'Album updated successfully';
            $result['response'] = true;
            $result['data'] = $album;
        }
        echo json_encode($result);
    }

    public static function pickPhoto($DATA)
    {
        // header('Content-Type: application/json');
        // header('Access-Control-Allow-Origin: *');
        $result = [
            'status' => 'error',
            'message' => 'Data not found',
            'response' => false,
            'data' => null
        ];
        if (!isset(
            $_POST['folder'],
            $_POST['photo'],
            $_POST['pick']
        )) {
            echo json_encode($result);
            exit();
        }
        $folder = $_POST['folder'];
        $photo = $_POST['photo'];
        $extension = pathinfo($photo, PATHINFO_EXTENSION);
        $pick = $_POST['pick']; // true or false
        $path = "./albums/" . $folder . "/" . $photo;
        if (!file_exists($path)) {
            $result['status'] = 'success';
            $result['message'] = 'Photo not found';
            echo json_encode($result);
            exit();
        }

        if ($pick == 'true') {
            if (strpos($photo, "(selected)") !== false) {
                $result['response'] = true;
                $result['status'] = 'success';
                $result['message'] = 'Photo already picked';
                echo json_encode($result);
                exit();
            }
            $new_photo = str_replace("." . $extension, "(selected)." . $extension, $photo);
            rename($path, "./albums/" . $folder . "/" . $new_photo);
            $result['response'] = true;
            $result['message'] = 'Photo picked successfully';
            $result['data'] = $new_photo;
            echo json_encode($result);
            exit();
        }

        if (strpos($photo, "(selected)") !== false) {
            $new_photo = str_replace("(selected)." . $extension, "." . $extension, $photo);
            rename($path, "./albums/" . $folder . "/" . $new_photo);
            $result['response'] = true;
            $result['message'] = 'Photo unpicked successfully';
            $result['data'] = $new_photo;
            echo json_encode($result);
            exit();
        }
        $result['response'] = true;
        $result['status'] = 'success';
        $result['message'] = 'Photo already unpicked';
        echo json_encode($result);
    }

    public static function delete($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $result = [
            'status' => 'error',
            'message' => 'Data not found',
            'response' => false,
            'data' => null
        ];
        if (isset($_POST['album_id'])) {
            $albumDao = new albumDao($adapter);
            $album_id = $_POST['album_id'];
            $album = $albumDao->selectById($album_id);
            if (!$album) {
                $result['message'] = 'Album not found';
                echo json_encode($result);
                exit();
            }
            if ($album['album_photo'] != 'default.png' && $album['album_photo'] != '') {
                deleteFile('./public/img.albums/' . $album['album_photo']);
            }
            $albumDao->delete($album_id);
            $result['status'] = 'success';
            $result['message'] = 'Album deleted successfully';
            $result['response'] = true;
        }
        echo json_encode($result);
    }
}
