<?php

/**
 * @author Mateusz Wysocki
 * @mail mateusz.wysocki53@gmail.com
 */
ob_start();

// OKREŚLENIE POŁOŻENIA STRONY W SERWISIE - DEFINICJA <BASE ... />
$AbsoluteURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
$dirCat = dirname($_SERVER['PHP_SELF']);
$AbsoluteURL .= $_SERVER['HTTP_HOST'];
$AbsoluteURL .= $dirCat != '\\' ? $dirCat : "";
$slash = substr($AbsoluteURL, -1);

$NewURL = $slash != '/' ? $AbsoluteURL.'/' : $AbsoluteURL;

// STAŁE DLA BAZY DANYCH
define('DB_HOST', 'xxxxx');
define('DB_USER', 'xxxxx');
define('DB_PASSWORD', 'xxxxx');
define('DB_NAME', 'xxxxx');

// STAŁA DLA ADRESU I LOKALIZACJI APLIKACJI
define('SERVER_ADDRESS', $NewURL);

// STAŁA DLA LOKALIZACJI KATALOGÓW I PLIKÓW
set_include_path(get_include_path() . PATH_SEPARATOR . "class");
set_include_path(get_include_path() . PATH_SEPARATOR . "class/Managers");
set_include_path(get_include_path() . PATH_SEPARATOR . "libs");

// Magiczna funkcja automatycznie ładująca klasy wg. zapotrzebowania
function __autoload($className) {
    
    include_once($className.".class.php");
    
}
