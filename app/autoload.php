<?php
namespace Init;

function classLoader () {
    $siteDir = "../";
    $classesDirs = [
        "app/Controllers/",
        "app/Models/",
    ];

    foreach ($classesDirs as $classesDir) {
        $Catalog = dir($siteDir.$classesDir);
        while ($file = $Catalog->read()){
            if (preg_match('/^.*\.php$/', $file) ){
                require_once $siteDir.$classesDir.$file;
            }
        }
    }
}