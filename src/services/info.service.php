<?php
class InfoService
{
    public static function select($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $infoDao = new InfoDao($adapter);
        $info = $infoDao->select();
        echo json_encode([
            'status' => 'success',
            'message' => 'Info obtained successfully',
            'response' => true,
            'data' => $info
        ]);
        exit();
    }

    public static function update($DATA)
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $adapter = $DATA['mysqlAdapter'];
        $infoDao = new InfoDao($adapter);

        $response = [
            'status' => 'error',
            'message' => 'Data not found',
            'response' => false,
            'data' => null
        ];

        if (isset(
            $_POST['info_name'],
            $_POST['info_country'],
            $_POST['info_state'],
            $_POST['info_city'],
            $_POST['info_whatsapp'],
            $_POST['info_location'],
            $_POST['info_desc'],
            $_POST['info_mision'],
            $_POST['info_vision'],
            $_POST['info_fb_app_id'],
            $_POST['info_fb_app_secret'],
            $_POST['info_fb_page_id'],
            $_POST['info_fb_access_token'],
            $_POST['info_home_title'],
            $_POST['info_home_subtitle'],
            $_POST['info_services_title'],
            $_POST['info_services_subtitle'],
            $_POST['info_portfolio_title'],
            $_POST['info_portfolio_subtitle'],
            $_POST['info_about_title'],
            $_POST['info_about_subtitle'],
            $_POST['theme_id']
        )) {

            $current_info = $infoDao->select();

            $info_logo = $current_info['info_logo'];
            $info_icon = $current_info['info_icon'];
            $info_services_image = $current_info['info_services_image'];
            $info_portfolio_image = $current_info['info_portfolio_image'];
            $info_about_image = $current_info['info_about_image'];

            $PATH_IMG_INFO = './public/img.info/';
            if (isset($_FILES['info_logo'])) {
                if ($_FILES['info_logo']['tmp_name'] != "" or $_FILES['info_logo']['tmp_name'] != null) {
                    if ($info_logo != '') deleteFile($PATH_IMG_INFO . $info_logo);
                    $info_logo = uploadFIle($_FILES['info_logo'], $PATH_IMG_INFO);
                }
            }
            if (isset($_FILES['info_icon'])) {
                if ($_FILES['info_icon']['tmp_name'] != "" or $_FILES['info_icon']['tmp_name'] != null) {
                    if ($info_icon != '') deleteFile($PATH_IMG_INFO . $info_icon);
                    $info_icon = uploadFIle($_FILES['info_icon'], $PATH_IMG_INFO);
                }
            }
            if (isset($_FILES['info_services_image'])) {
                if ($_FILES['info_services_image']['tmp_name'] != "" or $_FILES['info_services_image']['tmp_name'] != null) {
                    if ($info_services_image != '') deleteFile($PATH_IMG_INFO . $info_services_image);
                    $info_services_image = uploadFIle($_FILES['info_services_image'], $PATH_IMG_INFO);
                }
            }
            if (isset($_FILES['info_portfolio_image'])) {
                if ($_FILES['info_portfolio_image']['tmp_name'] != "" or $_FILES['info_portfolio_image']['tmp_name'] != null) {
                    if ($info_portfolio_image != '') deleteFile($PATH_IMG_INFO . $info_portfolio_image);
                    $info_portfolio_image = uploadFIle($_FILES['info_portfolio_image'], $PATH_IMG_INFO);
                }
            }
            if (isset($_FILES['info_about_image'])) {
                if ($_FILES['info_about_image']['tmp_name'] != "" or $_FILES['info_about_image']['tmp_name'] != null) {
                    if ($info_about_image != '') deleteFile($PATH_IMG_INFO . $info_about_image);
                    $info_about_image = uploadFIle($_FILES['info_about_image'], $PATH_IMG_INFO);
                }
            }



            $infoDao->update(
                $_POST['info_name'],
                $_POST['info_country'],
                $_POST['info_state'],
                $_POST['info_city'],
                $_POST['info_whatsapp'],
                $_POST['info_location'],
                $_POST['info_desc'],
                $_POST['info_mision'],
                $_POST['info_vision'],
                $info_logo,
                $info_icon,
                $_POST['info_fb_app_id'],
                $_POST['info_fb_app_secret'],
                $_POST['info_fb_page_id'],
                $_POST['info_fb_access_token'],
                $_POST['info_home_title'],
                $_POST['info_home_subtitle'],
                $_POST['info_services_title'],
                $_POST['info_services_subtitle'],
                $info_services_image,
                $_POST['info_portfolio_title'],
                $_POST['info_portfolio_subtitle'],
                $info_portfolio_image,
                $_POST['info_about_title'],
                $_POST['info_about_subtitle'],
                $info_about_image,
                $_POST['theme_id']
            );

            if (isset($_FILES['info_logo'])) uploadFIle($_FILES['info_logo'], './public/img/', 'logo', 'png');
            if (isset($_FILES['info_icon'])) uploadFIle($_FILES['info_icon'], './public/img/', 'icon', 'png');

            $response = [
                'status' => 'success',
                'message' => 'Información actualizada',
                'response' => true,
                'data' => null
            ];
        }
        echo json_encode($response);
    }
}
