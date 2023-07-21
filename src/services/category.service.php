<?php
class CategoryService
{

    public static function select($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $categoryDao = new CategoryDao($adapter);
        $categories = $categoryDao->select();
        echo json_encode([
            'status' => 'success',
            'message' => 'categories obtained successfully',
            'response' => true,
            'data' => $categories
        ]);
    }

    public static function selectById($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $categoryDao = new CategoryDao($adapter);

        if (empty($_POST['category_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'category_id is required',
                'response' => false,
                'data' => null
            ]);
            exit();
        }

        $category_id = $_POST['category_id'];

        $categories = $categoryDao->selectById($category_id);
        echo json_encode([
            'status' => 'success',
            'message' => 'categories obtained successfully',
            'response' => true,
            'data' => $categories
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
            $_POST['category_name'],
            $_POST['category_descr']
        )) {
            $categoryDao = new categoryDao($adapter);
            $category_name = $_POST['category_name'];
            $category_descr = $_POST['category_descr'];
            $category_photo = "default.png";
            if (isset($_FILES['category_photo'])) {
                if ($_FILES['category_photo']['tmp_name'] != "" or $_FILES['category_photo']['tmp_name'] != null) {
                    $category_photo = uploadFIle($_FILES['category_photo'], './public/img.categories/');
                }
            };
            $category = $categoryDao->insert(
                $category_name,
                $category_descr,
                $category_photo
            );

            $result['status'] = 'success';
            $result['message'] = 'Categories created successfully';
            $result['response'] = true;
            $result['data'] = $category;
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
            $_POST['category_name'],
            $_POST['category_descr'],
            $_POST['category_id']
        )) {
            $categoryDao = new categoryDao($adapter);

            $category_id = $_POST['category_id'];
            $current_category = $categoryDao->selectById($category_id);
            if (!$current_category) {
                $result['message'] = 'Categories not found';
                echo json_encode($result);
                exit();
            }

            $category_name = $_POST['category_name'];
            $category_descr = $_POST['category_descr'];
            $category_id = $_POST['category_id'];
            $category_photo = $current_category['category_photo'];

            if (isset($_FILES['category_photo'])) {
                if ($_FILES['category_photo']['tmp_name'] != "" or $_FILES['category_photo']['tmp_name'] != null) {
                    if ($category_photo != 'default.png' && $category_photo != '') deleteFile('./public/img.categories/' . $category_photo);
                    $category_photo = uploadFIle($_FILES['category_photo'], './public/img.categories/');
                }
            }
            $category = $categoryDao->update(
                $category_name,
                $category_descr,
                $category_photo,
                $category_id
            );
            $result['status'] = 'success';
            $result['message'] = 'Categories updated successfully';
            $result['response'] = true;
            $result['data'] = $category;
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
        if (isset($_POST['category_id'])) {
            $categoryDao = new categoryDao($adapter);
            $category_id = $_POST['category_id'];
            $category = $categoryDao->selectById($category_id);
            if (!$category) {
                $result['message'] = 'Categories not found';
                echo json_encode($result);
                exit();
            }
            if ($category['category_photo'] != 'default.png' && $category['category_photo'] != '') {
                deleteFile('./public/img.categories/' . $category['category_photo']);
            }
            $categoryDao->delete($category_id);
            $result['status'] = 'success';
            $result['message'] = 'Categories deleted successfully';
            $result['response'] = true;
        }
        echo json_encode($result);
    }
}
