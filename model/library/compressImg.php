<?php
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
