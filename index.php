<?php

/**
 * Define very basic constants
 */
define("ENVIRONMENT", "development"); // [development|production]


/**
 * Check ENVIRONMENT
 */

if (ENVIRONMENT == "development") {
    error_reporting(E_ALL);
	ini_set('display_errors', '1');
} else if (ENVIRONMENT == "production") {
    ini_set('display_errors', 0);
} else {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Environment is invalid. Please contact developer for more information.';
    exit;
}

include ("amazonia/autoload.php");

use Amazonia\Services\Router;
use Amazonia\PlConexion\PlConexion;
use Amazonia\PlApplication;


define ('AMPATH', __DIR__);

$ssl = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] && $_SERVER["HTTPS"] != "off" 
     ? true 
     : false;
define("SSL_ENABLED", $ssl);

// URL of the application root. 
// This is not the URL of the app directory.
$app_url = (SSL_ENABLED ? "https" : "http")
         . "://"
         . $_SERVER["SERVER_NAME"]
         . (dirname($_SERVER["SCRIPT_NAME"]) == DIRECTORY_SEPARATOR ? "" : "/")
		 . trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");

define("AMURL", $app_url);

// Define Base Path (for routing)
$base_path = trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");
$base_path = $base_path ? "/" . $base_path : "";
define("AMBASE", $base_path);

class index extends PlApplication {
	protected $modelsPath = "models/";
	protected $servicesPath = "services/";
	protected $tokenized = false;

	public function __construct () {
		parent::__construct();
		$this->controllersPath = "controllers/";
		$this->mainResource = null;
	}
	protected function initialice () { }
}

$app = new index();
$app->service ("Router", new Router ());
$app->service ("Session", new SessionService ());
$app->service ("Messages", new MessagesService ());

$app->service ("DB", PlConexion::getConexion());
$app->config (["DB", function ($db) {
	$std = new stdClass;
	$std->dbDriver = 'mysql';
	$std->dbServer = 'localhost';
	$std->dbName = 'store';
	$std->dbUser = 'root';
	$std->dbPassword = '';
	$db->setConfig($std);
}]);
$app->config (["Session", function ($session) {
	$session->start();
}]);
$app->config (["Router", function ($router) {
	$router->byDefault ("HomeController");
	$router->ruteo ("login", "/", "HomeController");
	$router->ruteo ("session", "/resources/session", "SessionController");
	$router->start();
}]);
$app->run();