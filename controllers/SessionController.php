<?php
use Amazonia\PlController;
class SessionController extends PlController {
	public function __construct() {
		parent::__construct();
	}

	public function _GET($vars) {
		$app = $this->app;
		
		return ;
    }
    
    public function _POST ($vars) {
        var_dump ($vars, $this->app->request);
    }
}