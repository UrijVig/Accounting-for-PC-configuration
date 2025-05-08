<?php
    ini_set('display_errors', 1);
    ini_set('display_setup_errors', 1);
    error_reporting(E_ALL);
  
    $dir = __DIR__;
    // echo $dir;
    connectFiles($dir);
    
    function connectFiles($dir) {
        // Проверяем, что это директория
        if (!is_dir($dir)) {
            return;
        }
        
        // Получаем список файлов, исключая . и ..
        $files = array_diff(scandir($dir), ['.', '..']);
        
        foreach ($files as $file) {
            $fullPath = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($fullPath)) {
                // Рекурсивный вызов с полным путем
                connectFiles($fullPath);
            } else {
                // Проверяем расширение файла
                if (pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
                    require_once $fullPath;
                    // echo $fullPath ."<br>";

                }
            }                
        }
    }

    Route::start();