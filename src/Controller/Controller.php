<?php

namespace Skintrphoenix\PluginLoader\Controller;

use App\Http\Controllers\Controller as ControllersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Skintrphoenix\PluginLoader\Plugin\PluginBase;

abstract class Controller extends ControllersController{

    private $name;

    private $plugin;

    private $middleware = [];

    public function __construct(string $name, PluginBase $plugin, array $middleware = [])
    {
        $this->name = $name;
        $this->plugin = $plugin;
        $this->middleware = $middleware;
    }

    abstract public function controller(Request $request, array $args);

    public function getName() : string{
        return $this->name;
    }

    public function getPlugin() : PluginBase{
        return $this->plugin;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }
}