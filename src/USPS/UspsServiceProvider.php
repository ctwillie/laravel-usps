<?php

namespace ctwillie\Usps;

use Illuminate\Support\ServiceProvider;

class UspsServiceProvider extends ServiceProvider
{

  protected $defer = false;

  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    
    $this->app->singleton('usps', function () {

      $config = config('services.usps');

      if ( ! is_array($config) ) {

        throw new \Exception('USPS: Invalid configuration syntax defined in services.php. Configuration must be an array.');
      }

      // makes sure USPS username is defined in config
      if ( ! array_key_exists('username', $config) ) {

        throw new \Exception('USPS: A USPS username is required in services.php. None found.');
      }

      // if 'verifyssl' is not defined in config, default to true
      if ( ! array_key_exists('verifyssl', $config) ) {

        config(['services.usps.verifyssl' => true]);

      }

      return new Usps($config);
    
    });
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }

}
