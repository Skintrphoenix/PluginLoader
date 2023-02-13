# PluginLoader
Plugin Loader for laravel

## Quick Installation

```bash
composer require skintrphoenix/plugin-loader
```

### Configuration (Optional)

Add This code to \App\Providers\AppServiceProviders on method boot
```bash
$plugin = new \Skintrphoenix\PluginLoader\PluginLoader();
```

## Example Plugin

- [Testing](https://github.com/Skintrphoenix/TestingPlugin)