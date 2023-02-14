<?php

namespace Skintrphoenix\PluginLoader\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Skintrphoenix\PluginLoader\Plugin\PluginGet;
use Skintrphoenix\PluginLoader\PluginIds;
use Skintrphoenix\PluginLoader\PluginLoader;

class PluginController extends Controller implements PluginIds
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plugin = new PluginGet();
        $plugins = $plugin->getAllPlugins();
        return view(self::FOLDER . '.index', compact('plugins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $plugin = new PluginLoader();
        if($request->type == 'load'){
            $plugin->loadPlugin($request->name);   
            return 'success.load';
        }else{
            $plugin->unload($request->name);
            return 'success.unload';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
