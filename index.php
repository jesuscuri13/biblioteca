<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include ("amazonia/autoload.php");

define ('DIRPATH', __DIR__ . '/');

use Amazonia\Services\Router;
use Amazonia\PlApplication;

class index extends PlApplication {
	protected $modelsPath = "models/";
	protected $servicesPath = "services/";
	protected $tokenized = true;

	public function __construct () {
		parent::__construct();
		$this->mainRoute = "/biblioteca2";
		$this->controllersPath = "controllers/";
		$this->mainPath = DIRPATH;
		$this->mainResource = null;
	}
	protected function initialice () { }
}

$app = new index();
$app->service ("Router", new Router());
$app->config (["Router", function ($router) {
	$router->byDefault ("HomeController");
	$router->ruteo ("login", "/", "HomeController");
	$router->ruteo ("session", "/resources/session", "SessionController");
	$router->start();
}]);
$app->run();