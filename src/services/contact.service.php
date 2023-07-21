<?php
class ContactService
{

    public static function select($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $contactDao = new ContactDao($adapter);
        $contacts = $contactDao->select();
        echo json_encode([
            'status' => 'success',
            'message' => 'contacts obtained successfully',
            'response' => true,
            'data' => $contacts
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
    //         $contactDao = new contactDao($adapter);
    //         $user_name = $_POST['user_name'];
    //         $user_user = $_POST['user_user'];
    //         $user_pass = $_POST['user_pass'];
    //         $user_photo = "default.png";
    //         if (isset($_FILES['user_photo'])) {
    //             if ($_FILES['user_photo']['tmp_name'] != "" or $_FILES['user_photo']['tmp_name'] != null) {
    //                 $user_photo = uploadFIle($_FILES['user_photo'], './public/img.contacts/');
    //             }
    //         };
    //         $user = $contactDao->insert(
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
    //         $contactDao = new contactDao($adapter);

    //         $user_id = $_POST['user_id'];
    //         $current_user = $contactDao->selectById($user_id);
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
    //                 if ($user_photo != 'default.png' && $user_photo != '') deleteFile('./public/img.contacts/' . $user_photo);
    //                 $user_photo = uploadFIle($_FILES['user_photo'], './public/img.contacts/');
    //             }
    //         }
    //         $user = $contactDao->update(
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
    //         $contactDao = new contactDao($adapter);
    //         $user_id = $_POST['user_id'];
    //         $user = $contactDao->selectById($user_id);
    //         if (!$user) {
    //             $result['message'] = 'User not found';
    //             echo json_encode($result);
    //             exit();
    //         }
    //         if ($user['user_photo'] != 'default.png' && $user['user_photo'] != '') {
    //             deleteFile('./public/img.contacts/' . $user['user_photo']);
    //         }
    //         $contactDao->delete($user_id);
    //         $result['status'] = 'success';
    //         $result['message'] = 'User deleted successfully';
    //         $result['response'] = true;
    //     }
    //     echo json_encode($result);
    // }
}
