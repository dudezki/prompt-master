<?php

if(!function_exists('createDefaultAvatar')) {
    function createDefaultAvatar($initial): string
    {
        $width = 100;
        $height = 100;

        // Create a blank image
        $image = imagecreatetruecolor($width, $height);

        // Set background color to black
        $backgroundColor = imagecolorallocate($image, 128,128,128);
        imagefill($image, 0, 0, $backgroundColor);

        // Set text color to white
        $textColor = imagecolorallocate($image, 255, 255, 255);

        // Draw the initial manually
        $x = $width / 2 - 5;
        $y = $height / 2 - 7;
        imagestring($image, 5, $x, $y, $initial, $textColor);

        // Capture the image output
        ob_start();
        imagepng($image);
        $imageData = ob_get_contents();
        ob_end_clean();

        // Destroy the image resource
        imagedestroy($image);

        return $imageData;
    }
}
