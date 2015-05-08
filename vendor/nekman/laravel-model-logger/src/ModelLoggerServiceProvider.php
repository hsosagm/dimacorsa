<?php

namespace NEkman\ModelLogger;

use \Illuminate\Support\ServiceProvider;
use NEkman\ModelLogger\Command;

class ModelLoggerServiceProvider extends ServiceProvider {

	public function register() {
		$this->app['migrate'] = $this->app->share(function($app) {
			return new Command\CreateMigration;
		});
		
		$this->app['delete-old'] = $this->app->share(function($app) {
			return new Command\DeleteOld;
		});

		$this->commands('migrate');
		$this->commands('delete-old');
	}

}
