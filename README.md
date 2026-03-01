# Easy Settings
Simple settings library for easily accessable configurations

## Setup
1. Publish migrations
```ps
php artisan vendor:publish livecontrols.easy_settings.migrations
```
2. Migrate
```ps
php artisan migrate
```

## Usage
**Set settings**
This will set a specific value (can be any json compatible value) to a specific key. This will also update a value if it already exists.
```ps
\LiveControls\EasySettings\EasySettings::set('key', 'value');
```

**Get settings**
This will get a specific value and stores it to the cache if set.
```ps
\LiveControls\EasySettings\EasySettings::get('key', 'default', 120); //Will return a string 'default' if value can't be found and stores it for 120 seconds
```

**Forget settings**
This will remove the setting with the specific key from the cache.
```ps
\LiveControls\EasySettings\EasySettings::forget('key');
```

**Delete settings**
This will delete the setting with the specific key from the database and cache.
```ps
\LiveControls\EasySettings\EasySettings::forget('key');
```