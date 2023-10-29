<?php

namespace App\Attachment;

use App\Model\Property;

class PropertyAttachment
{
    // Path to properties images folder
    const DIRECTORY = UPLOAD_PATH . DIRECTORY_SEPARATOR . 'properties';

    // Function to upload the images added by the user on the server
    public static function upload(Property $property, string $format)
    {
        $image = $property->getImage();
        if (empty($image) || $property->shouldUpload() === false) {
            return;
        }
        $directory = self::DIRECTORY;

        // Creates the "Properties" folder to store the images if it does not exist
        if (file_exists($directory) === false) {
            mkdir($directory, 0777, true);
        }

        // Deletes the old image in the case of an image update
        if (!empty($property->getOldImage())) {
            $oldFile = $directory . DIRECTORY_SEPARATOR . $property->getOldImage();
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        $extension = $format === "image/jpeg" ? '.jpg' : '.png';
        $filename = uniqid("", true) . $extension;      // Creates a unique filename
        move_uploaded_file($image, $directory . DIRECTORY_SEPARATOR . $filename);
        $property->setImage($filename);
    }

    // This function is called when the user delete a property to delete the image
    public static function detach(Property $property)
    {
        if (!empty($property->getImage())) {
            $file = self::DIRECTORY . DIRECTORY_SEPARATOR . $property->getImage();
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
