<?php

namespace Skintrphoenix\PluginLoader\Controller;

use App\Http\Controllers\Controller as ControllersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

abstract class Controller extends ControllersController{

    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    abstract public function controller(Request $request, array $args);

    public function register(){
        $class = static::class;
        Route::any($this->name, function() use($class){
            $class2 = new $class;

            $data = str_replace(request()->root() . '/', '', url()->current());
            $data2 = explode('/', request()->route()->uri());
            $data3 = explode('/', $data);
            $data4 = array_combine($data2, $data3);
            foreach($data4 as $key => $item){
                if(str_contains($key, '{') && str_contains($key, '}')){
                    $data4[str_replace(['{', '}'], ['', ''], $key)] = $item;
                }
                unset($data4[$key]);
            }

            $class2->controller(request(), $data4);
        });
    }
}