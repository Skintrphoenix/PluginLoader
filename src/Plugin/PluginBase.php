<?php

namespace Skintrphoenix\PluginLoader\Plugin;

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
}