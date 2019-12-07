<?php
use Amazonia\PlService;
use Amazonia\PlException;


class SessionService extends PlService {
    private $uri = [];
    private $nodos = [];
    private $_default = null;

    public function __construct() {
        
    }
    public function onStart() {
        $this->model = new SessionModel($this->app);
        $this->userType = NULL;
        $this->user = NULL;
        $this->sessionStarted = false;
    }
    
    public function start () {
        $this->messages = $this->app->service('Messages');
        if ($this->sessionStarted) {
            throw new PlException ($this->messages->sessionStarted, 500);
        }
        $this->loadCurrentUser();
        $this->sessionStarted = true;
    }

    public function loadCurrentUser () {
        if ($this->app->isTokenized()) {
            if ($this->app->isIn('access_token')) {
                $this->userType = NULL;
                $this->user = NULL;
            } else {
                //$this->model->setId ('');
            }
        } else {
            session_start();
            if (!isset($_SESSION['_user'])) {
                $_SESSION['_user'] = [];
            }

            if (isset ($_SESSION['_user']['_id'])) {
                $this->model->setId ($_SESSION['_user']['_id']); 
                $this->model->refresh();
                
                if ($this->model->isAvailable()) {
                    $this->user = $this->model->getData();
                } else {
                    unset ($_SESSION['user']);
                }
            }
        }
    }

    public function setCurrentUser ($row) {
        if ($this->app->isTokenized()) {

        } else {
            $_SESSION['_user'] = [
                '_id' => $row->id
            ];
            $this->user = $row;
            $this->userType = NULL;
        }
    }

    
}