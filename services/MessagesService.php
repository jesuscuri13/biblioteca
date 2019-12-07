<?php
use Amazonia\PlService;
use Amazonia\PlException;

class MessagesService extends PlService {
    
    public function __construct() { }

    public function __get ($name) {
        if (property_exists ($this, '_' . $name)) {
            return $this->{'_' . $name};
        }

        $trace = debug_backtrace();
        trigger_error(
            'Propiedad indefinida mediante __get(): ' . $name .
            ' en ' . $trace[0]['file'] .
            ' en la línea ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
    
    protected $_unStarted = 'No se ha iniciado sesión';
    protected $_sessionStarted = 'Tratando de iniciar sesión cuando ya se ha iniciado';

}