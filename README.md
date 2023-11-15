# Deploy Artisan Command
Deploy is a Laravel package that provides artisan command to make deploy easier on server.

## Requirement

- php >= 5.6
- laravel >= 5.5

## Installation

#### You can install Deploy Artisan using Composer. Simply run the following command:

--------------
```bash
1- composer require "roshandelpoor/deploy":"dev-main"

important:: Only in Laravel version < 8
   2- add this line in config/app.php -> in part 'providers' => []
   Roshandelpoor\Deploy\DeployServiceProvider::class,
```

## Usage

#### To use Deploy Artisan in your project, simply using the Command Artisan. Here's an example:

```php
    php artisan deploy
```

## Contributing

If you find any bugs or have suggestions for new features, feel free to open an issue or submit a pull request on GitHub.

## License

Super Tools is open-source software licensed under the MIT license.
