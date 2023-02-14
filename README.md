# PluginLoader
Plugin Loader for laravel

## Quick Installation

```bash
composer require skintrphoenix/plugin-loader
```
### Configuration

Add This code to \App\Providers\AppServiceProvider on method boot
```php
$plugin = new \Skintrphoenix\PluginLoader\PluginLoader();
$plugin->refreshPlugin();
```

### Configuration (Optional)

Add This code to \App\Providers\AppServiceProvider on method boot
(this for auto load all plugins on laravel is start)
```php
$plugin = new \Skintrphoenix\PluginLoader\PluginLoader();
$plugin->loadPlugins();
```

## Example Plugin

- [Testing](https://github.com/Skintrphoenix/TestingPlugin)
