<?php

namespace App\Utility;

class Upload {


    public static function uploadFile($file, $fileName, $fileExtension)
    {
        $currentDirectory = getcwd();
        $uploadDirectory = "/storage/";
        
        $fileSize = $file['size'];
        $fileTmpName = $file['tmp_name'];

        $pictureName = basename($fileName . '.'. $fileExtension);

        $uploadPath = $currentDirectory . $uploadDirectory . $pictureName;

        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            return $pictureName;
        } else {
            throw new \Exception("An error occurred. Please contact the administrator.");
        }
    }
}
