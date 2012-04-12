<?php
class ConfigController extends AppController{
    
    function beforeFilter() {

        parent::beforeFilter();  

        $this->autoRender = null;
    }

    function test() {

      $this->loadModel('Configurator');

      $data = array('200', '33', '44', '66', '66', '66', '66');

      $this->Configurator->saveVars($data);

    }

}
