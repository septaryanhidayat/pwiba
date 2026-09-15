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
    public static function image(
        string $data,
        int $size = 150,
        string $alt = 'QR Code Validasi',
        ?string $width = null,
        ?string $height = null,
        ?string $style = null,
        ?string $class = null,
        string $fit = 'fill'
    ): string {
        $src = self::url($data, $size);

        $styles = [];
        if ($width !== null) {
            $styles[] = 'width: '.$width.';';
        } elseif ($size > 0) {
            $styles[] = 'width: '.$size.'px;';
        }

        if ($height !== null) {
            $styles[] = 'height: '.$height.';';
        } elseif ($size > 0) {
            $styles[] = 'height: '.$size.'px;';
        }

        if ($fit !== '') {
            $styles[] = 'object-fit: '.$fit.';';
        }
        $styles[] = 'border: 1px solid #e2e8f0;';
        $styles[] = 'padding: 2px;';
        $styles[] = 'background: #fff;';
        $styles[] = 'border-radius: 4px;';
        $styles[] = 'display: block;';
        $styles[] = 'margin: 0 auto;';

        if ($style !== null && $style !== '') {
            $styles[] = $style;
        }

        $styleAttr = implode(' ', $styles);
        $classAttr = $class !== null && $class !== '' ? ' class="'.htmlspecialchars($class).'"' : '';

        return '<img src="'.htmlspecialchars($src).'"'.$classAttr.' alt="'.htmlspecialchars($alt).'" style="'.$styleAttr.'" />';
    }
}
