<?php

// Detectar si estás en el entorno local o en el Raspberry Pi 3
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Local
    define('APP_DIR', $_SERVER['DOCUMENT_ROOT'] . '/Desktop/repertorioMagia/');
    define('HREF_VIEWS_DIR', '/Desktop/repertorioMagia/src/views');
    define('HREF_SRC_DIR', '/Desktop/repertorioMagia/src');
} else {
    // Raspberry Pi (Ubuntu)
    define('APP_DIR', $_SERVER['DOCUMENT_ROOT'] . '');
    define('HREF_VIEWS_DIR', '/src/views');
    define('HREF_SRC_DIR', '/src');
}
