<?php
if (!defined ('AMPATH')) die ('Impossible access from outside');

use Amazonia\PlModel;
use Amazonia\Connection\PlSimpleSelect;
use Amazonia\PlApplication;
use Amazonia\PlException;

class SessionModel extends PlModel {
    public function __construct (PlApplication $app) {
        parent::__construct ($app, 'user', 'id');
        $this->onlyRulesAccepted = true;
        $this->addRule ('account', PlModel::REQUIRED);
        $this->addRule ('password', PlModel::REQUIRED);
        $this->app = $app;
    }

    public function login (stdClass $request) {
        $this->setData ($request);
        $this->checkData();
        $conn = $this->app->service ('DB');
        $select = new PlSimpleSelect ($this->table, ['*'], $this->idName);
        
        $select->state ('account', $this->data->account);
        $row = $conn->selectRow ($select->run(), $select->values);
        if ($row == NULL) {
            throw new PlException ('El usuario no existe', 400);
        }

        $passw = md5 ($this->data->password);
        if ($passw != $row->password) {
            throw new PlException ('La contraseña no es correcta', 400);
        }
        return $row;
        
    }
}