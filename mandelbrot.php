<?php

function mandelbrot()
{
    /*
     * From http://rosettacode.org/wiki/Mandelbrot_set
     *
     * Implemented by AlexLehm.
     * Modified by y-uti.
     */

    $dim_x = 900;
    $dim_y = 600;

    $x = (float) $_GET["x"] ?: -0.5;
    $y = (float) $_GET["y"] ?: 0.0;
    $s = (float) $_GET["s"] ?: 1.0;
    $l = (int) $_GET["l"] ?: 100;

    $min_x = $x - $s * $dim_x / $dim_y;
    $max_x = $x + $s * $dim_x / $dim_y;
    $min_y = $y - $s;
    $max_y = $y + $s;
 
    $im = @imagecreate($dim_x, $dim_y)
        or die("Cannot Initialize new GD image stream");
    header("Content-Type: image/png");
    $black_color = imagecolorallocate($im, 0, 0, 0);
    $colors = array(
        imagecolorallocate($im, 127, 127, 127),
        imagecolorallocate($im, 255, 255, 255),
    );

    for ($y = 0; $y <= $dim_y; ++$y) {
        for ($x = 0; $x <= $dim_x; ++$x) {
            $c1 = $min_x + ($max_x - $min_x) / $dim_x * $x;
            $c2 = $min_y + ($max_y - $min_y) / $dim_y * $y;
            $z1 = 0;
            $z2 = 0;
            for ($i = 0; $i < $l; ++$i) {
                $new1 = $z1 * $z1 - $z2 * $z2 + $c1;
                $new2 = 2 * $z1 * $z2 + $c2;
                $z1 = $new1;
                $z2 = $new2;
                if($z1 * $z1 + $z2 * $z2 >= 4) {
                    break;
                }
            }
            if ($i < $l) {
                imagesetpixel($im, $x, $dim_y - $y, $colors[$i % 2]);
            }
        }
    }
 
    imagepng($im);
    imagedestroy($im);
}

mandelbrot();
