<?php

if (! function_exists('rsearch')) {
    function rsearch($folder, $regPattern) {
        $dir = new RecursiveDirectoryIterator($folder);
        $ite = new RecursiveIteratorIterator($dir);
        $files = new RegexIterator($ite, $regPattern, RegexIterator::GET_MATCH);
        $fileList = array();
        foreach($files as $file) {
            $fileList = array_merge($fileList, $file);
        }
        return $fileList;
    }
}

if (! function_exists('load')) {
    function load($path)
    {
        $result = rsearch($path, '/.*\/*\.php/');
        foreach ($result as $file) {
            $tokens = token_get_all(file_get_contents($file));
            foreach ($tokens as $data) {
                if (is_array($data)) {
                    if ($data[1] == 'class') {
                        if (!class_exists($file)) {
                            require $file;
                        }
                    }
                }
            }
        }
    }
}