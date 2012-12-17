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

        if (!($user_perm['pages'] & $glob_perm['pages']['servers'])) {

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

        $this->set('title_for_layout', __('Server'));

        $server = $api->call("getServer", $args, false);

        //Bukkit Properties Info
        $bukkit = array();

        $args = array("bukkit.yml");
        $bukkityml = $api->call("getFileContent", $args, true);

        $bukkit['spawn-radius'] = $this->get_string_between($bukkityml, 'spawn-radius: ', "\n");
        $bukkit['update-folder'] = $this->get_string_between($bukkityml, 'update-folder: ', "\n");
        $bukkit['permissions-file'] = $this->get_string_between($bukkityml, 'permissions-file: ', "\n");
        $bukkit['connection-throttle'] = $this->get_string_between($bukkityml, 'connection-throttle: ', "\n");
        $bukkit['animal-spawns'] = $this->get_string_between($bukkityml, 'animal-spawns: ', "\n");
        $bukkit['monster-spawns'] = $this->get_string_between($bukkityml, 'monster-spawns: ', "\n");
        $bukkit['allow-end'] = $this->get_string_between($bukkityml, 'allow-end: ', "\n");
        $bukkit['warn-on-overload'] = $this->get_string_between($bukkityml, 'warn-on-overload: ', "\n");
        $bukkit['use-exact-login-location'] = $this->get_string_between($bukkityml, 'use-exact-login-location: ', "\n");
        $bukkit['plugin-profiling'] = $this->get_string_between($bukkityml, 'plugin-profiling: ', "\n");

        $this->set('bukkit', $bukkit);
        $this->set('cversion', $this->get_string_between($server['Version'], "-b", "jnks"));

        //CraftBukkit chooser information

        $filename = 'http://dl.bukkit.org/downloads/craftbukkit/feeds/latest-rb.rss';
        $bukkitxml = simplexml_load_file($filename);

        $json = json_encode($bukkitxml);
        $bukkitxml = json_decode($json, TRUE);

        $this->set('versions', $bukkitxml["channel"]["item"]);
        $this->set('server', $server);

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

        //view-specific settings
        $this->layout = 'sbv1';
    }

    }

    function getBuilds($mod='cb') {

        $this->autoRender = false;

        switch($mod) {
            case 'cb':

                $opts = array(
                  'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept:  application/json "
                  )
                );

                $context = stream_context_create($opts);

                // Open the file using the HTTP headers set above
                $file = json_decode(file_get_contents('http://dl.bukkit.org/api/1.0/downloads/projects/craftbukkit/artifacts/', false, $context), TRUE);

                $aa = array();

                foreach($file['results'] as $i => $build) {

                    $button = $build['is_broken'] ? 'Broken build' : '<a href="./tservers/install_cb/'.$build['build_number'].'/cb">Install</a>' ;
                    $text = $build['is_broken'] ? $build['broken_reason'] : 'Success';

                    $aa[$i] = array(
                        $build['build_number'],
                        $build['version'],
                        $build['channel']['name'],
                        $text,
                        $button
                    );
                }

                $aa = $aa;

            break;
            case 'sg':

                $opts = array(
                  'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept:  application/json "
                  )
                );

                $context = stream_context_create($opts);

                // Open the file using the HTTP headers set above
                $file = json_decode(file_get_contents('http://ci.md-5.net/job/Spigot/api/json?pretty=true', false, $context), TRUE);

                $aa = array();

                foreach($file['builds'] as $i => $build) {

                    $button = '<a href="./tservers/install_cb/'.$build['number'].'/sp">Install</a>' ;

                    $aa[$i] = array(
                        $build['number'],
                        $build['number'],
                        "Spigot",
                        "",
                        $button
                    );
                }
            break;
            case 'sp':

                $opts = array(
                  'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept:  application/json "
                  )
                );

                $context = stream_context_create($opts);

                // Open the file using the HTTP headers set above
                $file = json_decode(file_get_contents('http://ci.md-5.net/job/Spigot/api/json?pretty=true', false, $context), TRUE);

                $aa = array();

                foreach($file['builds'] as $i => $build) {

                    $button = '<a href="./tservers/install_cb/'.$build['number'].'/sp">Install</a>' ;

                    $aa[$i] = array(
                        $build['number'],
                        $build['number'],
                        "Spigot",
                        "",
                        $button
                    );
                }
            break;

        }

        $res = new stdClass();
        $res -> aaData = $aa;

        echo json_encode($res);

    }

    function getRBS($mod='cb') {
        $this->autoRender = false;

        switch($mod) {
        case 'cb':

            $opts = array(
              'http'=>array(
                'method'=>"GET",
                'header'=>"Accept:  application/json "
              )
            );

            $context = stream_context_create($opts);

            // Open the file using the HTTP headers set above
            $file = json_decode(file_get_contents('http://dl.bukkit.org/api/1.0/downloads/projects/craftbukkit/artifacts/rb/', false, $context), TRUE);

            $i = 0;
            $tmp = 0;
            foreach ($file['results'] as $b) if ($tmp++ < 5) {
              $version_number = $b['build_number'];
              $version_link = $b['build_number'];
              $rb = "";

              echo '<a href="./tservers/install_cb/'.$version_link.'" class="confirmCB"><div class="rb bounce tip '.$rb.'">'.$version_number.'</div></a>';
              if (++$i == 8) break;
            }
        break;
        case 'sg':
            echo "This mod has no recommended builds!";
        break;
        case 'sp':
        break;
        }

    }

    //get the server log
    function getServerlog() {

        if ($this->request->is('ajax')) {

            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $args = array('server.log');

            echo "\n<pre class=\"cake-debug\">\n";

            $var = print_r($api->call('getFileContent', $args, true), true);
            echo $var . "\n</pre>\n";

        }

    }

    function getServerOverview() {
    if ($this->request->is('ajax')) {

            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

        //Server Information
            require APP . 'spacebukkitcall.php';

        $args = array();
        $ServerSpecs = array();
        $ServerSpecs['CPU'] = $api->call('getNumCpus', $args, false).' cores at '.$api->call('getCpuFrequency', $args, false).'GHz';

        $ServerSpecs['arch'] = $api->call('getArch', $args, false);

        $ServerSpecs['RAM'] = round(intval($api->call('getPhysicalMemoryTotal', $args, false)) / 1024, 2).' GB';

        $Dused = round(intval($api->call('getDiskUsage', $args, false)) / 1073741824, 2);
        $Dtotal = round(intval($api->call('getDiskSize', $args, false)) / 1073741824, 2);
        $Dfree = round(intval($api->call('getDiskFreeSpace', $args, false)) / 1073741824, 2);
        $ServerSpecs['Disk'] = 'Used: '.$Dused.'GB/'.$Dtotal.'GB Free: '.$Dfree.'GB';

        $ServerSpecs['OS'] = $api->call('getOsName', $args, false);

        $ServerSpecs['Java'] = 'Java '.$api->call('getJavaVersion', array(), true);

        $ServerSpecs['Web'] = $_SERVER['SERVER_SOFTWARE'];

        $server = $api->call('getServer', $args, false);

        $ServerSpecs['Bukkit'] = $server['Version'];

        $ServerSpecs['SpaceBukkit'] = 'Module: '.$api->call('getSpaceModuleVersion', $args, true).', RTK: '.$api->call('getVersion', $args, true);
        $this->set('ServerSpecs', $ServerSpecs);


        echo <<<END
<div class="col col_1_3 left">

    <section>
      <label for="CPU">
        CPU:
      </label>

      <div>
        $ServerSpecs[CPU]<br>
      </div>
    </section>

    <section>
      <label for="Java">
        Java Version:
      </label>

      <div>
        $ServerSpecs[Java]<br>
      </div>
    </section>

    <section>
      <label for="Bukkit">
        Bukkit Version:
      </label>

      <div>
        $ServerSpecs[Bukkit]<br>
      </div>
    </section>

  </div>


  <div class="col col_1_3 left">

      <section>
        <label for="Architecture">
          Architecture:
        </label>

        <div>
          $ServerSpecs[arch]<br>
        </div>
      </section>
        <section>
          <label for="OS">
            Operating System:
          </label>

          <div>
            $ServerSpecs[OS]<br>
          </div>
        </section>

        <section>
          <label for="SB">
            SpaceBukkit Version:
          </label>

          <div>
            $ServerSpecs[SpaceBukkit]<br>
          </div>
       <div class="clear"></div>
          </section>
  </div>


  <div class="col col_1_3 left">

    <section>
      <label for="Memory">
        Memory:
      </label>

      <div>
        $ServerSpecs[RAM]<br>
      </div>
    </section>

    <section>
      <label for="Disk">
        Disk Space:
      </label>

      <div>
        $ServerSpecs[Disk]<br>
      </div>
    </section>


        <section>
          <label for="Web">
            Webserver Version:
          </label>

          <div>
            $ServerSpecs[Web]<br>
          </div>
        </section>
  </div>

  <div class="clear"></div>
END;
        }
    }

    //delete the server log
    function delServerlog() {

        if ($this->request->is('ajax')) {

            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $args = array('server.log');

            $api->call('deleteFile', $args, true);

        }

    }
    //delete the server log
    function rollServerlog() {

        if ($this->request->is('ajax')) {

            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $args = array();

            $api->call('rollOverLog', $args, true);

        }

    }
    //download the server log
    function dlServerlog() {

            $this->disableCache();


            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $args = array('server.log');

            $content = $api->call('getFileContent', $args, true);
            $this->response->type('text/plain');
            $this->response->download('server.log');
            $this->response->body($content);
    }
    //Function to get strings
    function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

    function install_cb($cb = null, $mod='cb') {
        perm('servers', 'bukkit', $this->Session->read("user_perm"), true);

        set_time_limit(300);

        if ($this->request->is('post')) {
           $cb = $this->request->data["cb"];
        }

        //check if new files exist at all
        //they are either called craftbukkit.jar or craftbukkit-dev.jar

        if(is_numeric($cb)) {
            $cburl1 = 'http://dl.bukkit.org/downloads/craftbukkit/get/build-'.$cb.'/craftbukkit-dev.jar';
            $cburl2 = 'http://dl.bukkit.org/downloads/craftbukkit/get/build-'.$cb.'/craftbukkit.jar';
        } else {
            $cburl1 = 'http://dl.bukkit.org/downloads/craftbukkit/get/'.$cb.'/craftbukkit-dev.jar';
            $cburl2 = 'http://dl.bukkit.org/downloads/craftbukkit/get/'.$cb.'/craftbukkit.jar';
        }

        if ((!(fopen($cburl1, "r"))) && (!(fopen($cburl2, "r")))) {

            exit('Craftbukkit file does not exist');

        } elseif (fopen($cburl1, "r")) {

            $new_jar = $cburl1;

        } elseif (fopen($cburl2, "r")) {

            $new_jar = $cburl2;

        }

        require APP . 'spacebukkitcall.php';

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



        $old_jar = trim($this->get_string_between($config, "minecraft-server-jar=", "\n"));

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

        w_serverlog($this->Session->read("current_server"), __('[SERVERS] ').$this->Auth->user('username').' '.__('installed CraftBukkit').' '.$cb);
        sleep(2);

        $this->redirect($this->referer());

    }

        function saveConfig() {
            perm('servers', 'serverProperties', $this->Session->read("user_perm"), true);

        require APP . 'spacebukkitcall.php';

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

        w_serverlog($this->Session->read("current_server"), __(__('[SERVERS] ')).$this->Auth->user('username').' '.__('updated the server.properties'));

        $this->Session->write('Page.tab', 3);

        $this->redirect($this->referer());

    }

    function saveBukkitConfig() {
        perm('servers', 'serverProperties', $this->Session->read("user_perm"), true);
        require APP . 'spacebukkitcall.php';

        //request replacement data
        $new = $this->request->data;

        $bukkit = array();
        unset($new['save']);

        $args = array("bukkit.yml");
        $bukkityml = $api->call("getFileContent", $args, true);
        $old['spawn-radius'] = $this->get_string_between($bukkityml, 'spawn-radius: ', "\n");
        $old['update-folder'] = $this->get_string_between($bukkityml, 'update-folder: ', "\n");
        $old['permissions-file'] = $this->get_string_between($bukkityml, 'permissions-file: ', "\n");
        $old['connection-throttle'] = $this->get_string_between($bukkityml, 'connection-throttle: ', "\n");
        $old['animal-spawns'] = $this->get_string_between($bukkityml, 'animal-spawns: ', "\n");
        $old['monster-spawns'] = $this->get_string_between($bukkityml, 'monster-spawns: ', "\n");
        $old['allow-end'] = $this->get_string_between($bukkityml, 'allow-end: ', "\n");
        $old['warn-on-overload'] = $this->get_string_between($bukkityml, 'warn-on-overload: ', "\n");
        $old['use-exact-login-location'] = $this->get_string_between($bukkityml, 'use-exact-login-location: ', "\n");
        $old['plugin-profiling'] = $this->get_string_between($bukkityml, 'plugin-profiling: ', "\n");

        if(NULL == isset($new['allow-end'])) {
            $new['allow-end'] = 'false';
        }
        if(NULL == isset($new['warn-on-overload'])) {
            $new['warn-on-overload'] = 'false';
        }
        if(NULL == isset($new['use-exact-login-location'])) {
            $new['use-exact-login-location'] = 'false';
        }
        if(NULL == isset($new['plugin-profiling'])) {
            $new['plugin-profiling'] = 'false';
        }

        foreach ($new as $name => $value) {
            $init = $name.': '.$old[$name];
            $result = $name.': '.$value;
            $bukkityml = str_replace($init, $result, $bukkityml);
        }

        $args = array("bukkit.yml", $bukkityml);
        $api->call("setFileContent", $args, true);

        w_serverlog($this->Session->read("current_server"), __(__('[SERVERS] ')).$this->Auth->user('username').' '.__('updated the bukkit.yml'));
        $this->Session->write('Page.tab', 4);
        $this->redirect($this->referer());
    }


    function addTask() {
        perm('servers', 'Schedules', $this->Session->read("user_perm"), true);

        if (!$this->request->is('post')) {
        throw new MethodNotAllowedException();
        } else {

        require APP . 'spacebukkitcall.php';

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

        $this->Session->write('Page.tab', 5);

        $this->redirect($this->referer());

        }
    }

    function getTasks() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';

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
            $actions = perm_action('servers', 'Schedules', $this->Session->read("user_perm"), '<a href=\"./tservers/runTask/'.$task[0].'/'.$argument.'\" class=\"button icon approve ajax_table1\">'.__('Run now').'</a><a href=\"./tservers/removeTask/'.$id.'\" class=\"button icon remove danger ajax_table1\">'.__('Remove').'</a>');

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
        perm('servers', 'Schedules', $this->Session->read("user_perm"), true);

        require APP . 'spacebukkitcall.php';

        $args = array($task);
        $tasks = $api->call("removeTask", $args, true);

        $this->Session->write('Page.tab', 5);

        $this->redirect($this->referer());

    }

    function runTask($task, $param) {
        perm('servers', 'Schedules', $this->Session->read("user_perm"), true);

        require APP . 'spacebukkitcall.php';
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


        $this->Session->write('Page.tab', 5);

        $this->redirect($this->referer());

    }

}
