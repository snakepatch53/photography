<?php
function getUniqueKey($length = 10)
{
    $key = "";
    $keys = array_merge(range(0, 9), range('a', 'z'));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}


function uploadFIle($file, $path, $name = null, $extension = null)
{
    $extension = $extension ?? explode('.', $file['name'])[1];
    $name = $name ?? getUniqueKey(25);
    $name = $name . '.' . $extension;
    $tmp_name = $file['tmp_name'];
    $path = $path . $name;
    if (move_uploaded_file($tmp_name, $path)) {
        return $name;
    }
    return false;
}


function deleteFile($path)
{
    if (file_exists($path)) {
        unlink($path);
        return true;
    }
    return false;
}

function getLogo($logo_url, ...$props)
{
    $props = implode(' ', $props);
    if (str_contains($logo_url, '<svg')) {
        return $logo_url;
    } else {
        return "<img src='$logo_url' $props />";
    }
}

function getUserTypes()
{
    return [
        1 => "Administrador",
        2 => "Editor"
    ];
}

function getAlbumsFolder($path)
{
    $PATH = $path;
    // get folders name from path
    $folders = array_filter(glob($PATH . '*'), 'is_dir');
    $folders = array_map(function ($folder) {
        return basename($folder);
    }, $folders);
    // get files name of each folder
    $folders = array_map(function ($folder) use ($PATH) {
        $files = array_filter(glob($PATH . $folder . '/*'), 'is_file');
        $files = array_map(function ($file) {
            return basename($file);
        }, $files);
        return [
            'folder' => $folder,
            'files' => $files
        ];
    }, $folders);
    return $folders;
}



function getFiles($path, $ext = 'jpg|jpeg|png|gif|bmp')
{
    $files = array();
    $dir = opendir($path);
    while ($file = readdir($dir)) {
        if (preg_match('/^.*\.(' . $ext . ')$/i', $file)) {
            $files[] = $file;
        }
    }
    closedir($dir);
    return $files;
}

function optimizeImage($path_from, $path_to, $quality = 50, $size = 800)
{
    $image = Intervention\Image\ImageManagerStatic::make($path_from); // Cargar la imagen original

    // Optimizar la imagen con una calidad específica (0 a 100, siendo 100 la mejor calidad)
    $image->encode('jpg', $quality);
    // Define el tamaño máximo deseado (800x800 píxeles)
    $tamañoMaximo = $size;
    // Redimensiona la imagen para que se ajuste dentro de un cuadro de 800x800 píxeles sin recortar
    $image->resize($tamañoMaximo, $tamañoMaximo, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });
    // Guardar la imagen optimizada
    $image->save($path_to);
    return true;
}
