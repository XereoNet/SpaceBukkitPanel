<?php
class InstallController extends AppController{
    
    function beforeFilter() {
        $this->Auth->allow('*');
        parent::beforeFilter();  
        $install = new File(TMP."inst.txt");

        if (!$install->exists()) exit("You are not allowed to be here!");
        
    }

    function index() {


      $this->layout = 'install';

      /* Check environment */
     
    }
  
    function step2() {

      $this->layout = 'install';
     
    }
  
    function step3() {

      $this->layout = 'install';
     
    }

    function step4() {

      $this->layout = 'install';
     
    }

    function step5() {

      $this->layout = 'install';
     
    }    
}
