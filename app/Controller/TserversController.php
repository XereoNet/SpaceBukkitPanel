<?php

/**
*
*   ####################################################
*   TServersController.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is relative to the "Servers" page and it's related functions.
*   This includes CraftBukkit version choosing, config saving and schedules
*
*   TABLE OF CONTENTS
*   
*   1)  index
*   2)  install_cb
*   3)  saveConfig
*   
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class TServersController extends AppController {

    public $helpers = array('Html','Form');

    public $components = array('RequestHandler');

    public $name = 'TServersController';

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

    function index() {
        

        /*

        *   Connection Check - Is the server running? Redirect accordingly.

        */

        include '../spacebukkitcall.php';
        
        //CHECK IF SERVER IS RUNNING

        $args = array();   
        $running = $api->call("isServerRunning", $args, true);
        
        $this->set('running', $running);

        //IF "FALSE", IT'S STOPPED. IF "NULL" THERE WAS A CONNECTION ERROR

        if (is_null($running)) {

        $this->layout = 'sbv1_notreached'; 
                     
        } 

        elseif (!$running) {

        $this->layout = 'sbv1_notrunning';

        } 

        elseif ($running) {

        //IF IT'S RUNNING, CONTINUE WITH THE PROGRAM

        $this->set('title_for_layout', __('Server'));

        //CraftBukkit chooser information
/*
        $args = array();   
        $server = $api->call("getServer", $args, false);

        $filename = 'http://ci.bukkit.org/other/latest_recommended.rss';
        $bukkitxml = simplexml_load_file($filename);
         
        $json = json_encode($bukkitxml);
        $bukkitxml = json_decode($json, TRUE);
        
        $this->set('versions', $bukkitxml["channel"]["item"]);
        $this->set('server', $server);
*/
        //CraftBukkit configuration information

        $args = array("server.properties");   
        $properties = $api->call("getFileContent", $args, true);

        foreach(preg_split("/(\r?\n)/", $properties) as $line){

            $config = explode("=", $line);

            $cname = trim(str_replace('-','_',$config[0]));
          
            if (isset($config[1])) {

            $this->set($cname, $config[1]);

            }
        
        }

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
        'Say something' => array('method' => 'say', 'args' => true),
		'Run console command' => array('method' => 'consoleCommand', 'args' => 'needsargs'),
		'Start server' => array('method' => 'start', 'args' => false),
		'Stop server' => array('method' => 'stop', 'args' => false)
		
            );

       $this->set('tasks', $tasks);
        
        //view-specific settings
        $this->layout = 'sbv1';
    }
        
    }

    function install_cb($cb = null) {

        set_time_limit(300);

        if ($this->request->is('post')) {
           $cb = $this->request->data["cb"];
        }            

        //Check if version exists

        //(c) Bertware 2011
        //www.bertware.net
        $url = 'http://ci.bukkit.org/job/dev-CraftBukkit/lastSuccessfulBuild/';
        $file = fopen ($url,"r");
        if (!$file) {
        echo "<p>Unable to open remote file.\n";
        exit;
        }
        while (!feof ($file)) {
        $line = fgets ($file, 1024);
        /* This only works if the title and its tags are on one line */
        if (eregi ("<title>(.*)</title>", $line, $out)) {
        $pieces = explode("#", $out[1]);
        $latest_build = substr($pieces[1], -14, 4);
         }
        }
        fclose($file);

        if($cb > $latest_build) {
            exit("Build does not exist.");
        }
   
        include("../spacebukkitcall.php");

        //stop the server

        $args = array();   
        $running = $api->call("isServerRunning", $args, true);

        if($running == 'true')
        {
             $api->call("stopServer", $args, true);
        }

        //delete old CB

        $args = array("toolkit/wrapper.properties");   
        $config = $api->call("getFileContent", $args, true);
               
        //Function to get strings
        function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
        }

        $old_jar = trim(get_string_between($config, "minecraft-server-jar=", "\n"));

        $i = 1;
        while ($i < 10) {

            $running = $api->call("isServerRunning", $args, true);

            if($running == 0)
            {
                $i = 10;
            } else {
                
             $i++;
             sleep(2);

            }

        }

        if($i == 11)
        {
            exit('Error: could not stop the server');
        }

        $args = array($old_jar);   
        $api->call("deleteFile", $args, true);  
     
        //get new CB

        $url = 'http://ci.bukkit.org/job/dev-CraftBukkit/'.$cb.'/';

        $cibukkit = file_get_contents($url);

        $jarfile = get_string_between($cibukkit, '<a href="artifact/target/', '">');

        $new_jar = 'http://ci.bukkit.org/job/dev-CraftBukkit/'.$cb.'/artifact/target/'.$jarfile;
            
        //send new CB

        sleep(3);

        $args = array($new_jar, $old_jar);   
        $api->call("sendFile", $args, true);   

        sleep(10);

        //start server
        $args = array();
        $api->call("startServer", $args, true);       

        //Dummy call to listen for reload   
        $args = array();   
        $api->call("getOPs", $args, false);

        w_serverlog($this->Session->read("current_server"), __('[SERVERS] ').$this->Auth->user('username').__(' installed CraftBukkit v').$cb);
        sleep(2);

        $this->redirect($this->referer());
            
    }

        function saveConfig() {

        include("../spacebukkitcall.php");

        //Function to get strings
        function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
        }

        //request replacement data
        $new = $this->request->data;

        //if a checkbox isn't marked it doesn't respond. We set these to false
        if (NULL == isset($new['allow-nether'])) {
            $new['allow-nether'] = "false";
        }
        if (NULL == isset($new['allow-flight'])) {
            $new['allow-flight'] = "false";
        }
        if (NULL == isset($new['enable-query'])) {
            $new['enable-query'] = "false";
        }
        if (NULL == isset($new['enable-rcon'])) {
            $new['enable-rcon'] = "false";
        }
        if (NULL == isset($new['white-list'])) {
            $new['white-list'] = "false";
        }
        if (NULL == isset($new['spawn-animals'])) {
            $new['spawn-animals'] = "false";
        }
        if (NULL == isset($new['online-mode'])) {
            $new['online-mode'] = "false";
        }
        if (NULL == isset($new['spawn-monsters'])) {
            $new['spawn-monsters'] = "false";
        }
        if (NULL == isset($new['pvp'])) {
            $new['pvp'] = "false";
        }

        //remove the save variable (doesn't need to be set)
        unset($new['save']);
        //set the file
        foreach($new as $n => $i){
            $name = "server";
            if(is_numeric($i)){
                $type = "int";
            }else if($i == "true" || $i == "false"){
                $type = "boolean";
            }else{
                $type = "string";
            }
            $key = $n;
            $value = $i;
            $args = array($name, $type, $key, $value);
            $api->call("editPropertiesFile", $args, false);
        }

        w_serverlog($this->Session->read("current_server"), __(__('[SERVERS] ')).$this->Auth->user('username').__(' update the server.properties'));

        $this->Session->write('Page.tab', 2);

        $this->redirect($this->referer());
        
    }

    /*function saveConfig() {

        include("../spacebukkitcall.php");

        //Function to get strings
        function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
        }

        //load config
     
        $args = array("server.properties");   
        $old = $api->call("getFileContents", $args); 

        $new = $this->request->data;
       
        //replace config

        foreach ($new as $config => $value) {
                
            $old_value = get_string_between($old, $config."=", "\n");

            $old = str_replace($old_value, $value, $old);
        }

        //stop server
        $args = array();
        $api->call("stopServer", $args);       

        //save config
        
        sleep(5);

        $args = array("server.properties", $old);   
        $api->call("setFileContents", $args);       

        //start server
        $args = array();
        $api->call("startServer", $args);       

        //Dummy call to listen for reload   
        $args = array();   
        $api->call("getWorlds", $args);

        w_serverlog($this->Session->read("current_server"), __('[SERVERS] ').$this->Auth->user('username').__(' update the server.properties'));

        $this->Session->write('Page.tab', 2);

        $this->redirect($this->referer());
        
    }*/

    function addTask() {

        if (!$this->request->is('post')) {
        throw new MethodNotAllowedException();
        } else {

        include("../spacebukkitcall.php");

        $data = $this->request->data;

        $type = $data["type"];

        $argument = "";
        $argument .= $data["arguments"];

        $timeType = $data["timeType"];
        $timeArgument1 = $data["timeArgument1"];

        if (is_numeric($data["timeArgument2"])) {
            $timeArgument2 = $data["timeArgument2"];
        } else $timeArgument2 = "0";


        $args = array($type, $argument, $timeType, $timeArgument1, $timeArgument2);
                    
        $api->call("addTask", $args, true);   

        $this->Session->write('Page.tab', 3);

        $this->redirect($this->referer());

        }   
    }

    function getTasks() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include("../spacebukkitcall.php");

        $args = array();   
        $tasks = $api->call("getTasks", $args, true);   
        
        $i = 1;
        $num = count($tasks);
         
        echo '{ "aaData": [';  

        foreach ($tasks as $id => $task) {

            $argument = $task[1];

            if ($task[0] == 1) {
                $type = __('Backup Worlds');
            } elseif ($task[0] == 2) {
                $type = __('Disable Whitelisting');
            } elseif ($task[0] == 3) {
                $type = __('Enable Whitelisting');
            } elseif ($task[0] == 4) {
                $type = __('Restart Server');
            } elseif ($task[0] == 5) {
                $type = __('Restart Server (if empty)');
            } elseif ($task[0] == 6) {
                $type = __('Save Worlds');
            } elseif ($task[0] == 7) {
                $type = __('Say something');
            } elseif ($task[0] == 8) {
                $type = __('Execute command');
            } elseif ($task[0] == 9) {
                $type = __('Start Server');
            } elseif ($task[0] == 10) {
                $type = __('Stop Server');
            }


            if ($task[2] == 1) {
                $timeType = __('Every X Hours');
            } elseif ($task[2] == 2) {
                $timeType = __('Every X Minutes');
            } elseif ($task[2] == 3) {
                $timeType = __('Once per day at X:Y');
            } elseif ($task[2] == 4) {
                $timeType = __('At X minutes after every hour');
            }

            $timeArg1 = $task[3];
            $timeArg2 = $task[4];
            $actions = '<a href=\"./tservers/runTask/'.$task[0].'/'.$argument.'\" class=\"button icon approve\">'.__('Run now').'</a><a href=\"./tservers/removeTask/'.$id.'\" class=\"button icon remove danger\">'.__('Remove').'</a>';

        ECHO <<<END
            [
              "$id",
              "$type",
              "$argument",
              "$timeType",
              "$timeArg1 : $timeArg2",
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

    function removeTask($task) {

        include("../spacebukkitcall.php");

        $args = array($task);   
        $tasks = $api->call("removeTask", $args, true);

        $this->Session->write('Page.tab', 3);

        $this->redirect($this->referer());
   
    }

    function runTask($task, $param) {

        include("../spacebukkitcall.php");
        $args = array();   

            if ($task == 1)  {

            }       elseif ($task == 2)  {

        $tasks = $api->call("disableWhitelisting", $args, false);

            }       elseif ($task == 3)  {

        $tasks = $api->call("enableWhitelisting", $args, false);

            }       elseif ($task == 4)  {

        $tasks = $api->call("restartServer", $args, true);

            }       elseif ($task == 5)  {


            if (count($api->call("getPlayers", $args, false)) == 0) {

                $tasks = $api->call("restartServer", $args, true);  

            }

            }       elseif ($task == 6)  {

        $tasks = $api->call("saveMap", $args, false);

            }       elseif ($task == 7)  {

        $args = array($param);   
        
        $tasks = $api->call("broadcast", $args, false);

            }       elseif ($task == 8)  {

        $args = array($param);   
        
        $tasks = $api->call("runConsoleCommand", $args, false);

            }       elseif ($task == 9)  {

        $tasks = $api->call("startServer", $args, true);

            }       elseif ($task == 10)  {

        $tasks = $api->call("stopServer", $args, true);

            }      


        $this->Session->write('Page.tab', 3);

        $this->redirect($this->referer());
   
    }

}
