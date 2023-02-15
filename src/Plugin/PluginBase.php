<?php

namespace Skintrphoenix\PluginLoader\Plugin;

use Illuminate\Support\Facades\Route;
use Skintrphoenix\PluginLoader\Controller\Controller;

abstract class PluginBase{

    public $plugin;

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
        Route::any($controller->getName(), function() use($class){
            $class2 = $class;

            $data = str_replace(request()->root() . '/', '', url()->current());
            $data2 = explode('/', request()->route()->uri());
            $data3 = explode('/', $data);
            $data4 = [];
            foreach($data3 as $key => $item){
                if(!in_array($item, $data2)){
                    $data4[] = $item;
                }
            }

            return $class2->controller(request(), $data4);
        });
        return true;
    }
}