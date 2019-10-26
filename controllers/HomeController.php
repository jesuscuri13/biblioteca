<?php
use Amazonia\PlController;
class HomeController extends PlController {
	public function __construct() {
		parent::__construct();
	}

	public function _GET($vars) {
		$app = $this->app;
		
		return $app->template("templates/loginTemplate.php");
	}
}