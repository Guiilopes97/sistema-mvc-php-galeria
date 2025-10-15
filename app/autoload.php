<?php

/**
 * Autoloader simples para o sistema MVC
 */

spl_autoload_register(function ($className) {
    // Diretórios onde procurar as classes
    $directories = [
        __DIR__ . '/controllers/',
        __DIR__ . '/models/',
        __DIR__ . '/',
        __DIR__ . '/../config/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
