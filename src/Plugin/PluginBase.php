<?php

namespace Skintrphoenix\PluginLoader\Plugin;

abstract class PluginBase{

    public function __construct()
    {
        $this->onLoad();
    }

    public function isEnable():bool{
        return false;
    }

    protected function onLoad():void{

    }
}