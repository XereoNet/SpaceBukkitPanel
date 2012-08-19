<?php

/**
*
*   ####################################################
*   TWorldsController.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is relative to the "Worlds" page and responsible
*   for all it's operations. This includes backups, mainteneance and 
*   multiworld management
*   
*   TABLE OF CONTENTS
*   
*   1)  index
*   2)  mapautotrim
*   3)  chunkster
*   
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class TWorldsController extends AppController {

    public $helpers = array ('Html','Form');

    public $name = 'TWorldsController';

    public function beforeFilter()

      {
        parent::beforeFilter();

        //check if user has rights to do this
        $user_perm = $this->Session->read("user_perm");
        $glob_perm = $this->Session->read("glob_perm");

        if (!($user_perm['pages'] & $glob_perm['pages']['worlds'])) { 

           exit("access denied");

        } 
      }

    function index() {


        /*

        *   Connection Check - Is the server running? Redirect accordingly.

        */

        require APP . 'spacebukkitcall.php';
        
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

    		$this->set('title_for_layout', __('Worlds'));
    		
            $this->layout = 'sbv1';  

    		$args = array();   
    		$worlds = $api->call("getAllWorlds", $args, true);		
       		$this->set('worlds', $worlds);
            $enWorlds = $api->call("getWorlds", $args, false);
            $this->set("enWorlds", $enWorlds);
            $plugins = $api->call("getPlugins", $args, false);
            $wmpl = $this->getWMPL($plugins);
            $this->set("wmpl", $wmpl);
            if (in_array('dynmap', $plugins)) {
                $dynmap = true;
                $addr = $this->Session->read('Server.external_address');
                if (preg_match("/http/", $addr)) {
                    $dynmapurl = $addr;
                } else {
                    if ($addr == '')    $addr = $this->Session->read('Server.address');
                    if (preg_match("/localhost/", $addr) || preg_match("/127.0.0.1/", $addr) || preg_match("/::1/", $addr)) {
                            $addr = file_get_contents("http://automation.whatismyip.com/n09230945.asp");
                        }
                    $dynmapurl = 'http://'.$addr.':'.$api->call('dynmapPort', $args, false);
                }
                $this->set('dynmapurl', $dynmapurl);
            } else {
                $dynmap = false;
            }
            $this->set('dynmap', $dynmap);
        }
    }
    
    //Function to get strings
    function get_string_between($string, $start, $end){
        $ini = strpos($string, $start); 
        if($ini===false) return ""; 
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

    //worlds tab functions
    function getWMPL($plugins) {
        if(in_array('My Worlds', $plugins) != NULL){
            $wmpl = 1;
        }else if(in_array('Multiverse-Core', $plugins) != NULL){
            $wmpl = 2;
        }else{
            $wmpl = 0;
        }
        return $wmpl;
    }

    function getWorlds() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            //call API
            require APP . 'spacebukkitcall.php';
            //set clear arguments
            $args = array();
            //get World Management Plugin
            $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));

            //get all worlds
            $worlds = $api->call("getAllWorlds", $args, true);
            //get the enabled worlds
            $loadedWorlds = $api->call("getWorlds", $args, false);

            //get main worlds
            $args = array("server.properties");   
            $config = $api->call("getFileContent", $args, true);

            //make an array for them
            $main = array();
            $main['NL'] = $this->get_string_between($config, "level-name=", "\n");
            $main['NR'] = $main['NL']."_nether";
            $main['TE'] = $main['NL']."_the_end";

            //Start the datatable write
            $num = count($worlds);
            $i = 1;
            echo '{ "aaData": [';

            foreach ($worlds as $w) {
                //Call when the world is NOT loaded
                if(in_array($w, $loadedWorlds) == NULL){
                    //These variables are the "columns" of the table
                    $online = '<img src=\"img/disabled.png\">';
                    $name = $w;
                    $time = "";
                    $animals = "";
                    $hostiles = "";
                    $pvp = "";
                    $difficulty = "";
                    $environment = "";
                    //if the World Management Plugin is installed, put a load button
                    if($wmpl != 0){
                        $load = perm_action('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tworlds/loadWorld/'.$name.'\" class=\"button icon arrowup ajax_table1\">'.__('Load').'</a></span>');
                    }else{
                        $load = "";
                    }
                //Call when world is LOADED
                }else if(in_array($w, $loadedWorlds) != NULL) {
                    //get world specific information
                    $args = array($w);
                    $worldInfo = $api->call("getWorldInformations", $args, false);
                    $rTime = substr($worldInfo['FormattedTime'],0,5);

                    //these variables aren't multiworld dependent so we don't check for that :)
                    //set icon
                    if(in_array($w, $main) == NULL){
                       $online = '<img src=\"img/enabled.png\">'; 
                    }else{
                        $online = __('Default');
                    }

                    //set name variable
                    $name = $worldInfo['Name'];

                    //set environment variable
                    if($worldInfo['Environment'] == "NORMAL"){
                        $environment = '<img src=\"img/world_normal.png\"> Normal';
                    }else if($worldInfo['Environment'] == "NETHER"){
                        $environment = '<img src=\"img/world_nether.png\"> Nether';
                    }else if($worldInfo['Environment'] == "THE_END"){
                        $environment = '<img src=\"img/world_end.png\"> The End';
                    }

                    //if you use a WMPL
                    if($wmpl != 0){
                        //set time column
                        $time = '<span class=\"button-group\"><a href=\"./tworlds/getTime/'.$name.'\" class=\"button icon clock fancy\">'.$rTime.'</a></span>';

                        //set properties
                        //per WMPL config
                        if ($wmpl == 2) {
                            //animals multiverse
                            if($worldInfo['AllowAnimals'] == 1){
                                $animals = '<img src=\"img/circle_green.png\"> ';
                                $animals .= perm_action('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tworlds/worldAnimals/0/'.$name.'\" class=\"button icon arrowdown ajax_table1\">'.__('Disable').'</a></span>');
                            }else{
                                $animals = '<img src=\"img/circle_red.png\"> ';
                                $animals .= perm_action('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tworlds/worldAnimals/1/'.$name.'\" class=\"button icon arrowup ajax_table1\">'.__('Enable').'</a></span>');
                            }

                            //monsters multiverse
                            if($worldInfo['AllowMonsters'] == 1){
                                $hostiles = '<img src=\"img/circle_green.png\"> ';
                                $hostiles .= perm_action('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tworlds/worldHostiles/0/'.$name.'\" class=\"button icon arrowdown ajax_table1\">'.__('Disable').'</a></span>');
                            }else{
                                $hostiles = '<img src=\"img/circle_red.png\"> ';
                                $hostiles .= perm_action('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tworlds/worldHostiles/1/'.$name.'\" class=\"button icon arrowup ajax_table1\">'.__('Enable').'</a></span>');
                            }
                        }else if($wmpl == 1) {
                            //animals MyWorlds
                            if($worldInfo['AllowAnimals'] == 1){
                                $animals = '<img src=\"img/circle_green.png\">';
                            }else{
                                $animals = '<img src=\"img/circle_red.png\">';
                            }

                            //hostiles myWorlds
                            if($worldInfo['AllowMonsters'] == 1){
                                $hostiles = '<img src=\"img/circle_green.png\">';
                            }else{
                                $hostiles = '<img src=\"img/circle_red.png\">';
                            }
                        }

                        //set PVP
                        if($worldInfo['PVP'] == 1){
                            $pvp = '<img src=\"img/circle_green.png\"> ';
                            $pvp .= perm_action('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tworlds/worldPVP/0/'.$name.'\" class=\"button icon arrowdown ajax_table1\">'.__('Disable').'</a></span>');
                        }else{
                            $pvp = '<img src=\"img/circle_red.png\"> ';
                            $pvp .= perm_action('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tworlds/worldPVP/1/'.$name.'\" class=\"button icon arrowup ajax_table1\">'.__('Enable').'</a></span>');
                        }

                        //set difficulty
                        if($worldInfo['Difficulty'] == "PEACEFUL"){
                            $difficulty = '<img src=\"img/peaceful.png\"> <span class=\"button-group\"><a href=\"./tworlds/getWorldDiff/'.$name.'\" class=\"button icon edit fancy\">'.__('Change').'</a></span>';
                        }else if($worldInfo['Difficulty'] == "EASY"){
                            $difficulty = '<img src=\"img/easy.png\"> <span class=\"button-group\"><a href=\"./tworlds/getWorldDiff/'.$name.'\" class=\"button icon edit fancy\">'.__('Change').'</a></span>';
                        }else if($worldInfo['Difficulty'] == "NORMAL"){
                            $difficulty = '<img src=\"img/normal.png\"> <span class=\"button-group\"><a href=\"./tworlds/getWorldDiff/'.$name.'\" class=\"button icon edit fancy\">'.__('Change').'</a></span>';
                        }else if($worldInfo['Difficulty'] == "HARD"){
                            $difficulty = '<img src=\"img/hard.png\"> <span class=\"button-group\"><a href=\"./tworlds/getWorldDiff/'.$name.'\" class=\"button icon edit fancy\">'.__('Change').'</a></span>';
                        }


                        //set load button if it's not the main world
                        if (in_array($name, $main) == NULL){
                            $load = '<a href=\"./tworlds/unloadWorld/'.$name.'\" class=\"button icon arrowdown ajax_table1\">'.__('Unload').'</a>';
                        }else{
                            $load = "";
                        }
                        }
                    //if you don't use a WMPL
                    if($wmpl == 0){
                        //set time column
                        $time = $rTime;

                        //set animals column
                        if($worldInfo['AllowAnimals'] == 1){
                            $animals = '<img src=\"img/circle_green.png\">';
                        }else{
                            $animals = '<img src=\"img/circle_red.png\">';
                        }

                        //set monsters column
                        if($worldInfo['AllowMonsters'] == 1){
                            $hostiles = '<img src=\"img/circle_green.png\">';
                        }else{
                            $hostiles = '<img src=\"img/circle_red.png\">';
                        }

                        //set pvp column
                        if($worldInfo['PVP'] == 1){
                            $pvp = '<img src=\"img/circle_green.png\">';
                        }else{
                            $pvp = '<img src=\"img/circle_red.png\">';
                        }
                        //set difficulty
                        if($worldInfo['Difficulty'] == "PEACEFUL"){
                            $difficulty = '<img src=\"img/peaceful.png\">';
                        }else if($worldInfo['Difficulty'] == "EASY"){
                            $difficulty = '<img src=\"img/easy.png\">';
                        }else if($worldInfo['Difficulty'] == "NORMAL"){
                            $difficulty = '<img src=\"img/normal.png\">';
                        }else if($worldInfo['Difficulty'] == "HARD"){
                            $difficulty = '<img src=\"img/hard.png\">';
                        }

                        //set load button if it's not the main world
                        if (in_array($name, $main) == NULL){
                        $load = '<a href=\"./tworlds/unloadWorld/'.$name.'\" class=\"button icon arrowdown ajax_table1\">'.__('Unload').'</a>';
                        }else{
                            $load = "";
                        }
                    }
                
                }

                //UNCOMMENT THIS FOR BACKUPS, ETC
                
                //$actions = '<center> '.$load.' <span class=\"button-group\"><a href=\"#\"  class=\"button icon like ajax_table1\">'.__('Backup').'</a><a href=\"#\" class=\"button icon remove danger ajax_table1\">'.__('Delete!').'</a></span></center>';
                
                $actions = '<center><span class=\"button-group\"> '.$load.'</span> <span class=\"button-group\"><a href=\"./tworlds/deleteWorld/'.$name.'\" class=\"button icon remove danger remove\">'.__('Delete!').'</a></span></center>';
                
                //send to table
                ECHO <<<END
                [
                  "$online",
                  "$name",
                  "$time",
                  "$animals",
                  "$hostiles",
                  "$pvp",
                  "$difficulty",
                  "$environment",
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

    function getTime($wrld){
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
        require APP . 'spacebukkitcall.php';
        //get world specific information
        $args = array($wrld);
        $worldInfo = $api->call("getWorldInformations", $args, true);
        $time = substr($worldInfo['FormattedTime'],0,5);
        $this->set('time', $time);
        $this->set('wrld', $wrld);
        $this->layout = 'popup';
    }

    function setTime($wrld = NULL, $time = NULL) {
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
        if($this->request->is('post')) {
            $info = $this->request->data;
            $time = $info['time'];
            $wrld = $info['wrld'];
        }else if($this->request->is('ajax')){
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
        }
        //include API
        require APP . 'spacebukkitcall.php';
        $args = array();
        $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
        //import multiworld time command
        if($wmpl == 1){
            $args = array("world time ".$time." ".$wrld);
        }else if($wmpl == 2){
            $args = array("mvm set time ".$time." ".$wrld);
        }else{
            echo $wmpl;
            exit();
        }
        //send command, pop-up a message, add to log
        $info = $api->call("consoleCommand", $args, true);
        if($info == TRUE){
            w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').' '.__("Changed time in").' '.$wrld);
            echo __(__('You')).__(" changed time in ").$wrld;
        }else{echo __('error while setting variable in ').$wrld;}
    }

    function worldAnimals($an, $wrld) {
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            //include API
            require APP . 'spacebukkitcall.php';
            $args = array();
            //get multiworld plugin
            $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
            if($an == 1) {
                //import multiworld mob command
                if($wmpl == 1){
                    $args = array("world allowspawn animal ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set animals true ".$wrld);
                }
                $mesg = ' '.__('enabled animals on').' ';
            }else{
                //import multiworld mob command
                if($wmpl == 1){
                    $args = array("world denyspawn animal ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set animals false ".$wrld);
                }
                $mesg = ' '.__('disabled animals on').' ';
            }
            //send command, pop-up a message, add to log
            $info = $api->call("consoleCommand", $args, true);
            if($info == TRUE){
                w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').$mesg.$wrld);
                echo __(__('You')).$mesg.$wrld;
            }else{echo __('error while setting variable in').' '.$wrld;}
        }
    }

    function worldHostiles($hos, $wrld) {
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            //include API
            require APP . 'spacebukkitcall.php';
            $args = array();
            //get multiworld plugin
            $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
            if($hos == 1) {
                //import multiworld mob command
                if($wmpl == 1){
                    $args = array("world allowspawn monster ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set monsters true ".$wrld);
                }
                $mesg = ' '.__('enabled hostiles on').' ';
            }else{
                //import multiworld mob command
                if($wmpl == 1){
                    $args = array("world denyspawn monster ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set monsters false ".$wrld);
                }
                $mesg = ' '.__('disabled hostiles on').' ';
            }
            //send command, pop-up a message, add to log
            $info = $api->call("consoleCommand", $args, true);
            if($info == TRUE){
                w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').$mesg.$wrld);
                echo __(__('You')).$mesg.$wrld;
            }else{echo __('error while setting variable in ').$wrld;}
        }

    }

    function worldPVP($pvp, $wrld) {
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            //include API
            require APP . 'spacebukkitcall.php';
            $args = array();
            //get multiworld plugin
            $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
            if($pvp == 1) {
                //import multiworld mob command
                if($wmpl == 1){
                    $args = array("world togglepvp ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set pvp true ".$wrld);
                }
                $mesg = ' '.__('enabled PVP on').' ';
            }else{
                //import multiworld mob command
                if($wmpl == 1){
                    $args = array("world togglepvp ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set pvp false ".$wrld);
                }
                $mesg = ' '.('disabled PVP on').' ';
            }
            //send command, pop-up a message, add to log
            $info = $api->call("consoleCommand", $args, true);
            if($info == TRUE){
                w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').$mesg.$wrld);
                echo __('You').$mesg.$wrld;
            }else{echo __('error while setting variable in ').$wrld;}
        }
    }

    function getWorldDiff($wrld) {
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
        require APP . 'spacebukkitcall.php';
        //get world specific information
        $args = array($wrld);
        $worldInfo = $api->call("getWorldInformations", $args, false);
        $diff = $worldInfo['Difficulty'];
        $this->set('diff', $diff);
        $this->set('wrld', $wrld);
        $this->layout = 'popup';
    }

    function setWorldDiff($wrld, $diff) {
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
            $this->autoRender = false;
            //include API
            require APP . 'spacebukkitcall.php';
            $args = array();
            //get multiworld plugin
            $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
            if($diff == 0) {
                if($wmpl == 1){
                    $args = array("world difficulty peaceful ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set diff peaceful ".$wrld);
                }
                $mesg = ' '.__('changed difficulty to peaceful in').' ';
            }else if($diff == 1) {
                if($wmpl == 1){
                    $args = array("world difficulty easy ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set diff easy ".$wrld);
                }
                $mesg = ' '.__('changed difficulty to easy in').' ';
            }else if($diff == 2) {
                if($wmpl == 1){
                    $args = array("world difficulty normal ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set diff normal ".$wrld);
                }
                $mesg = ' '.__('changed difficulty to normal in').' ';
            }else if($diff == 3) {
                if($wmpl == 1){
                    $args = array("world difficulty hard ".$wrld);
                }else if($wmpl == 2){
                    $args = array("mvm set diff hard ".$wrld);
                }
                $mesg = ' '.__('changed difficulty to hard in').' ';
            }

            //send command, pop-up a message, add to log
            $info = $api->call("consoleCommand", $args, true);
            if($info == TRUE){
                w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').$mesg.$wrld);
                echo __('You').$mesg.$wrld;
            }else{echo __('error while setting variable in').' '.$wrld;}
    }

    function unloadWorld($wrld) {
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            //include API
            require APP . 'spacebukkitcall.php';
            $args = array();
            //get multiworld plugin
            $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
            //include multiworld unload command
            if($wmpl == 1){
                $args = array("world unload ".$wrld);
            }else if($wmpl == 2){
                $args = array("mv unload ".$wrld);
            }
            //send command, pop-up a message, add to log
            $info = $api->call("consoleCommand", $args, true);
            if($info == TRUE){
                w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').__(' unloaded ').$wrld);
                echo $wrld.' '.__('has been unloaded.');
            }else{echo __('error while unloading').' '.$wrld;}
            }
    }

    function loadWorld($wrld) {
        perm('worlds', 'changeWorldSettings', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            //include API
            require APP . 'spacebukkitcall.php';
            $args = array();
            $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
            //give load command for said multiworld plugin
            if($wmpl == 1){
                $args = array("world load ".$wrld);
            }else if($wmpl == 2){
                $args = array("mv load ".$wrld);
            }
            //send command, pop-up a message, add to log
            $info = $api->call("consoleCommand", $args, true);
            if($info == TRUE){
                w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').' '.__('loaded').' '.$wrld);
                echo $wrld.' '.__('has been loaded.');
            }else{echo __('error while loading').' '.$wrld;}  
        }
    }



    function deleteWorld($wrld) {
        perm('worlds', 'removeAddWorld', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';
            $args = array();
            //remove from multiverse
            $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
            if ($wmpl == 2){
                $args = array("mvremove ".$wrld);
                $info = $api->call('consoleCommand', $args, true);
            }
            //stop the server
            $args = array();
            $api->call("hold", $args, true);
            sleep(5);
            //backup the world
            $args = array('./SpaceModule/configuration.yml');
            $config = $api->call('getFileContent', $args, true);
            $wc = $this->get_string_between($config, "WorldContainer: ", "\n");
            $args = array('World-'.$wrld, $wrld, false);
            $api->call("backup", $args, true);
            sleep(5);
            //remove the world
            $args1 = array($wc.'/'.$wrld);
            $api->call('deleteDir', $args, true);
            sleep(5);
            //start the server
            $args = array();
            $api->call('unhold', $args, true);
            while(!$api->call('isServerRunning', $args, true)){
                sleep(1);
            }
            w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').' '.__('deleted').' '.$wrld);
            echo __('World has been removed! A backup can be found in the backups folder!');
        }
    }

    function addWorld() {
        perm('worlds', 'removeAddWorld', $this->Session->read("user_perm"), true);
        if ($this->request->is('post')) {
            $name = $this->request->data['name'];
            $seed = $this->request->data['seed'];
            $type = $this->request->data['type'];
            if($name == NULL || $type == NULL){
                $this->redirect(array('controller' => 'tworlds', 'action' => 'index'));
            }else{
                //include API
                require APP . 'spacebukkitcall.php';
                $args = array();
                $wmpl = $this->getWMPL($api->call("getPlugins", $args, false));
                if($wmpl == 1){
                    if($type != "NORMAL"){
                        $args = array("world create ".$name."-".$type." ".$seed);
                    }else{
                        $args = array("world create ".$name." ".$seed);
                }
                }else if($wmpl == 2){
                    if($seed == NULL){$seed = "";}else{$seed = " -s ".$seed;}
                    $args = array("mv create ".$name." ".$type.$seed);
                }
                $out = $api->call("consoleCommand", $args, true);
                if($out){
                    w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').' '.__('created').' '.$wrld);
                    $this->redirect(array('controller' => 'tworlds', 'action' => 'index'));
                }
            } 
        }
        $this->layout = 'popup';
    }

