<?php

namespace Skintrphoenix\PluginLoader;

use Skintrphoenix\PluginLoader\Plugin\PluginBase;

class PluginLoader implements PluginIds{

    private $base_folder;

    public function __construct(){
        $this->base_folder = base_path('plugins') . '/';
        if(!is_dir($this->base_folder)){
            @mkdir($this->base_folder);
        }
    }

    public function getAllPlugins():array{
        $plugins = [];

        $data = scandir($this->base_folder);
        for($i = 2; $i < count($data); $i++){
            $item = $data[$i];
            try {
                $path = $this->base_folder . $item;
                //code...
                if($this->canloadplugin($path)){
                    $plugin = json_decode(file_get_contents($path . '/' . self::PLUGIN));
                    $class = $this->validateClass($path, $plugin->main);
                    if(!is_null($class)){
                        $plugins[$plugin->name] = $class;
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                var_dump($th->getMessage());
            }
        }
        return $plugins;
    }

    public function canloadplugin(string $path){
        return is_dir($path) and file_exists($path . "/" . self::PLUGIN) and file_exists($path . "/src/");
    }

    public function validateClass(string $path,string $main):?PluginBase{
        $class_file = $main;
        if(class_exists($main)){
            $class = new $class_file();
            if($class instanceof PluginBase){
                return $class;
            }
        }
        return null;
    }

}