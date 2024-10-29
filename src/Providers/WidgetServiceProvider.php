<?php

namespace DotMike\NmsWidgetAlertRules\Providers;

use DotMike\NmsWidgetAlertRules\Hooks\MenuEntry;

use LibreNMS\Interfaces\Plugins\PluginManagerInterface;
use LibreNMS\Interfaces\Plugins\Hooks\MenuEntryHook;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Lang;

use ReflectionClass;

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
        $this->extendDashboardWidgets();
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

        // Workaround to merge existing translations with custom widget translations
        $locale = app()->getLocale();
        $group = 'widgets';
        $loader = Lang::getLoader();

        // Load existing translations for the 'widgets' group
        $existingTranslations = $loader->load($locale, $group);
        $existingTranslations = array_combine(
            array_map(fn($key) => 'widgets.' . $key, array_keys($existingTranslations)),
            $existingTranslations
        );

        // Load custom widget translations and prefix them with 'widgets.'
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', $pluginName);
        $myTranslations = Lang::get($pluginName . '::widgets');
        $prefixedMyTranslations = array_combine(
            array_map(fn($key) => 'widgets.' . $key, array_keys(Arr::dot($myTranslations))),
            Arr::dot($myTranslations)
        );

        // Merge existing translations with custom widget translations
        $mergedTranslations = array_merge($existingTranslations, $prefixedMyTranslations);
        Lang::addLines($mergedTranslations, $locale);
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


    protected function extendDashboardWidgets()
    {
        $controller = new ReflectionClass(\App\Http\Controllers\DashboardController::class);

        // Access the static property
        $property = $controller->getProperty('widgets');
        $property->setAccessible(true);
        $currentWidgets = $property->getValue();

        $currentWidgets[] = 'widget-alert-rules';

        // Set the modified array back
        $property->setValue(null, $currentWidgets);
    }
}
