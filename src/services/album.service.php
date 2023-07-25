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
            'data' => getAlbumsFolder('./albums/')
        ]);
    }

    public static function optimizeAlbum($DATA, $album_id)
    {
        ob_end_flush();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: text/event-stream');

        $result = [
            'progress' => 0,
            'message' => 'Optimizando imágenes...',
            'status' => 'processing',
        ];

        $adapter = $DATA['mysqlAdapter'];
        $albumDao = new AlbumDao($adapter);
        $album = $albumDao->selectById($album_id);

        if (!$album) {
            $result['message'] = 'Album not found';
            $result['status'] = 'error';
            echo "data: " . json_encode($result) . "\n\n";
            exit();
        }

        $_PATH_FOLDER = './albums/' . $album['album_path'] . "/"; //path to folder with images
        $_PATH_FOLDER_OPTIMIZED = './public/img.album.optimized/' . $album['album_path'] . "/"; //path to folder with optimized images
        $images = getFiles($_PATH_FOLDER); // Get all images from folder
        if (!file_exists($_PATH_FOLDER_OPTIMIZED)) mkdir($_PATH_FOLDER_OPTIMIZED);

        foreach ($images as $i => $image) {
            $progress = floor(($i / count($images)) * 100);
            $result['progress'] = $progress;
            $result['message'] = 'Optimizando imagen #' . $i . ' de ' . (count($images) + 1) . '...';
            echo "data: " . json_encode($result) . "\n\n";
            ob_flush();
            flush();
            usleep(200000); // Pausa durante un cuarto de segundo (250 milisegundos)
            $path_folder_origin = $_PATH_FOLDER . $image;
            $path_folder_optimized = $_PATH_FOLDER_OPTIMIZED . $image;
            if (file_exists($path_folder_optimized)) continue;
            optimizeImage($path_folder_origin, $path_folder_optimized);
        }

        $result['progress'] = 100;
        $result['message'] = 'Imágenes optimizadas correctamente.';
        $result['status'] = 'success';
        echo "data: " . json_encode($result) . "\n\n";
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
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $albumDao = new albumDao($adapter);
        $result = [
            'status' => 'error',
            'message' => 'Data not found',
            'response' => false,
            'data' => null
        ];
        if (!isset(
            $_POST['album_id'],
            $_POST['album_photo_name'],
            $_POST['pick']
        )) {
            echo json_encode($result);
            exit();
        }
        $album_id = $_POST['album_id'];
        $album_photo_name = $_POST['album_photo_name'];
        $pick = $_POST['pick'];

        $album = $albumDao->selectById($album_id);

        if (!$album) {
            $result['message'] = 'Album not found';
            echo json_encode($result);
            exit();
        }

        $album_photos_picked = json_decode($album['album_photos_picked'], true);

        if ($pick == 'true') {
            if (!in_array($album_photo_name, $album_photos_picked)) {
                array_push($album_photos_picked, $album_photo_name);
            }
        } else {
            if (in_array($album_photo_name, $album_photos_picked)) {
                $album_photos_picked = array_diff($album_photos_picked, [$album_photo_name]);
            }
        }
        $query_rs = $albumDao->updatePicked($album_id, json_encode($album_photos_picked));
        if (!$query_rs) {
            $result['message'] = 'Error updating album';
            echo json_encode($result);
            exit();
        }

        $result['status'] = 'success';
        $result['message'] = 'Album updated successfully';
        $result['response'] = true;
        $result['data'] = $album_photos_picked;
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
