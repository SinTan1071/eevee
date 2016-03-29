<?php

namespace Core\Services;

use Laravel\Lumen\Application as Lumen;

class Application extends Lumen
{
    protected static $configures = [
      'app',
      'mail',
      'queue',
      'view',
      'cache',
      'routes',
      'system',
      'session',
      'database',
      'statuses',
      'shortcuts',
      'resources',
      'filesystems',
      'broadcasting',
    ];

    public function __construct($basePath)
    {
        date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

        $this->basePath = $basePath;

        $this->bootstrapContainer();

        $this->registerErrorHandling();

        $this->setConfigures();

        $this->setPermissionRoutes(config('routes'));
    }

    protected function setConfigures()
    {
        foreach (self::$configures as $file) {
            $this->configure($file);
        }
    }

    public function storagePath($path = null)
    {
        if ($this->storagePath) {
            return $this->storagePath.($path ? '/'.$path : $path);
        }

        return $this->basePath().'/Storage'.($path ? '/'.$path : $path);
    }

    public function path()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'core';
    }

    public function databasePath()
    {
        return $this->basePath().'/core/System/database';
    }

    protected function getLanguagePath()
    {
        return __DIR__.'/../System/locale';
    }

    public function getConfigurationPath($name = null)
    {
        if (!$name) {
            $appConfigDir = ($this->configPath ?: $this->basePath('config')).'/';

            if (file_exists($appConfigDir)) {
                return $appConfigDir;
            } elseif (file_exists($path = __DIR__.'/../System/config/')) {
                return $path;
            }
        } else {
            $appConfigPath = ($this->configPath ?: $this->basePath('config')).'/'.$name.'.php';

            if (file_exists($appConfigPath)) {
                return $appConfigPath;
            } elseif (file_exists($path = __DIR__.'/../System/config/'.$name.'.php')) {
                return $path;
            }
        }
    }

    protected function setPermissionRoutes($routes)
    {
        $this->group(['prefix' => 'api', 'middleware' => 'auth', 'namespace' => 'Core\Http\Controllers'], function () use ($routes) {

          foreach ($routes as $route => $params) {
              list($method, $uri) = explode('@', $route);

              if (isset($params['action'])) {
                  $this->addRoute(strtoupper($method), $uri, $params['action']);
              } else {
                  throw new \Exception('The action can\'t be empty', 1);
              }
          }
      });
    }
}
