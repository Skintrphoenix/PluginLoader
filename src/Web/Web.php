<?php

namespace Skintrphoenix\PluginLoader\Web;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Web{

    public function __construct()
    {
        $this->route();
        $this->symlink();
    }

    public function route(){
        Route::resource('plugins', PluginController::class);
    }

    public function symlink(){
        $link = base_path('resources/views/plugins');
        if(!is_link($link)){
            symlink(__DIR__ . '/../resource/page', $link);
        }
    }
}