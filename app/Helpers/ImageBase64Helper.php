<?php

declare(strict_types=1);

namespace App\Helpers;

use InvalidArgumentException;

abstract class ImageBase64Helper
{
    public static function generate(string $image): string
    {
        if (!self::isImage($image)) {
            throw new InvalidArgumentException('The image is invalid');
        }

        return base64_encode(file_get_contents($image));
    }

    private static function isImage(string $string): bool
    {
        $imageArray = getimagesize($string);

        return in_array($imageArray[2], [
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
        ]);
    }
}
