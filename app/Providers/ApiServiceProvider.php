<?php namespace CS\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;


class ApiServiceProvider extends ServiceProvider {

	public function boot(Router $router)
	{
		parent::boot($router);
	}

	public function map(Router $router)
	{
		$router->group(['prefix' => 'api','namespace' => 'CS\Http\Api\Controllers'],function(Router $roueter)
		{
			require_once app_path('Http/Api/routes.php');
		});
	}

}
