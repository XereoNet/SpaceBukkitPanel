<?php

class TTimelineController extends AppController {

    public $helpers = array ('Html','Form');

    public $name = 'TTimelineController';

    public function beforeFilter()

      {
        parent::beforeFilter();

        //check if user has rights to do this

      }

    function index() {  
        
        /*

        *   Connection Check - Is the server running? Redirect accordingly.

        */

        if (!isset($api)){
              require APP . 'spacebukkitcall.php';  
            }
        
        //CHECK IF SERVER IS RUNNING

        $args = array();   
        $running = $api->call("isServerRunning", $args, true);
        
        $this->set('running', $running);

        //IF "FALSE", IT'S STOPPED. IF "NULL" THERE WAS A CONNECTION ERROR

        if (is_null($running) || preg_match("/salt/", $running)) {

        $this->layout = 'sbv1_notreached'; 
                     
        } 

        elseif (!$running) {

        $this->layout = 'sbv1_notrunning';

        } 

        elseif ($running) {

        //IF IT'S RUNNING, CONTINUE WITH THE PROGRAM
        
        $this->layout = 'sbv1';  

        $this->set('title_for_layout', 'Permissions');

        }
    }

}