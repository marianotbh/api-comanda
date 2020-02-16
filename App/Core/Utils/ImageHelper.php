<?php

namespace App\Core\Utils;

use \Slim\Http\UploadedFile;

function validateSize(UploadedFile $file, $maxSizeMB)
{
    $fileSize = $file->getSize();
    if ($fileSize <= 1024 * 1024 * $maxSizeMB) {
        return true;
    } else {
        throw new \Exception("El archivo supera los " . $maxSizeMB . "MB");
    }
}

function validateExtension(UploadedFile $file, $validExtensions)
{
    $fileName = $file->getClientFilename();
    $extension = strtolower(array_pop(explode(".", $fileName)));
    if (in_array($extension, $validExtensions)) {
        return true;
    } else {
        throw new \Exception("Formato de archivo inválido");
    }
}

class ImageHelper
{
    static function validate(UploadedFile $file, $maxSizeMB, $validExtensions)
    {
        return $file->getError() === UPLOAD_ERR_OK && validateSize($file, $maxSizeMB) && validateExtension($file, $validExtensions);
    }

    static function save(UploadedFile $file, $name, $backup = false)
    {
        $imgDir = __DIR__ . '\..\FileSystem\img';
        $name = $name . '.png';
        if ($backup && file_exists($imgDir . DIRECTORY_SEPARATOR . $name)) {
            rename($imgDir . DIRECTORY_SEPARATOR . $name, $imgDir . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR . $name);
        }
        $file->moveTo($imgDir . DIRECTORY_SEPARATOR . $name);
    }
}
