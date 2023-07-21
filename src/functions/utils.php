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

function getAlbumsFolder()
{
    $PATH = './albums/';
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