//autotrim tab functions
    function mapautotrim() {
        perm('worlds', 'runMapAutoTrim', $this->Session->read("user_perm"), true);
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }


        require APP . 'spacebukkitcall.php';

		//notify users
		$args = array($this->Session->read("Sbvars.10"), '$bServer will shut down shortly due to map mainteniance with MapAutoTrim'); 
		  
        $api->call("broadcastWithName", $args, false);  

        sleep(10);

		//run MapAutoTrim
		$vars = $this->request->data;

  		$args2 = array($vars['world'], $vars['dilatation'], $vars['blocks']);   
		$api->call("runMapTrimmer", $args2, true);

        sleep(5);

        w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').' '.__('ran MapAutoTrim on').' '.$vars['world']);

        while(is_null($api->call('getWorlds', array(), false))) {
            sleep(1);
        }

    	$this->redirect($this->referer());

    	
    }
    /*
//chunkster tab functions
    function chunkster() {
        perm('worlds', 'runChunkster', $this->Session->read("user_perm"), true);
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }


        require APP . 'spacebukkitcall.php';

        //notify users
        $args = array($this->Session->read("Sbvars.10"), '$bServer will shut down shortly due to map mainteniance with Chunkster'); 
          
        $api->call("broadcastWithName", $args, false);  

        sleep(10);

        //run MapAutoTrim
        $vars = $this->request->data;

        $args2 = array($vars['world']);   
        $api->call("runChunkster", $args2, true);

        sleep(5);

        w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').' '.__('ran Chunkster on').' '.$vars['world']);        

        $this->redirect($this->referer());

        
    }*/

}

?>