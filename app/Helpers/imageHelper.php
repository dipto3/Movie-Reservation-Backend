<?php

use Intervention\Image\Laravel\Facades\Image;


function uploadFile($file, $prefix = '', $dir = 'documents')
{
    $extension = $file->getClientOriginalExtension();
    $uniqueId = uniqid();
    $fileName = "{$prefix}{$uniqueId}.{$extension}";

    $path = public_path($dir . '/');

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $file->move($path, $fileName);

    return $dir . '/' . $fileName;
}

function uploadBase64Image($base64, $dir = 'images', $prefix = '', $width = null, $height = null, $extn = 'png')
{
    $uniqueId = uniqid();
    $imageName = $prefix . '_' . $uniqueId . '.' . $extn;
    $path = public_path($dir . '/');
    // Create directory if it doesn't exist
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $image = Image::read($base64);
    // Check if width and height are valid integers
    if (is_numeric($width) && is_numeric($height)) {
        $image->resize((int)$width, (int)$height);
    }

    // Save the image
    $image->save($path . $imageName);

    return $dir . '/' . $imageName;
}


function uploadImage($file, $width, $height, $prefix = '', $dir = 'images')
{
    $uniqueId = uniqid();
    $imageName = $prefix . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();
    $path = public_path($dir . '/');

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    Image::read($file)->resize($width, $height)->save($path . $imageName);
    return $dir . '/' . $imageName;
}

function uploadSameImage($file, $prefix = '', $dir = 'images')
{
    $uniqueId = uniqid();
    $imageName = $prefix . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();
    $path = public_path($dir . '/');

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    Image::read($file)->save($path . $imageName);
    return $dir . '/' . $imageName;
}

function deleteImage($path): bool
{
    if ($path && file_exists(public_path($path))) {
        unlink(public_path($path));
        return true;
    }
    return false;
}

function deleteFile($filePath): bool
{
    return  deleteImage($filePath);
}

function uploadImages($files, $width, $height, $prefix = '', $dir = 'images')
{
    $uploadedImages = [];
    $path = public_path($dir . '/');

    // Ensure the directory exists
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    foreach ($files as $file) {
        $imageName = $prefix . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        Image::read($file)->resize($width, $height)->save($path . $imageName);
        $uploadedImages[] = $dir . '/' . $imageName;
    }

    return $uploadedImages;
}
