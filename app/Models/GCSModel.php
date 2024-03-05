<?php

namespace App\Models;

use Exception;

use Google\Cloud\Storage\StorageClient;

class GCSModel
{
    private static $instance;
    private static $apiGoogleUrl = 'https://storage.googleapis.com';
    private static $ourBucket = 'escoserra-bucket';

    public static function isAvailable()
    {
        if (!self::$instance instanceof self) {
            try {
                self::$instance = new StorageClient([
                    'projectId' => 'mythic-hulling-359617',
                    'keyFilePath' => env('GOOGLE_APPLICATION_CREDENTIALS'),
                ]);
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return true;
    }

    public static function upload($path, $filename, $fileBase64)
    {
        self::isAvailable();

        $bucket = self::$instance->bucket(self::$ourBucket);
        $bucket->upload($fileBase64, [
            'name' => $path . '/' . $filename,
            'predefinedAcl' => 'publicRead'
        ]);
        return self::$apiGoogleUrl . '/' . self::$ourBucket . '/' . $path . '/' . $filename;
    }

    public static function delete($path)
    {
        self::isAvailable();

        $bucket = self::$instance->bucket(self::$ourBucket);
        $object = $bucket->object($path);
        $object->delete();
        return true;
    }
}
