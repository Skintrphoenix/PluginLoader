<?php

namespace Skintrphoenix\PluginLoader;

use Illuminate\Support\Facades\Log;
use Skintrphoenix\PluginLoader\Plugin\PluginBase;
use Skintrphoenix\PluginLoader\Web\Web;

class PluginLoader implements PluginIds{

    private $base_folder;

    private $plugins = [];

    public function __construct(){
        $this->base_folder = base_path(self::FOLDER) . '/';
        if(!is_dir($this->base_folder)){
            @mkdir($this->base_folder);
        }
        $this->loadPlugins();
        $web = new Web();
    }

    public function loadPlugin($path):void{
        if($this->canloadplugin($path)){
            $plugin = json_decode(file_get_contents($path . '/' . self::PLUGIN));
            $class = $this->validateClass($path, $plugin->main);
            if(!is_null($class)){
                $this->plugins[$plugin->name] = $class;
            }
        }
    }

    public function loadPlugins():void{
        $data = scandir($this->base_folder);
        for($i = 2; $i < count($data); $i++){
            $item = $data[$i];
            try {
                $path = $this->base_folder . $item;
                $this->loadPlugin($path);
            } catch (\Throwable $th) {
                //throw $th;
                Log::error($th->getMessage());
            }
        }
    }

    public function getAllPlugins():array{
        return $this->plugins;
    }

    public function canloadplugin(string $path){
        return is_dir($path) and file_exists($path . "/" . self::PLUGIN) and file_exists($path . "/src/");
    }

    public function validateClass(string $path,string $main):?PluginBase{
        $class_file = $path . "/src/" . $main;
        $class_file = str_replace('\\', '/', $class_file);
        spl_autoload_register(function($class_name) use($class_file, $main){
            if(!class_exists($main)){
                include $class_file . '.php';
            }
        });
        $class = new $main();
        if($class instanceof PluginBase){
            return $class;
        }
        return null;
    }

}