# PluginLoader
Plugin Loader for laravel

## Quick Installation

```bash
composer require skintrphoenix/plugin-loader
```
### Configuration

Add This code to routes/web.php
```php
$plugin = new \Skintrphoenix\PluginLoader\PluginLoader();
$plugin->refreshPlugin();
```

Run this code on your terminal
```bash
php artisan storage:link
```

## Example Plugin

- [Testing](https://github.com/Skintrphoenix/TestingPlugin)
