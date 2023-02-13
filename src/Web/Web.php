<?php

namespace Skintrphoenix\PluginLoader\Web;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Skintrphoenix\PluginLoader\PluginIds;

class Web implements PluginIds{

    public function __construct()
    {
        $this->route();
        $this->symlink();
    }

    public function route(){
        Route::resource(self::FOLDER, PluginController::class);
    }

    public function symlink(){
        $link = base_path('resources/views/' . self::FOLDER);
        if(!is_link($link)){
            symlink(__DIR__ . '/../resource/views', $link);
        }


        $link = base_path('public/resources/');
        if(!is_dir($link)){
            mkdir($link);
        }
        $link .= self::FOLDER;
        if(!is_link($link)){
            symlink(__DIR__ . '/../resource/public', $link);
        }
    }
}