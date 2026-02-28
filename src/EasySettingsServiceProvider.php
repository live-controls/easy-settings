<?php

namespace LiveControls\EasySettings;

use Illuminate\Support\ServiceProvider;

class EasySettingsServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'livecontrols_easysettings');
  }

  public function boot()
  {
    $this->publishes([
      __DIR__.'/../config/config.php' => config_path('livecontrols_easysettings.php'),
    ], 'livecontrols.easysettings.config');

    if ($this->app->runningInConsole()) {
      if (!class_exists('CreateEasySettingsTable')){
        $this->publishes([
          __DIR__ . '/../database/migrations/create_easy_settings_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_easy_settings_table.php'),
          // you can add any number of migrations here
        ], 'migrations');
      }
    }
  }
}
