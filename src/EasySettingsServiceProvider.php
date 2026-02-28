<?php

namespace LiveControls\EasySettings;

use Illuminate\Support\ServiceProvider;

class EasySettingsServiceProvider extends ServiceProvider
{
  public function register()
  {
  }

  public function boot()
  {
    if ($this->app->runningInConsole()) {
      if (!class_exists('CreateEasySettingsTable')){
        $this->publishes([
          __DIR__ . '/../database/migrations/create_easy_settings_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_easy_settings_table.php'),
          // you can add any number of migrations here
        ], 'livecontrols.easy_settings.migrations');
      }
    }
  }
}
