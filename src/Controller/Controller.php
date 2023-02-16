<?php

namespace Skintrphoenix\PluginLoader\Controller;

use App\Http\Controllers\Controller as ControllersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Skintrphoenix\PluginLoader\Plugin\PluginBase;

abstract class Controller extends ControllersController{

    private $url_name;

    private $plugin;

    private $middlewares = [];

    private $route_name;

    public function __construct(string $url_name, string $route_name = null, PluginBase $plugin, array $middleware = [])
    {
        $this->url_name = $url_name;
        $this->route_name = $route_name;
        $this->plugin = $plugin;
        $this->middlewares = $middleware;
    }

    abstract public function controller(Request $request, array $args);

    public function getUrlName() : string{
        return $this->url_name;
    }
    
    public function getRouteName():?string{
        return $this->route_name;
    }

    public function getPlugin() : PluginBase{
        return $this->plugin;
    }

    public function getMiddleware()
    {
        return $this->middlewares;
    }
}