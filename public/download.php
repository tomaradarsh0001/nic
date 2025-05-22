<?php
// File path
$file = '/var/www/code.zip';

// Check if the file exists
if (file_exists($file)) {
    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // Clear output buffer
    flush();
    // Read the file
    readfile($file);
    exit;
} else {
    echo "File not found.";
}
