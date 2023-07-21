<?php
class PhotoService
{

    public static function select($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $photoDao = new PhotoDao($adapter);
        $photos = $photoDao->select();
        echo json_encode([
            'status' => 'success',
            'message' => 'photos obtained successfully',
            'response' => true,
            'data' => $photos
        ]);
    }

    public static function optimizeImage($DATA)
    {
        header('Access-Control-Allow-Origin: *');
        $photo_mime = "image/jpeg";
        $photo_name = "notfound.gif";
        $photo_quality = 200;
        $photo_size = 400;
        $path = "./public/img/photo/";
        if (!isset(
            $_GET['photo_name'],
        )) {
            ob_start();
            header("Content-type: $photo_mime");
            readfile($path . $photo_name);
            exit();
        }
        if (isset($_GET['photo_quality'])) $photo_quality = $_GET['photo_quality'];
        if (isset($_GET['photo_size'])) $photo_size = $_GET['photo_size'];
        $photo_name = $_GET['photo_name'];
        $path = "./public/img/photo/" . $photo_name;

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

    public static function updateLike($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $photoDao = new PhotoDao($adapter);

        if (!isset(
            $_POST['photo_like'],
            $_POST['photo_id']
        )) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data not found',
                'response' => false,
                'data' => null
            ]);
            exit();
        }

        $photo_like = $_POST['photo_like'];
        $photo_id = $_POST['photo_id'];
        $photoDao->updateLike(
            $photo_like,
            $photo_id
        );
        echo json_encode([
            'status' => 'success',
            'message' => 'photo updated successfully',
            'response' => true,
            'data' => $photo_like . " => " . ($photo_like ? 'like' : 'unlike')
        ]);
    }



    // public static function insert($DATA)
    // {
    //     header('Content-Type: application/json');
    //     header('Access-Control-Allow-Origin: *');
    //     $adapter = $DATA['mysqlAdapter'];
    //     $result = [
    //         'status' => 'error',
    //         'message' => 'Data not found',
    //         'response' => false,
    //         'data' => null
    //     ];
    //     if (isset(
    //         $_POST['user_name'],
    //         $_POST['user_user'],
    //         $_POST['user_pass']
    //     )) {
    //         $photoDao = new photoDao($adapter);
    //         $user_name = $_POST['user_name'];
    //         $user_user = $_POST['user_user'];
    //         $user_pass = $_POST['user_pass'];
    //         $user_photo = "default.png";
    //         if (isset($_FILES['user_photo'])) {
    //             if ($_FILES['user_photo']['tmp_name'] != "" or $_FILES['user_photo']['tmp_name'] != null) {
    //                 $user_photo = uploadFIle($_FILES['user_photo'], './public/img.photos/');
    //             }
    //         };
    //         $user = $photoDao->insert(
    //             $user_name,
    //             $user_user,
    //             $user_pass,
    //             $user_photo
    //         );
    //         $result['status'] = 'success';
    //         $result['message'] = 'User created successfully';
    //         $result['response'] = true;
    //         $result['data'] = $user;
    //     }
    //     echo json_encode($result);
    // }

    // public static function update($DATA)
    // {
    //     header('Content-Type: application/json');
    //     header('Access-Control-Allow-Origin: *');
    //     $adapter = $DATA['mysqlAdapter'];
    //     $result = [
    //         'status' => 'error',
    //         'message' => 'Data not found',
    //         'response' => false,
    //         'data' => null
    //     ];
    //     if (isset(
    //         $_POST['user_name'],
    //         $_POST['user_user'],
    //         $_POST['user_pass'],
    //         $_POST['user_id']
    //     )) {
    //         $photoDao = new photoDao($adapter);

    //         $user_id = $_POST['user_id'];
    //         $current_user = $photoDao->selectById($user_id);
    //         if (!$current_user) {
    //             $result['message'] = 'User not found';
    //             echo json_encode($result);
    //             exit();
    //         }

    //         $user_name = $_POST['user_name'];
    //         $user_user = $_POST['user_user'];
    //         $user_pass = $_POST['user_pass'];
    //         $user_id = $_POST['user_id'];
    //         $user_photo = $current_user['user_photo'];
    //         if (isset($_FILES['user_photo'])) {
    //             if ($_FILES['user_photo']['tmp_name'] != "" or $_FILES['user_photo']['tmp_name'] != null) {
    //                 if ($user_photo != 'default.png' && $user_photo != '') deleteFile('./public/img.photos/' . $user_photo);
    //                 $user_photo = uploadFIle($_FILES['user_photo'], './public/img.photos/');
    //             }
    //         }
    //         $user = $photoDao->update(
    //             $user_name,
    //             $user_user,
    //             $user_pass,
    //             $user_photo,
    //             $user_id
    //         );
    //         $result['status'] = 'success';
    //         $result['message'] = 'User updated successfully';
    //         $result['response'] = true;
    //         $result['data'] = $user;
    //     }
    //     echo json_encode($result);
    // }

    // public static function delete($DATA)
    // {
    //     header('Content-Type: application/json');
    //     header('Access-Control-Allow-Origin: *');
    //     $adapter = $DATA['mysqlAdapter'];
    //     $result = [
    //         'status' => 'error',
    //         'message' => 'Data not found',
    //         'response' => false,
    //         'data' => null
    //     ];
    //     if (isset($_POST['user_id'])) {
    //         $photoDao = new photoDao($adapter);
    //         $user_id = $_POST['user_id'];
    //         $user = $photoDao->selectById($user_id);
    //         if (!$user) {
    //             $result['message'] = 'User not found';
    //             echo json_encode($result);
    //             exit();
    //         }
    //         if ($user['user_photo'] != 'default.png' && $user['user_photo'] != '') {
    //             deleteFile('./public/img.photos/' . $user['user_photo']);
    //         }
    //         $photoDao->delete($user_id);
    //         $result['status'] = 'success';
    //         $result['message'] = 'User deleted successfully';
    //         $result['response'] = true;
    //     }
    //     echo json_encode($result);
    // }
}
