<?php

namespace Skintrphoenix\PluginLoader\Plugin;

use Illuminate\Support\Facades\Log;
use Skintrphoenix\PluginLoader\PluginLoader;

class PluginGet{

    private $main;

    private $plugins = [];

    public function __construct()
    {
        $main = new PluginLoader();
        $this->main = $main;
        $this->loadPlugins();
    }

    public function getAllPlugins(){
        return $this->plugins;
    }

    public function loadPlugins(){
        $data = scandir($this->main->base_folder);
        for($i = 2; $i < count($data); $i++){
            $item = $data[$i];
            try {
                $path = $this->main->base_folder . $item;
                $this->loadPlugin($path);
            } catch (\Throwable $th) {
                //throw $th;
                Log::error($th->getMessage());
            }
        }
    }

    public function loadPlugin($path){
        if($this->main->canloadplugin($path)){
            $plugin = json_decode(file_get_contents($path . '/' . PluginLoader::PLUGIN));
            $link = base_path('public/storage') . '/'  . $plugin->name . '.png';
            if(is_link($link)){
                unlink($link);
            }
            $target = $path . '/icon.png';
            if(!is_file($target)){
                $target = base_path('public/resources/' . PluginLoader::FOLDER . '/img/icon.png');
            }
            symlink($target, $link);
            $class = new class extends PluginBase{
                
            };
            $class->plugin = $plugin;
            $this->plugins[$plugin->name] = $class;
        }
    }
}