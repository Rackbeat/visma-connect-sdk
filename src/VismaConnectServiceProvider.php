<?php

namespace Rackbeat\VismaConnect;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Rackbeat\VismaConnect\API;
use Rackbeat\VismaConnect\VismaConnectClient;

class VismaConnectServiceProvider extends ServiceProvider
{
	/**
	 * @return void
	 */
	public function boot() {
		$this->publishes( [
			__DIR__ . '/../config/visma_connect.php' => config_path( 'visma_connect.php' ),
		], 'config' );

		$this->app->singleton('VismaConnect', function($app) {
			return new VismaConnectClient();
		});
	}

	/**
	 * @return void
	 */
	public function register() {
		$this->mergeConfigFrom( __DIR__ . '/../config/visma_connect.php', 'visma_connect' );
	}
}