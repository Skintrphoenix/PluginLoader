<?php

namespace Skintrphoenix\PluginLoader;

class PluginLoader{

    private $base_folder;

    public function __construct(){
        $this->base_folder = base_path('plugins');
        if(!is_dir($this->base_folder)){
            @mkdir($this->base_folder);
        }
    }

    public function getAllPlugins():array{
        return scandir($this->base_folder);
    }

}