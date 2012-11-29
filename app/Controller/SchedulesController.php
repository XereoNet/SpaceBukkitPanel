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
        if (!($user_perm['pages'] & $glob_perm['pages']['servers'])) {
           exit("access denied");
        }
      }

    function add() {

        if ($this->request->is('ajax')) {

            $this->disableCache();
            //Configure::write('debug', 0);

            //schedules information
            //define possible tasks in the format $tasks["Task Name"] = array('method', array(arguments);
            //arguments: if not set, no arguments, if true, free text input, if text, dropdown

            $tasks = array(

            'Enable whitelist' => array('method' => 'consoleCommand', 'args' => 'whitelist on'),
            'Disable whitelist' => array('method' => 'consoleCommand', 'args' => 'whitelist off'),
            'Restart server' => array('method' => 'restart', 'args' => 'true'),
            'Restart server if empty' => array('method' => 'restartIfEmpty', 'args' => false),
            'Rotate server.log' => array('method' => 'rollOverLog', 'args' => false),
            'Save worlds' => array('method' => 'consoleCommand', 'args' => 'save-all'),
            'Say something' => array('method' => 'say', 'args' => 'needsargs'),
            'Run console command' => array('method' => 'consoleCommand', 'args' => 'needsargs'),
            'Start server' => array('method' => 'start', 'args' => false),
            'Stop server' => array('method' => 'stop', 'args' => false)

                );

            $this->set('tasks', $tasks);

            $this->layout = 'popup';

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


    function runTask($name=null) {
        if ($this->request->is('ajax'))
        {

        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';
        $args = array($name);
        $api->call('runJob', $args, true);
        echo __('Ran task: ').$name;
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

            echo '[{"optionValue": 1, "optionDisplay": "'.__('Every hour').'"}, ';

            for ($i = 2; $i <= 167; $i++) {
                echo '{"optionValue": '.$i.', "optionDisplay": "'.__('Every').' '.$i.' '.__('hours').'"}, ';
                $id++;
            }

            echo '{"optionValue": 168, "optionDisplay": "'.__('Every 168 hours (1 week)').'"}]';


        } elseif ($id == 2) {

            echo '[{"optionValue": 1, "optionDisplay": "'.__('Every minute').'"}, ';

            for ($i = 2; $i <= 59; $i++) {
                echo '{"optionValue": '.$i.', "optionDisplay": "'.__('Every').' '.$i.' '.__('minutes').'"}, ';
                $id++;
            }

            echo '{"optionValue": 60, "optionDisplay": "'.__('Every 60 minutes (1 hour)').'"}]';

        } elseif ($id == 3) {

            echo '[{"optionValue": 0, "optionDisplay": "00"}, ';

            for ($i = 1; $i <= 9; $i++) {
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

            if ($api->call("addJob", $args, true)) {
                echo __('yes');
            }



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

            echo __('The schedule').' '.$name.' '.__('was removed!');

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
