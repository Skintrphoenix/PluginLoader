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
            $path = $this->base_folder . $item;
            if($this->canloadplugin($path)){
                $json = json_decode(file_get_contents($path . '/plugin.yml'));
                if(isset($json->name)){
                    $plugin[] = $json->name;
                }
            }
        }
        return $plugin;
    }

    public function canloadplugin(string $path){
        return is_dir($path) and file_exists($path . "/plugin.yml") and file_exists($path . "/src/");
    }

}