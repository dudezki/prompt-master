<?php

if(!function_exists('createDefaultAvatar')) {
    function createDefaultAvatar($initial): string
    {
        $filePath = public_path('assets/images/favicon/favicon.png');
        $fileContent = file_get_contents($filePath);
        return base64_encode($fileContent);
    }
}
