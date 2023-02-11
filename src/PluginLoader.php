<?php

namespace Skintrphoenix\PluginLoader;

class PluginLoader{

    private $base_folder;

    public function __construct(){
        $this->base_folder = base_path('plugins') . '/';
        if(!is_dir($this->base_folder)){
            @mkdir($this->base_folder);
        }
    }

    public function getAllPlugins():array{
        $plugin = [];

        $data = scandir($this->base_folder);
        foreach($data as $item){
            $file = $this->base_folder . $item . '/plugin.json';
            if(is_file($file)){
                $json = json_decode(file_get_contents($file));
                if(isset($json->name)){
                    $plugin[] = $json->name;
                }
            }
        }

        return $plugin;
    }

}