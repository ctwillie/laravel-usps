# Laravel-Usps

This package provides a very simple wrapper for the United States Postal Service API. Currently, this package only provides address verification features, but will soon comprise all features offered by the USPS API. In the meantime, consider using [johnpaulmedina/laravel-usps](https://github.com/johnpaulmedina/laravel-usps), which is a great package.

### Prerequisites

Be sure to register at [www.usps.com/webtools/](www.usps.com/webtools/) to receive your unique user ID
from the United States Postal Service. This user ID is required to use this package.

### Installation

```
composer require ctwillie/laravel-usps
```

## Configuration

There are three important configurations.
1. Your USPS user ID:
    - If you have not received your USPS user ID, follow the link in the [prerequisites](#Prerequisites) section  to register with the 
      United States Postal Service. It is required to use this package.

2. Whether you want SSL verification enabled for API requests:
    - This setting is set to `true` by default for security reasons. You can override this behavior by setting the `verrifyssl` config     setting to `false`.   Do this at your own risk.

3. Which environment you are working in:
	- The options are 'local' and 'production' which tell the package which API url to use, testing or production respectively. If no configuration is found     for `env`, it will default to the environment recognized by laravel. This setting takes precedence over `APP_ENV` from `.env` file.

We recommend placing all configuration settings in your `.env` file and use Laravel's `env()` helper function to access these values.

In `config/services.php` add these three settings.

```php
'usps' => [

    'userid' => env('USPS_USER_ID'), // string
    'verifyssl' => env('USPS_VERIFY_SSL'), // bool
	'env' => env('USPS_ENV') //string
];
```

## Usage

The current features offered by this package are listed below.
 - [Address Verification](#Address)

## Contributing

Contributions are always welcomed and will receive full credit.

We accept contributions via Pull Requests on Github.

## Authors

* **Cedric Twillie**

See also the list of [contributors](https://github.com/ctwillie/laravel-usps/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

