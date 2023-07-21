<?php
class ClientService
{
    public static function select($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $clientDao = new ClientDao($adapter);
        $clients = $clientDao->select();
        echo json_encode([
            'status' => 'success',
            'message' => 'Clients obtained successfully',
            'response' => true,
            'data' => $clients
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
        if (!isset(
            $_POST['client_name'],
            $_POST['client_phone'],
            $_POST['client_fb'],
            $_POST['client_mail'],
            $_POST['client_descr']
        )) {
            echo json_encode($result);
            exit();
        }
        $clientDao = new ClientDao($adapter);

        $client_name = $_POST['client_name'];
        $client_phone = $_POST['client_phone'];
        $client_fb = $_POST['client_fb'];
        $client_mail = $_POST['client_mail'];
        $client_descr = $_POST['client_descr'];

        $client_photo = "default.png";
        if (isset($_FILES['client_photo'])) {
            if ($_FILES['client_photo']['tmp_name'] != "" or $_FILES['client_photo']['tmp_name'] != null) {
                $client_photo = uploadFIle($_FILES['client_photo'], './public/img.clients/');
            }
        };

        $client = $clientDao->insert(
            $client_name,
            $client_phone,
            $client_fb,
            $client_mail,
            $client_descr,
            $client_photo
        );

        $result['status'] = 'success';
        $result['message'] = 'Client created successfully';
        $result['response'] = true;
        $result['data'] = $client;

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
            $_POST['client_name'],
            $_POST['client_phone'],
            $_POST['client_fb'],
            $_POST['client_mail'],
            $_POST['client_descr'],
            $_POST['client_id']
        )) {
            $clientDao = new ClientDao($adapter);


            $client_name = $_POST['client_name'];
            $client_phone = $_POST['client_phone'];
            $client_fb = $_POST['client_fb'];
            $client_mail = $_POST['client_mail'];
            $client_descr = $_POST['client_descr'];
            $client_id = $_POST['client_id'];

            $current_client = $clientDao->selectById($client_id);
            if (!$current_client) {
                $result['message'] = 'Client not found';
                echo json_encode($result);
                exit();
            }

            $client_photo = $current_client['client_photo'];
            if (isset($_FILES['client_photo'])) {
                if ($_FILES['client_photo']['tmp_name'] != "" or $_FILES['client_photo']['tmp_name'] != null) {
                    if ($client_photo != 'default.png' && $client_photo != '') deleteFile('./public/img.clients/' . $client_photo);
                    $client_photo = uploadFIle($_FILES['client_photo'], './public/img.clients/');
                }
            }

            $client = $clientDao->update(
                $client_name,
                $client_phone,
                $client_fb,
                $client_mail,
                $client_descr,
                $client_photo,
                $client_id
            );
            $result['status'] = 'success';
            $result['message'] = 'Client updated successfully';
            $result['response'] = true;
            $result['data'] = $client;
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
        if (isset($_POST['client_id'])) {
            $clientDao = new ClientDao($adapter);
            $client_id = $_POST['client_id'];
            $client = $clientDao->selectById($client_id);
            if (!$client) {
                $result['message'] = 'Client not found';
                echo json_encode($result);
                exit();
            }
            if ($client['client_photo'] != 'default.png' && $client['client_photo'] != '') {
                deleteFile('./public/img.clients/' . $client['client_photo']);
            }
            $clientDao->delete($client_id);
            $result['status'] = 'success';
            $result['message'] = 'Client deleted successfully';
            $result['response'] = true;
        }
        echo json_encode($result);
    }
}
