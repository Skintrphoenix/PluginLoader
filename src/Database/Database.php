<?php

namespace Skintrphoenix\PluginLoader\Database;

use Illuminate\Support\Facades\Schema;

class Database{

    public function __construct()
    {
        if(!Schema::hasTable('plugins')){
            (new CreatePluginsTable())->up();
        }
    } 
}