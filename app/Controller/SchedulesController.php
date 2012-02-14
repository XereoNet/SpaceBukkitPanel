<?php

/**
*
*   ####################################################
*   TServersController.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is relative to the "Servers" page and is responsible for
*   schedules specifically.
*
*   
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class SchedulesController extends AppController {

    public $components = array('RequestHandler');

    public $name = 'SchedulesController';

    public function beforeFilter()

      {
        parent::beforeFilter();

        //check if user has rights to do this
        $user_perm = $this->Session->read("user_perm");
        $glob_perm = $this->Session->read("glob_perm");
         if ($user_perm['pages'] &! $glob_perm['pages']['server']) { 
            exit("access denied");
         } 
      }


    function run($call, $args) {

      if ($this->request->is('ajax')) 
        {

        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;
                
        require APP . 'spacebukkitcall.php';

        }
    }


    function runTask($id) {
        if ($this->request->is('ajax')) 
        {

        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;
                
        require APP . 'spacebukkitcall.php';
        $args = array($id);
        $api->call('runJob', $args, true);
        echo __('Ran task: ').$id;
        }
    }

    function getTimes($id) {
      if ($this->request->is('ajax')) 
        {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        //define time types
        $time_types = array('EVERYXHOURS', 'EVERYXMINUTES', 'ONCEPERDAYAT', 'XMINUTESPASTEVERYHOUR');
        
        if ($id == 1) {

            echo '[{"optionValue": 1, "optionDisplay": "Every hour"}, ';
            
            for ($i = 2; $i <= 167; $i++) {
                echo '{"optionValue": '.$i.', "optionDisplay": "Every '.$i.' hours"}, ';
                $id++;
            }

            echo '{"optionValue": 168, "optionDisplay": "Every 168 hours (1 week)"}]';

            
        } elseif ($id == 2) {
            
            echo '[{"optionValue": 1, "optionDisplay": "Every minute"}, ';
            
            for ($i = 2; $i <= 59; $i++) {
                echo '{"optionValue": '.$i.', "optionDisplay": "Every '.$i.' minutes"}, ';
                $id++;
            }

            echo '{"optionValue": 60, "optionDisplay": "Every 60 minutes (1 hour)"}]';

        } elseif ($id == 3) {

            echo '[{"optionValue": 1, "optionDisplay": "01"}, ';
            
            for ($i = 2; $i <= 9; $i++) {
                echo '{"optionValue": '.$i.', "optionDisplay": "0'.$i.'"}, ';
                $id++;
            }
            
            for ($i = 10; $i <= 22; $i++) {
                echo '{"optionValue": '.$i.', "optionDisplay": "'.$i.'"}, ';
                $id++;
            }

            echo ' {"optionValue": 23, "optionDisplay": "23"}]';

        } elseif ($id == 4) {

            echo '[{"optionValue": 0, "optionDisplay": "00"}, ';
            
            for ($i = 1; $i <= 9; $i++) {
                echo '{"optionValue": '.$i.', "optionDisplay": "0'.$i.'"}, ';
                $id++;
            }
            
            for ($i = 10; $i <= 58; $i++) {
                echo '{"optionValue": '.$i.', "optionDisplay": "'.$i.'"}, ';
                $id++;
            }
           
            echo ' {"optionValue": 59, "optionDisplay": "59"}]';

        }
        }                   
    }


    //function addTask

    function addTask() {

        if ($this->request->is('ajax')) 
        {

        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;
            
          if ($this->request->is('post')) { 

            $data = $this->request->data;

            $action = $data["type"];
            $arguments = $data["arguments"];
            $timetype = $data["timeType"];
            $id = $data["name"];

            if (!(isset($data["timeArgs2"]))) {
                $data["timeArgs2"] = 'null';
            }

            if ($data['timeArgs2'] == "null") {

               $timeargs = $data["timeArgs1"];
                
            } else {
               
               $timeargs = $data["timeArgs1"].':'.$data['timeArgs2'];

            }


            require APP . 'spacebukkitcall.php';
            
            $args = array($data["name"], $action, $arguments, $timetype, $timeargs);
             
            //debug($args);
     
            $api->call("addJob", $args, true);   

           
            
          } 
        }                 

    }

    //function removeTask

    function removeTask($name) {
        
    if ($this->request->is('ajax')) 
        {

        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;
            
            require APP . 'spacebukkitcall.php';
   
            $args = array($name);
             
            //debug($args);
     
            $api->call("removeJob", $args, true);  
            
            echo 'The schedule '.$name.' was removed!';
                      
        }                 
    }

    //function getTasks

    function getTasks() {

       if ($this->request->is('ajax')) {

        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';

        $args = array();   
        $tasks = $api->call("getJobs", $args, true);   
        
        $i = 1;
        $num = count($tasks);
         
        echo '{ "aaData": [';  

        foreach ($tasks as $id => $task) {

            $actions = '<a href=\"./schedules/runTask/'.$id.'\" class=\"button icon approve ajax_table1\">'.__('Run now').'</a><a href=\"./schedules/removeTask/'.$id.'\" class=\"button icon remove danger ajax_table1\">'.__('Remove').'</a>';

            $commands = $task["1"]["0"];

        ECHO <<<END
            [
              "$id",
              "$task[0]",
              "$commands",
              "$task[2]",
              "$task[3]",
              "$actions"
            ]
        
END;

        if($i < $num) {
            echo ",";
          }
          $i++;

        }
         echo '] }';

        }



    }

}
