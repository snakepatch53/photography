<?php
function getMime($image)
{
    return $image->getClientOriginalExtension();
}

// function getBase64($image)
// {
//     $flujo = fopen($image->getRealPath(), 'r');
//     $enbase64 =  base64_encode(fread($flujo, filesize($image->getRealPath())));
//     fclose($flujo);
//     return $enbase64;
// }
function getMimeFromPath($image_path)
{
    ob_start();
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension   
    $mime = finfo_file($finfo, $image_path);
    finfo_close($finfo);
    ob_clean();
    return $mime;
}
function getBase64($path)
{
    $flujo = fopen($path, 'r');
    $enbase64 =  base64_encode(fread($flujo, filesize($path)));
    fclose($flujo);
    return $enbase64;
}

function qualityBase64img($base64img, $mimeimg, $quality)
{
    ob_start();
    $im = imagecreatefromstring(base64_decode($base64img));

    switch ($mimeimg) {
        case 'png':
        case 'image/png':
            imagepng($im, null, $quality);
            break;
        case 'jpg':
        case 'image/jpg':
        case 'jpeg':
        case 'image/jpeg':
            imagejpeg($im, null, $quality);
            break;
        case 'image/gif':
        case 'gif':
            imagegif($im, null, $quality);
    }


    $stream = ob_get_clean();
    $newB64 = base64_encode($stream);
    imagedestroy($im);
    return $newB64;
}

