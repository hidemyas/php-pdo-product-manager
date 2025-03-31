<?php
// system dosyları otomatik include işlemi
spl_autoload_register(function ($class_name) {
    $directory = __DIR__ . "/system/libs/"; // Sınıf dosyalarının olduğu dizin
    $file = $directory . $class_name . ".php";

    if (file_exists($file)) {
        require_once $file;
    }
});

//include_once "system/libs/Controller.php";
//include_once "system/libs/Model.php";
//include_once "system/libs/Database.php";
//include_once "system/libs/Load.php";


// config dosyasını import edelim
require_once "app/config/config.php";

// bootstrap bölümü
$boot   =   new Bootstrap();



//$c->selamla();

