<?php

namespace DotMike\NmsWidgetAlertRules\Providers;

use DotMike\NmsWidgetAlertRules\Hooks\MenuEntry;

use LibreNMS\Interfaces\Plugins\PluginManagerInterface;
use LibreNMS\Interfaces\Plugins\Hooks\MenuEntryHook;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(PluginManagerInterface $pluginManager): void
    {
        $pluginName = 'nmswidgetalertrules';
        $pluginManager->publishHook($pluginName, MenuEntryHook::class, MenuEntry::class);

        // if plugin is disabled, don't boot it
        if (! $pluginManager->pluginEnabled($pluginName)) {
            return;
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', $pluginName);
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', $pluginName);
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    protected function registerBindings(): void
    {
        View::composer('nmswidgetalertrules::*', function ($view) {
            $view->with('nmswidgetalertrules_version', $this->getVersion());
        });
    }

    protected function getVersion(): string
    {
        $composerFile = __DIR__ . '/../../composer.json';
        $composerData = json_decode(file_get_contents($composerFile), true);
        return $composerData['version'] ?? 'unknown';
    }
}
