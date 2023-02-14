# PluginLoader
Plugin Loader for laravel

## Quick Installation

```bash
composer require skintrphoenix/plugin-loader
```

### Configuration (Optional)

Add This code to \App\Providers\AppServiceProvider on method boot
(this for auto load plugins on laravel is start)
```bash
$plugin = new \Skintrphoenix\PluginLoader\PluginLoader();
$plugin->loadPlugins();
```

## Example Plugin

- [Testing](https://github.com/Skintrphoenix/TestingPlugin)
