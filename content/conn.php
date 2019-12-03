<?php
//koneksi ke database
mysql_set_charset('utf8');
mysql_connect("localhost", "root", "administrator");
mysql_select_db("library_unpi");
 
//fungsi untuk mengkonversi size file
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
 
    $bytes /= pow(1024, $pow); 
 
    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
?>