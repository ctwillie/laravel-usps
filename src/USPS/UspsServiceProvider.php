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
		$this->app->singleton('usps', function() {
		
			return new Usps();

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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {

      return array('usps');
      
    }
}
