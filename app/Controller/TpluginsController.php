<?php

/**
*
*   ####################################################
*   TPluginsController.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is relative to the "Plugins" page and all it's related functions.
*   This includes managing, installing, updating, removing, enabling and disabling plugins
*   on the bukkit server.
*
*   TABLE OF CONTENTS
*   
*   1)  index
*   2)  checkPluginUpdates
*   3)  disable_plugin
*   4)  enable_plugin
*   5)  update
*   6)  config
*   7)  SaveConfig
*   8)  URLinstall
*   9)  remove_plugin
*   
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class TPluginsController extends AppController {

    public $helpers = array ('Html','Form');

    public $name = 'TPluginsController';

    public function beforeFilter()

      {
        parent::beforeFilter();

        //check if user has rights to do this
        $user_perm = $this->Session->read("user_perm");
        $glob_perm = $this->Session->read("glob_perm");
         if ($user_perm['pages'] &! $glob_perm['pages']['plugins']) { 
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
    
		$this->set('title_for_layout', 'Plugins');
		
        $this->layout = 'sbv1';  

       	$this->set('title_for_layout', 'Plugins');

        }    
    }

    function checkPluginUpdates() {
        
        if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;
        $temp = __('Feature temporarily disabled');
ECHO <<<END
{ "aaData": [
[
"",
"$temp"
]
] }
END;
        

		}
    
    }
        
   function getPlugins() {
        set_time_limit(300);
    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include '../spacebukkitcall.php';

        //Get Plugins           
        $args = array();
        $plugins = $api->call("getPlugins", $args, false);
        while ($plugins == NULL) {
            sleep(2);
            $plugins = $api->call("getPlugins", $args, false);
        }
        $plglist = array();

        foreach ($plugins as $plgname) {
            
            $args = array($plgname);   
            $plugin = $api->call("getPluginInformations", $args, false);
            $plugin['pName'] = $plgname;
            $plglist[] = $plugin;

        };

        $i = 1;
        $num = count($plglist);

        echo '{ "aaData": [';  
                     
        foreach ($plglist as $plg) {

        if ($plg['IsEnabled'] == 1) {
                $status = '<img src=\"img/circle_green.png\" />';
                } else {
                $status = '<img src=\"img/circle_red.png\" />';
                }        
        if ($plg['Bukget'] == true) {
                $bukget = '<img src=\"img/bukget_enabled.png\" />';
                $pname = $plg["pName"];
                } else {
                $bukget = '';
                $pname = $plg["pName"];
                }

        $pconf =  str_replace(" ", "%20", $plg["pName"]);

        $authors = implode(', ', $plg['Authors']);

        if (($pname=="SpaceBukkit") || ($pname=="RemoteToolkitPlugin")){
            $enplg = '';
        }
        else {

        if ($plg['IsEnabled'] == 1) {
                    $enplg = '<a href=\"./tplugins/disable_plugin/' . $pname .'\" class=\"button icon remove danger ajax_table1\">'.__('Disable').'</a><a href=\"./tplugins/remove_plugin/' . $pname .'\" class=\"button icon trash dangera jax_table1\">'.__('Remove').'</a>';
                } else {
                    $enplg = '<a href=\"./tplugins/enable_plugin/' . $pname .'\" class=\"button icon reload ajax_table1\">'.__('Enable').'</a><a href=\"./tplugins/remove_plugin/' . $pname .'\" class=\"button icon trash dangera jax_table1\">'.__('Remove').'</a>';
                }             
   
        }

        $plgactions = $enplg.'<a href=\"./tplugins/config/' . $pconf .'\" class=\"button icon fancy edit \">'.__('Configure').'</a>';
            
        if ($plg['Website'] != "") { 
                    $plginfo = '<a href=\"'. $plg['Website'] .'\" target=\"_blank\" class=\"button icon home\">'.__('Website').'</a>';
                } else {
                    $plginfo = '';
                }
        
        $description = trim(str_replace('"','\"',str_replace("\n",' ',$plg["Description"])));

        
        ECHO <<<END
            [
              "$status $bukget",
              "$plg[Name]",
              "$plg[Version]",
              "$authors",
              "$description",
              "<span class=\"button-group\">$plgactions</span>",
              "<span class=\"button-group\">$plginfo</span>"
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

   function getPlugin($plugin) {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include '../spacebukkitcall.php';

        $args = array($plugin);   
        $plg = $api->call("getPluginInformations", $args, false);
                    
        if ($plg['IsEnabled'] == 1) {
                $status = '<img src="img/circle_green.png" />';
                } else {
                $status = '<img src="img/circle_red.png" />';
                }        
        if ($plg['Bukget'] != "null") {
                $bukget = '<img src="img/bukget_enabled.png" />';
                $pname = $plg["Bukget"];
                } else {
                $bukget = '';
                $pname = $plg["Name"];
                }

        $pconf =  str_replace(" ", "%20", $plg["Name"]);

        $authors = implode(', ', $plg['Authors']);

        if (($pname=="SpaceBukkit") || ($pname=="RemoteToolkitPlugin")){
            $enplg = '';
        }
        else {

        if ($plg['IsEnabled'] == 1) {
                    $enplg = '<a href="./tplugins/disable_plugin/' . $pname .'" class="button icon remove danger ajax_table1">'.__('Disable').'</a><a href="./tplugins/remove_plugin/' . $pname .'" class="button icon trash dangera jax_table1">'.__('Remove').'</a>';
                } else {
                    $enplg = '<a href="./tplugins/enable_plugin/' . $pname .'" class="button icon reload ajax_table1">'.__('Enable').'</a><a href="./tplugins/remove_plugin/' . $pname .'" class="button icon trash dangera jax_table1">'.__('Remove').'</a>';
                }             
   
        }

        $plgactions = $enplg.'<a href="./tplugins/config/' . $pconf .'" class="button icon fancy edit ">'.__('Configure').'</a>';
            
        if ($plg['Website'] != "") { 
                    $plginfo = '<a href="'. $plg['Website'] .'" target="_blank" class="button icon home">'.__('Website').'</a>';
                } else {
                    $plginfo = '';
                }
        
        $description = trim(str_replace('"','"',str_replace("n",' ',$plg["Description"])));

        $result = array($status.$bukget, $plg["Name"], $plg["Version"], $authors, $description, '<span class="button-group">'.$plgactions.'</span>', '<span class="button-group">'.$plginfo.'</span>' ); 
        echo json_encode($result);

              
    }
    }    

    function disable_plugin($name) {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include '../spacebukkitcall.php';
    	
    	//Disable plugin		
    	$args = array($name);   
    	$api->call("disablePluginTemporarily", $args, false);
        w_serverlog($this->Session->read("current_server"), __('[PLUGINS]').$this->Auth->user('username').__(' disabled ').$name);
        echo $name.__(' has been disabled.');
    }
    }

    function enable_plugin($name) {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include '../spacebukkitcall.php';
    			
		//Disable plugin		
		$args = array($name);   
		$api->call("enablePluginTemporarily", $args, FALSE);
        w_serverlog($this->Session->read("current_server"), __('[PLUGINS]').$this->Auth->user('username').__(' enabled ').$name);
        echo $name.__(' has been enabled.');

    }
    }

    function update_plugin($name) {

        include '../spacebukkitcall.php';
                
        //Disable plugin        
        $args = array($name);   
        $api->call("pluginUpdate", $args, true);
        w_serverlog($this->Session->read("current_server"), __('[PLUGINS]').$this->Auth->user('username').__(' updated ').$name);

        $this->redirect(array('controller' => 'Tplugins', 'action' => 'index'));


    }

    function config($name) {

        include '../spacebukkitcall.php';

        //check if plugin has folder

        $args = array('plugins'); 
        $folders = $api->call("listDirectories", $args, true);

        if (!in_array($name, $folders)) {
            exit('Plugin has no config!');
        }  
        
        //get the path
        $path = 'plugins/'.$name;

        //get all files in folder
		$args = array($path); 
		$files = $api->call("listFiles", $args, true);

        //set contents to each file
		$content = array();
		foreach ($files as $file) {

			$args2 = array($path.'/'.$file);
			$content[$file]["content"] = $api->call("getFileContent", $args2, true);
            $content[$file]["file"] = $file;

		}

        //set variables
    	$this->set('plugin_name', $name);
        $this->set('files', $files);        
    	$this->set('contents', $content);
        $this->layout = 'popup';

    }


    function SaveConfig() {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        } else {
        
        $data = $this->request->data;

        include '../spacebukkitcall.php';

        $path = "./plugins/".$data["plugin"]."/".$data["file"];
        $content = $data["config_content"];

        //echo $path;

        $methods = array_keys($data);
        $method = $methods[3];

        $args = array($path, $content); 
        $api->call("setFileContents", $args, true);
        
        $args = array();

        if ($method == "reload") {

        $api->call("reloadServer", $args, false);
        sleep(10);

        } elseif ($method == "restart") {

        $args2 = array("SpaceBukkit", "Server will restart due to plugin configuration save...");
        $api->call("broadcastWithName", $args2, false);
        sleep(5);
        
        $args = array();
        $api->call("restartServer", $args, true);
        sleep(10);


        } 
        $this->redirect($this->referer());
    
        
        }
    }


    /*

     * The following functions are related to installing plugins

    */

    function URLinstall() {

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        } else {

        include '../spacebukkitcall.php';

        $url = $this->request->data;

        $name = basename($url['url']);

        $ext = substr($name, strrpos($name, '.') + 1);

        if (!(($ext=="zip") || ($ext=="jar"))){
            exit("Invalid file format!");
        }

        //Check if it exists      
        $args = array('plugins');   
        $plugins = $api->call("listFiles", $args, true);
        
        if (in_array($name, $plugins)) {
            exit("File already installed!");
        }

        //Install plugin        
        $args = array($url["url"], $name);   
        $api->call("pluginInstallByURL", $args, true);

        //Dummy call to listen for reload   
        $args = array();   
        $api->call("getOPs", $args);

        $this->redirect(array('controller' => 'Tplugins', 'action' => 'index'));

        }
    }

    function remove_plugin($name) {

        include '../spacebukkitcall.php';

        //DeInstall plugin        
        $args = array($name, false);   
        $api->call("pluginRemove", $args, true);

        //Dummy call to listen for reload   
        $args = array();   
        $api->call("getOPs", $args, false);
        
        $this->redirect(array('controller' => 'Tplugins', 'action' => 'index'));

    }

}

?>