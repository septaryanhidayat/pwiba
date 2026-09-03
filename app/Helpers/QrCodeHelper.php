<?php

namespace App\Helpers;

class QrCodeHelper
{
    /**
     * Generate an SVG data URI or URL for a QR Code
     */
    public static function url(string $data, int $size = 150): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size='.$size.'x'.$size.'&margin=5&data='.urlencode($data);
    }

    /**
     * Generate inline QR Code Image HTML tag
     */
    public static function image(string $data, int $size = 130, string $alt = 'QR Code Validasi'): string
    {
        $src = self::url($data, $size);

        return '<img src="'.htmlspecialchars($src).'" width="'.$size.'" height="'.$size.'" alt="'.htmlspecialchars($alt).'" style="border: 1px solid #e2e8f0; padding: 4px; background: #fff; border-radius: 6px;" />';
    }
}
