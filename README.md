# Laravel-Usps

This package provides a very simple wrapper for the United States Postal Service API. Currently, this package only provides address verification features, but will soon comprise all features offered by the USPS API. In the meantime, consider using [johnpaulmedina/laravel-usps](https://github.com/johnpaulmedina/laravel-usps), which is a great package.

### Prerequisites

Be sure to register at [www.usps.com/webtools/](www.usps.com/webtools/) to receive your unique user ID
from the United States Postal Service. This user ID is required to use this package.

### Installation

```
composer require ctwillie/laravel-usps
```

## Setup

Starting at Laravel 5.5, this package will be automatically discovered and registered as a service provider.
For earlier versions of Laravel, you will need to manually register this packages' service provider in `config/app.php`
by adding this class to the providers array.

```php
'providers' => [
    ...
    ctwillie\Usps\UspsServiceProvider::class
```
Then add an alias for the class also in `config/app.php` inside the aliases array.

```php
'aliases' => [
    ...
    'Usps' => ctwillie\Usps\UspsServiceProvider::class
```

## Configuration

There are two important configurations.
1. Your USPS user ID:
    - If you have not received your USPS user ID, follow the link in the [prerequisites section](#Prerequisites) to register with the 
      United States Postal Service. It is required to use this package.
2. Whether you want SSL verification enabled for API requests:
    - This setting is set to `true` by default for security reasons. You can override this behavior by setting the `verrifyssl` config     setting to `false`. Do this at your own risk. Or, you can take the steps neccessary to add the certificate to your machine to be     recognized.

In `config/services.php` add these two settings.

```php
'usps' => [
    'userId' => '**********',
    'verifyssl' => true
]
```

## Usage

Working on API usage instructions.

## Contributing

Contributions are always welcomed and will receive full credit.

We accept contributions via Pull Requests on Github.

## Authors

* **Cedric Twillie**

See also the list of [contributors](https://github.com/ctwillie/laravel-usps/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

