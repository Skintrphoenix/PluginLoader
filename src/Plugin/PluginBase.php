<?php

namespace Skintrphoenix\PluginLoader\Plugin;

use Illuminate\Support\Facades\Route;
use Skintrphoenix\PluginLoader\Controller\Controller;

abstract class PluginBase{

    public $plugin;

    public $data_folder;

    public function __construct()
    {
        $this->onLoad();
    }

    protected function onLoad():void{

    }

    public function getPluginFile():string{
        return $this->plugin;
    }

    public function register_route(Controller $controller):bool{
        $class = $controller;
        Route::middleware($controller->getMiddleware())->group(function() use($class, $controller){
            Route::any($controller->getUrlName(), function() use($class){
                $class2 = $class;
    
                $data = str_replace(request()->root() . '/', '', url()->current());
                $data2 = explode('/', request()->route()->uri());
                $data3 = explode('/', $data);
                $data4 = [];
                foreach($data2 as $key => $item){
                    if(str_contains($item, '{') && str_contains($item, '}')){
                        if(isset($data3[$key])){
                            $data4[] = $data3[$key];
                        }
                    }
                }
    
                return $class2->controller(request(), $data4);
            })->name($controller->getRouteName());
        });
        return true;
    }

    public function getDataFolder():? string{
        return $this->data_folder;
    }
}