<?php
class UserService
{
    public static function login($DATA)
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
            $_POST['user_user'],
            $_POST['user_pass']
        )) {
            $result['message'] = 'User or password incorrect';
            $userDao = new UserDao($adapter);
            $user_user = $_POST['user_user'];
            $user_pass = $_POST['user_pass'];
            $user_r = $userDao->login($user_user, addslashes($user_pass));
            if (count($user_r) > 0) {
                if (
                    $user_r['user_user'] == $user_user and
                    $user_r['user_pass'] == $user_pass
                ) {
                    $_SESSION['user_id'] = $user_r['user_id'];
                    $_SESSION['user_name'] = $user_r['user_name'];
                    $_SESSION['user_user'] = $user_r['user_user'];
                    $_SESSION['user_pass'] = $user_r['user_pass'];
                    $_SESSION['user_type'] = $user_r['user_type'];
                    $user_r['user_pass'] = null;
                    $result = [
                        'status' => 'success',
                        'message' => 'Welcom to system ' . $user_r['user_name'],
                        'response' => true,
                        'data' => $user_r
                    ];
                }
            }
        }
        echo json_encode($result);
    }

    public static function logout()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        session_destroy();
        echo json_encode([
            'status' => 'success',
            'message' => 'Session closed',
            'response' => true,
            'data' => null
        ]);
        exit();
    }
    public static function select($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $userDao = new UserDao($adapter);
        $users = $userDao->select();
        echo json_encode([
            'status' => 'success',
            'message' => 'Users obtained successfully',
            'response' => true,
            'data' => $users
        ]);
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
            $_POST['user_name'],
            $_POST['user_user'],
            $_POST['user_pass'],
            $_POST['user_type']
        )) {
            $userDao = new UserDao($adapter);

            $user_name = $_POST['user_name'];
            $user_user = $_POST['user_user'];
            $user_pass = $_POST['user_pass'];
            $user_type = $_POST['user_type'];

            $user_photo = "default.png";
            if (isset($_FILES['user_photo'])) {
                if ($_FILES['user_photo']['tmp_name'] != "" or $_FILES['user_photo']['tmp_name'] != null) {
                    $user_photo = uploadFIle($_FILES['user_photo'], './public/img.users/');
                }
            };

            $user = $userDao->insert(
                $user_name,
                $user_user,
                $user_pass,
                $user_type,
                $user_photo
            );

            $result['status'] = 'success';
            $result['message'] = 'User created successfully';
            $result['response'] = true;
            $result['data'] = $user;
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
            $_POST['user_name'],
            $_POST['user_user'],
            $_POST['user_pass'],
            $_POST['user_type'],
            $_POST['user_id']
        )) {
            $userDao = new UserDao($adapter);

            $user_name = $_POST['user_name'];
            $user_user = $_POST['user_user'];
            $user_pass = $_POST['user_pass'];
            $user_type = $_POST['user_type'];
            $user_id = $_POST['user_id'];

            $current_user = $userDao->selectById($user_id);
            if (!$current_user) {
                $result['message'] = 'User not found';
                echo json_encode($result);
                exit();
            }

            $user_photo = $current_user['user_photo'];
            if (isset($_FILES['user_photo'])) {
                if ($_FILES['user_photo']['tmp_name'] != "" or $_FILES['user_photo']['tmp_name'] != null) {
                    if ($user_photo != 'default.png' && $user_photo != '') deleteFile('./public/img.users/' . $user_photo);
                    $user_photo = uploadFIle($_FILES['user_photo'], './public/img.users/');
                }
            }
            $user = $userDao->update(
                $user_name,
                $user_user,
                $user_pass,
                $user_type,
                $user_photo,
                $user_id
            );
            $result['status'] = 'success';
            $result['message'] = 'User updated successfully';
            $result['response'] = true;
            $result['data'] = $user;
        }
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
        if (isset($_POST['user_id'])) {
            $userDao = new UserDao($adapter);
            $user_id = $_POST['user_id'];
            $user = $userDao->selectById($user_id);
            if (!$user) {
                $result['message'] = 'User not found';
                echo json_encode($result);
                exit();
            }
            if ($user['user_photo'] != 'default.png' && $user['user_photo'] != '') {
                deleteFile('./public/img.users/' . $user['user_photo']);
            }
            $userDao->delete($user_id);
            $result['status'] = 'success';
            $result['message'] = 'User deleted successfully';
            $result['response'] = true;
        }
        echo json_encode($result);
    }
}
