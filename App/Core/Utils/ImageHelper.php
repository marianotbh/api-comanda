<?php

namespace App\Core\Utils;

use App\Core\Exceptions\AppException;
use \Slim\Http\UploadedFile;

function validateSize(UploadedFile $file, $maxSizeMB = 10)
{
    $fileSize = $file->getSize();

    if ($fileSize > 1024 * 1024 * $maxSizeMB)
        throw new AppException("File is too big. Please provide an image smaller than $maxSizeMB" . "mb");

    return true;
}

function validateExtension(UploadedFile $file, $allowedExtensions)
{
    $fileName = $file->getClientFilename();
    $extension = strtolower(array_reverse(explode(".", $fileName))[0]);

    if (!in_array($extension, $allowedExtensions)) throw new AppException("Invalid file format");

    return true;
}

class ImageHelper
{
    static function validate(UploadedFile $file, $maxSizeMB = 10, $allowedExtensions = ["jpg", "png", "gif", "bmp"])
    {
        return $file->getError() === UPLOAD_ERR_OK && validateSize($file, $maxSizeMB) && validateExtension($file, $allowedExtensions);
    }

    static function saveTo($folder, UploadedFile $file, $name = "", $backup = false)
    {
        $dir = __DIR__ . "\\..\\..\\FileSystem\\$folder";

        if (strlen($name) == 0) $name = $file->getClientFilename();

        if ($backup && file_exists($dir . DIRECTORY_SEPARATOR . $name)) {
            rename($dir . DIRECTORY_SEPARATOR . $name, $dir . DIRECTORY_SEPARATOR . 'backups' . DIRECTORY_SEPARATOR . $name);
        }

        $file->moveTo($dir . DIRECTORY_SEPARATOR . $name);
    }
}
