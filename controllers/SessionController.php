<?php
if (!defined ('AMPATH')) die ('Impossible access from outside');

use Amazonia\PlController;
class SessionController extends PlController {
	public function __construct() {
		parent::__construct();
		
	}

	public function _GET($vars) {
		$turn = new stdClass;
		$session = $this->app->service('Session');
		$messages = $this->app->service('Messages');
		
		if ($session->user == NULL) {
			$turn->message = $messages->unStarted;
			$turn->tokenized = $this->app->isTokenized();
		} else {
			$turn->user = $session->user;
			unset ($turn->user->password);
		}
		echo json_encode ($turn);
		return;
    }
    
    public function _POST ($vars) {
		$turn = new stdClass;
		$session = $this->app->service('Session');
		
		$this->model = new SessionModel($this->app);
		$row = $this->model->login ($this->app->request);
		$session->setCurrentUser ($row);

		$turn->user = $session->user;
		unset($turn->user->password);
		echo json_encode ($turn);
    }
}