function resizeBase64img($base64img, $mimeimg, $newwidth, $newheight)
{
    // Get new sizes
    list($width, $height) = getimagesizefromstring(base64_decode($base64img));

    ob_start();
    $temp_thumb = imagecreatetruecolor($newwidth, $newheight);
    imagealphablending($temp_thumb, false);
    imagesavealpha($temp_thumb, true);
    $source = imagecreatefromstring(base64_decode($base64img));
    // Resize
    imagecopyresized($temp_thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    switch ($mimeimg) {
        case 'png':
        case 'image/png':
        case 'PNG':
        case 'IMAGE/PNG':
            imagepng($temp_thumb, null);
            break;
        case 'jpg':
        case 'image/jpg':
        case 'jpeg':
        case 'JPEG':
        case 'JPG':
        case 'IMAGE/JPG':
        case 'IMAGE/JPEG':
        case 'image/jpeg':
            imagejpeg($temp_thumb, null);
            break;
        case 'image/gif':
        case 'gif':
        case 'GIT':
        case 'IMAGE/GIF':
            imagegif($temp_thumb, null);
    }

    $stream = ob_get_clean();
    $newB64 = base64_encode($stream);
    imagedestroy($temp_thumb);
    imagedestroy($source);
    return $newB64;
}
/*
  *
  * Los parametros son string base64, string mime, int alto deseado 
  */
function resizeBase64andScaleWidth($base64img, $mimeimg, $newheight)
{

    // Get new sizes
    list($width, $height) = getimagesizefromstring(base64_decode($base64img));


    // Calcular nuevo ancho con la misma perdida o ganancia proporcial del alto (Escalar)
    $porNewHeight = ($newheight * 100) / $height;
    $newwidth =  (int)($width * ($porNewHeight / 100));

    ob_start();
    $temp_thumb = imagecreatetruecolor($newwidth, $newheight);
    imagealphablending($temp_thumb, false);
    imagesavealpha($temp_thumb, true);

    $source = imagecreatefromstring(base64_decode($base64img));

    // Resize
    imagecopyresized($temp_thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


    switch ($mimeimg) {
        case 'png':
        case 'image/png':
        case 'PNG':
        case 'IMAGE/PNG':
            imagepng($temp_thumb, null);
            break;
        case 'jpg':
        case 'image/jpg':
        case 'jpeg':
        case 'JPEG':
        case 'JPG':
        case 'IMAGE/JPG':
        case 'IMAGE/JPEG':
        case 'image/jpeg':
            imagejpeg($temp_thumb, null);
            break;
        case 'image/gif':
        case 'gif':
        case 'GIT':
        case 'IMAGE/GIF':
            imagegif($temp_thumb, null);
    }

    $stream = ob_get_clean();
    $newB64 = base64_encode($stream);

    imagedestroy($temp_thumb);
    imagedestroy($source);

    return $newB64;
}


function resizeBase64andScaleHeight($base64img, $mimeimg, $newwidth)
{

    // Get new sizes
    list($width, $height) = getimagesizefromstring(base64_decode($base64img));


    // Calcular nuevo alto con la misma perdida o ganancia proporcial del ancho (Escalar)
    $porNewWidth = ($newwidth * 100) / $width;
    $newHeight =  (int)($height * ($porNewWidth / 100));

    ob_start();
    $temp_thumb = imagecreatetruecolor($newwidth, $newHeight);
    imagealphablending($temp_thumb, false);
    imagesavealpha($temp_thumb, true);

    $source = imagecreatefromstring(base64_decode($base64img));

    // Resize
    imagecopyresized($temp_thumb, $source, 0, 0, 0, 0, $newwidth, $newHeight, $width, $height);


    switch ($mimeimg) {
        case 'png':
        case 'image/png':
        case 'PNG':
        case 'IMAGE/PNG':
            imagepng($temp_thumb, null);
            break;
        case 'jpg':
        case 'image/jpg':
        case 'jpeg':
        case 'JPEG':
        case 'JPG':
        case 'IMAGE/JPG':
        case 'IMAGE/JPEG':
        case 'image/jpeg':
            imagejpeg($temp_thumb, null);
            break;
        case 'image/gif':
        case 'gif':
        case 'GIT':
        case 'IMAGE/GIF':
            imagegif($temp_thumb, null);
    }

    $stream = ob_get_clean();
    $newB64 = base64_encode($stream);

    imagedestroy($temp_thumb);
    imagedestroy($source);

    return $newB64;
}


function uploadInFolder($idResource, $file, $path_absolute_folder)
{

    try {
        $date =  getdate();
        $mime = "." . getMime($file);
        $filename = $idResource . "_" . $date["year"] . "_" . $date["mon"] . "_" . $date["mday"] . "-" .
            $date["hours"] . "-" . $date["minutes"] . "-" . $date["seconds"] . $mime;


        move_uploaded_file($file, $path_absolute_folder . $filename);
        return $filename;
    } catch (Exception $e) {
        return false;
    }
}



// para guardar
function saveCompressImg($file_img, $name, $path, $max_width, $max_height)
{
    $extension = pathinfo($file_img['name'], PATHINFO_EXTENSION);
    $name = $name . '.' . $extension;
    if (
        $file_img['type'] == 'image/png' ||
        $file_img['type'] == 'image/jpeg' ||
        $file_img['type'] == 'image/jpg' ||
        $file_img['type'] == 'image/gif'
    ) {
        $medidasimagen = getimagesize($file_img['tmp_name']);
        //Si las imagenes tienen una resolución y un peso aceptable se suben tal cual
        if ($medidasimagen[0] < 1280 && $file_img['size'] < 100000) {
            move_uploaded_file($file_img['tmp_name'], $path . '/' . $name);
        }
        //Si no, se generan nuevas imagenes optimizadas
        else {
            // $name = $file_img['name'];
            //Redimensionar
            $rtOriginal = $file_img['tmp_name'];
            if ($file_img['type'] == 'image/jpeg') $original = imagecreatefromjpeg($rtOriginal);
            if ($file_img['type'] == 'image/jpg') $original = imagecreatefromjpeg($rtOriginal);
            if ($file_img['type'] == 'image/png') $original = imagecreatefrompng($rtOriginal);
            if ($file_img['type'] == 'image/gif') $original = imagecreatefromgif($rtOriginal);
            list($ancho, $alto) = getimagesize($rtOriginal);

            $x_ratio = $max_width / $ancho;
            $y_ratio = $max_height / $alto;
            if (($ancho <= $max_width) && ($alto <= $max_height)) {
                $ancho_final = $ancho;
                $alto_final = $alto;
            } elseif (($x_ratio * $alto) < $max_height) {
                $alto_final = ceil($x_ratio * $alto);
                $ancho_final = $max_width;
            } else {
                $ancho_final = ceil($y_ratio * $ancho);
                $alto_final = $max_height;
            }
            $lienzo = imagecreatetruecolor($ancho_final, $alto_final);
            imagecopyresampled($lienzo, $original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
            $copy = false;
            if ($file_img['type'] == 'image/jpeg') $copy = imagejpeg($lienzo, $path . "/" . $name);
            if ($file_img['type'] == 'image/jpg') $copy = imagejpeg($lienzo, $path . "/" . $name);
            if ($file_img['type'] == 'image/png') $copy = imagepng($lienzo, $path . "/" . $name);
            if ($file_img['type'] == 'image/gif') $copy = imagegif($lienzo, $path . "/" . $name);
        }
        return true;
    } else return false;
}
