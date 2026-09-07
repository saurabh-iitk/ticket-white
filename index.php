<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Strip project subfolder prefix if running in a subdirectory under Apache/MAMP
$relativeUri = preg_replace('#^/ticket-white#', '', $uri);
$filePath = __DIR__ . '/public' . $relativeUri;

if ($relativeUri !== '/' && is_file($filePath)) {
    $mimeTypes = [
        'css'   => 'text/css; charset=UTF-8',
        'js'    => 'application/javascript; charset=UTF-8',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject'
    ];
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    $contentType = $mimeTypes[strtolower($ext)] ?? mime_content_type($filePath);
    
    header('Content-Type: ' . $contentType);
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
}

require_once __DIR__.'/public/index.php';

