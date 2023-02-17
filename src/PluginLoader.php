<?php

namespace Skintrphoenix\PluginLoader;

use Closure;
use Illuminate\Support\Facades\Log;
use PDO;
use Skintrphoenix\PluginLoader\Database\Database;
use Skintrphoenix\PluginLoader\Models\Plugin;
use Skintrphoenix\PluginLoader\Plugin\PluginBase;
use Skintrphoenix\PluginLoader\Web\Web;

spl_autoload_register(function($class_name){
    require 'Autoload.php';
    $data2 = explode('\\', $class_name);
    $data = rsearch(base_path('plugins/'),'/.*\/'. $data2[count($data2) - 1] . '.php/');
    foreach($data as $item){
        if(!class_exists($class_name)){
            require $item;
        }
    }
});

class PluginLoader implements PluginIds{

    public $base_folder;

    private $plugins = [];

    private $cache = [];

    public function __construct(){
        $this->base_folder = base_path(self::FOLDER) . '/';
        if(!is_dir($this->base_folder)){
            @mkdir($this->base_folder);
        }
        @mkdir($this->base_folder . self::DATA_FOLDER);
        $file = $this->base_folder . '.gitignore';
        if(!file_exists($file)){
            file_put_contents($file, '*
!.gitignore');
        }
        $web = new Web();
        $db = new Database();
    }

    public function loadPlugin($name):void{
        $data = scandir($this->base_folder);
        for($i = 2; $i < count($data); $i++){
            $item = $data[$i];
            try {
                $path = $this->base_folder . $item;
                if($this->canloadplugin($path)){
                    $plugin = json_decode(file_get_contents($path . '/' . self::PLUGIN));
                    if($name == $plugin->name){
                        $class = $this->validateClass($path, $plugin->main, $name, $plugin);
                        $link = base_path('public/storage') . '/' . self::FOLDER . '/'  . $plugin->name . '.png';
                        if(is_link($link)){
                            unlink($link);
                        }
                        $target = $path . '/icon.png';
                        if(!is_file($target)){
                            $target = base_path('public/resources/' . self::FOLDER . '/img/icon.png');
                        }
                        symlink($target, $link);
                        if(!is_null($class)){
                            if(!is_dir($class->getDataFolder())){
                                mkdir($class->getDataFolder());
                            }

                            require 'function.php';
                            custom_copy($path . '/' . 'resources', $class->getDataFolder());

                            $this->plugins[$plugin->name] = $class;
                            if(is_null(Plugin::where('name', $name)->first())){
                                $plugins = new Plugin();
                                $plugins->create(['name' => $plugin->name]);
                            }
                        }
                        
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                Log::error($th->getMessage());
            }
        }
    }

    public function unload(string $name):void{
        $data = scandir($this->base_folder);
        for($i = 2; $i < count($data); $i++){
            $item = $data[$i];
            try {
                $path = $this->base_folder . $item;
                $plugin = json_decode(file_get_contents($path . '/' . self::PLUGIN));
                $plugins = Plugin::where('name', $name)->first();
                unset($this->plugins[$name]);
                unset($this->cache[$name]);
                if(!is_null($plugins)){
                    $plugins->delete();
                }
            } catch (\Throwable $th) {
                //throw $th;
                Log::error($th->getMessage());
            }
        }
    }

    public function refreshPlugin(){
        foreach(Plugin::all() as $name){
            $this->loadPlugin($name->name);
        }
    }

    public function loadPlugins():void{
        $data = scandir($this->base_folder);
        for($i = 2; $i < count($data); $i++){
            $item = $data[$i];
            try {
                $path = $this->base_folder . $item;
                $plugin = json_decode(file_get_contents($path . '/' . self::PLUGIN));
                $this->loadPlugin($plugin->name);
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

    public function validateClass(string $path,string $main, string $name, $plugin):?PluginBase{
        $class_file = $path . "/src/" . $main;
        $class_file = str_replace('\\', '/', $class_file);
        $class = new $main($plugin, $this->base_folder . self::DATA_FOLDER . '/' . $plugin->name);
        if($class instanceof PluginBase){
            return $class;
        }
        return null;
    }

}