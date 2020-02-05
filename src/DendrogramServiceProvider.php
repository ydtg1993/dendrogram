<?php
/**
 * Copyright
 *
 * (c) Huang Yi <coodeer@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DenDroGram;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DendrogramServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->loadMigrations();
        $this->setupConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        return ['dendrogram'];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        
    }

    /**
     * Publish config.
     */
    protected function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('dendrogram.php')], 'config');
    }

    /**
     * Load migrations.
     */
    protected function loadMigrations()
    {
        $path = $this->getMigrationsPath();
        $this->loadMigrationsFrom($path);
    }

    /**
     * Setup config.
     */
    protected function setupConfig()
    {
        $path = $this->getConfigPath();
        $this->mergeConfigFrom($path, 'dendrogram');
    }

    /**
     * @return string
     */
    protected function getMigrationsPath()
    {
        return realpath(__DIR__ . '/../database/migrations/');
    }

    /**
     * @return string
     */
    protected function getConfigPath()
    {
        return realpath(__DIR__ . '/../config/dendrogram.php');
    }
}
