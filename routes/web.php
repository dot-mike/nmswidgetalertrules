<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth'], 'guard' => 'auth'], function () {
    Route::namespace('DotMike\NmsWidgetAlertRules\Http\Controllers')->group(function () {
        // named routes uses prefix plugin.nmswidgetalertrules.
        Route::name('plugin.nmswidgetalertrules.')->group(function () {

            // Admin routes
            Route::prefix('plugin/settings/nmswidgetalertrules')->group(function () {
                Route::get('/', 'PluginAdminController@index')->name('index');
                Route::get('/test', 'Widgets\AlertRulesController@getView')->name('test');
            });

            // Ajax routes
            Route::prefix('ajax')->group(function () {
                // js select2 data controllers
                Route::prefix('select')->namespace('Select')->group(function () {
                    Route::get('alert-rules', 'AlertRulesController')->name('ajax.select.alert-rules');
                });

                // dashboard widgets
                Route::prefix('dash')->namespace('Widgets')->group(function () {
                    Route::post(
                        'widget-alert-rules',
                        'AlertRulesController'
                    );
                });
            });
        });
    });
});
