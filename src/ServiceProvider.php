<?php namespace Baas\Generator;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */

	public function provides()
	{
		return ['baasgenerator'];
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('baasgenerator', function ($app)
		{
			$baasgenerator = $this->app->make('Baas\Generator');

			return $baasgenerator;
		});
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$configFile = __DIR__ . '/../config/config.php';

		$this->mergeConfigFrom($configFile, 'baasgenerator');

		$this->publishes([
			$configFile => config_path('baasgenerator.php')
		]);

		$this->registerBaasRoutes();
	}

	// This method can be overridden in a child class
	public function registerBaasRoutes()
	{
		// Load the baas routes file
		if (file_exists($file = $this->app['path.base'].'/routes/baas.php'))
		{
			require $file;
		}
	}
}