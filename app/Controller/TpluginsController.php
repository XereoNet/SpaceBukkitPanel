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

        if (!($user_perm['pages'] & $glob_perm['pages']['plugins'])) {

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

            $json['aaData'] = array(array('Currently disabled...', '', '', ''));

            echo json_encode($json);

            /*
            require APP . 'spacebukkitcall.php';
            $args = array();
            $plugins = $api->call('getPlugins', $args, false);
            $json['aaData'] = array();
            $bplugins = array();

            foreach ($plugins as $p) {
                $args = array($p);
                $info = $api->call('pluginInformations', $args, true);
                if (!empty($info)) {
                    $bplugins[] = $p;
                }
            }

            foreach ($bplugins as $p) {
                $args = array($p);
                $info = $api->call('getPluginInformations', $args, false);
                $upd = $api->call('checkForUpdates', $args, true);
                $upd = explode(',', $upd);
                if (!preg_match("/NOTONBUKKITDEV/", $upd[0]) && !preg_match("/FILENOTFOUND/", $upd[0]) && !preg_match("/UPTODATE/", $upd[0])) {
                    if (preg_match("/UNKNOWN/", $upd[0]) || preg_match("/OUTDATED/", $upd[0])) {
                        $ver = str_replace("NEWVERSION=", "", $upd[1]);
                        $ver = str_replace("v", "", preg_replace("/(?i)".$p."/", "", $ver));
                        if (!is_int(strpos($ver, $info['Version'])) && !is_int(strpos($info['Version'], $ver))) {
                            $json['aaData'][] = array($p, $info['Version'], $ver, perm_action('plugins', 'updatePlugin', $this->Session->read("user_perm"), '<a href="./tplugins/update_plugin/' . $p .'" class="button icon arrowup showOverlay" rel="Updating '.$p.'...">'.__('Update!').'</a>'));
                        }
                    }
                }
            }
            if (empty($json['aaData'])) {
                $json['aaData'][] = array('', 'All plugins are up to date!', '', '');
            }
            echo json_encode($json);*/
		}

    }

   function getPlugins() {
        set_time_limit(300);
    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';

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

        //sanitize

        foreach ($plg as $data) {
            $data = htmlspecialchars($data, ENT_QUOTES);
        }

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
            $remplg = '';
        } else {

            $remplg = perm_action('plugins', 'removeAddPlugin', $this->Session->read("user_perm"), '<a href=\"./tplugins/remove_plugin/' . $pname .'\" class=\"button icon trash dangera jax_table1\">'.__('Remove').'</a>');

            if ($plg['IsEnabled'] == 1) {
                $enplg = perm_action('plugins', 'disablePlugin', $this->Session->read("user_perm"), '<a href=\"./tplugins/disable_plugin/' . $pname .'\" class=\"button icon remove danger ajax_table1\">'.__('Disable').'</a>');
            } else {
                $enplg = perm_action('plugins', 'disablePlugin', $this->Session->read("user_perm"), '<a href=\"./tplugins/enable_plugin/' . $pname .'\" class=\"button icon reload ajax_table1\">'.__('Enable').'</a>');
            }

        }

        $plgconf = perm_action('plugins', 'configurePlugin', $this->Session->read("user_perm"), '<a href=\"./tplugins/config2/' . $pconf .'\" class=\"button icon fancy edit \">'.__('Configure').'</a>');

        $plgactions = $enplg.$remplg.$plgconf;

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

        require APP . 'spacebukkitcall.php';

        $args = array($plugin);
        $plg = $api->call("getPluginInformations", $args, false);

        if ($plg['IsEnabled'] == 1) {
                $status = '<img src="img/circle_green.png" />';
                } else {
                $status = '<img src="img/circle_red.png" />';
                }
        if ($plg['Bukget'] == true) {
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
            $remplg = '';
        } else {

            $remplg = perm_action('plugins', 'removeAddPlugin', $this->Session->read("user_perm"), '<a href="./tplugins/remove_plugin/' . $plg["Name"] .'" class="button icon trash dangera jax_table1">'.__('Remove').'</a>');

            if ($plg['IsEnabled'] == 1) {
                $enplg = perm_action('plugins', 'disablePlugin', $this->Session->read("user_perm"), '<a href="./tplugins/disable_plugin/' . $plg["Name"] .'" class="button icon remove danger ajax_table1">'.__('Disable').'</a>');
            } else {
                $enplg = perm_action('plugins', 'disablePlugin', $this->Session->read("user_perm"), '<a href="./tplugins/enable_plugin/' . $plg["Name"] .'" class="button icon reload ajax_table1">'.__('Enable').'</a>');
            }

        }

        $plgconf = perm_action('plugins', 'configurePlugin', $this->Session->read("user_perm"), '<a href="./tplugins/config/' . $pconf .'" class="button icon fancy edit ">'.__('Configure').'</a>');

        $plgactions = $enplg.$remplg.$plgconf;

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

        perm('plugins', 'disablePlugin', $this->Session->read("user_perm"), true);

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';

    	//Disable plugin
    	$args = array($name);
    	$api->call("disablePluginTemporarily", $args, false);
        w_serverlog($this->Session->read("current_server"), __('[PLUGINS] ').$this->Auth->user('username').' '.__('disabled').' '.$name);
        echo $name.__(' has been disabled.');
    }
    }

    function enable_plugin($name) {

        perm('plugins', 'disablePlugin', $this->Session->read("user_perm"), true);

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';

		//Disable plugin
		$args = array($name);
		$api->call("enablePluginTemporarily", $args, FALSE);
        w_serverlog($this->Session->read("current_server"), __('[PLUGINS] ').$this->Auth->user('username').' '.__('enabled').' '.$name);
        echo $name.__(' has been enabled.');

    }
    }

    function update_plugin($name) {

        perm('plugins', 'updatePlugin', $this->Session->read("user_perm"), true);

        require APP . 'spacebukkitcall.php';

        //Disable plugin
        $args = array($name, true);
        $api->call("pluginUpdate", $args, true);
        $w = $api->call('getWorlds', array(), false);
        while(empty($w)) {
            sleep(2);
            $w = $api->call('getWorlds', array(), false);
        }
        w_serverlog($this->Session->read("current_server"), __('[PLUGINS] ').$this->Auth->user('username').' '.__('updated').' '.$name);

        $this->redirect(array('controller' => 'Tplugins', 'action' => 'index'));


    }

    function config($name) {

        perm('plugins', 'configurePlugin', $this->Session->read("user_perm"), true);

        require APP . 'spacebukkitcall.php';

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
			$content[$file]["content"] = $api->call("getFileContent", $args2, true, false);
            $this->log($content[$file]["content"]);
            $content[$file]["file"] = $file;

		}

        //set variables
    	$this->set('plugin_name', $name);
        $this->set('files', $files);
    	$this->set('contents', $content);
        $this->layout = 'popup';

    }


    function SaveConfig() {

        perm('plugins', 'configurePlugin', $this->Session->read("user_perm"), true);
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        } else {

            $data = $this->request->data;

            require APP . 'spacebukkitcall.php';

            $path = str_replace("@@", "/", $data["path"]);

            $content = $data["config_content"];

            //echo $path;

            $method = $data['method'];

            $args = array($path, $content);
            $api->call("setFileContent", $args, true);

            $args = array();

            if ($method == "reload") {

                $api->call("reloadServer", $args, false);
                sleep(10);

            } elseif ($method == "restart") {

                $args2 = array($this->Session->read("Sbvars.10"), "Server will restart due to plugin configuration save...");
                $api->call("broadcastWithName", $args2, false);
                sleep(2);

                $args = array('true');
                $api->call("restartServer", $args, true);
                sleep(5);
                while (is_null($api->call('getWorlds', array(), false))) {
                    sleep(1);
                }


            }
            echo "ok!";
        }
    }


    /*

     * The following functions are related to installing plugins

    */

    function URLinstall() {

        perm('plugins', 'removeAddPlugin', $this->Session->read("user_perm"), true);

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        } else {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $url = $this->request->data;

            $name = basename($url['url']);

            $ext = substr($name, strrpos($name, '.') + 1);

            if (!(($ext=="zip") || ($ext=="jar"))){
                $jsonout = array("ret" => false, "msg" => "Invalid file format!");
                exit(json_encode($jsonout));
            }

            //Check if it exists
            $args = array('plugins');
            $plugins = $api->call("listFiles", $args, true);

            if (in_array($name, $plugins)) {
                $jsonout = array("ret" => false, "msg" => "File already installed!");
                exit(json_encode($jsonout));
            }

            //Install plugin
            $args = array($url["url"], $name);
            $ret = $api->call("pluginInstallByURL", $args, true);

            //Dummy call to listen for reload
            $args = array();
            $api->call("getOPs", $args, false);
            $jsonout = array("ret" => true, "msg" => "Plugin installed!");
            echo json_encode($jsonout);
        }
    }

    function remove_plugin($name) {

        perm('plugins', 'removeAddPlugin', $this->Session->read("user_perm"), true);

        require APP . 'spacebukkitcall.php';

        //DeInstall plugin
        $args = array($name, false);
        $api->call("pluginRemove", $args, true);

        //Dummy call to listen for reload
        $args = array();
        $api->call("getOPs", $args, false);

        $this->redirect(array('controller' => 'Tplugins', 'action' => 'index'));

    }
  function config2($name) {

        perm('plugins', 'configurePlugin', $this->Session->read("user_perm"), true);

        require APP . 'spacebukkitcall.php';

        //set variables
        $this->set('plugin_name', $name);
        $this->layout = 'popup';

    }


    //load directory

    function loadFile($path) {

        $this->disableCache();
        //Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';

        $path = urldecode($path);

        //construct path

        $p =  str_replace("@@", "/", $path);

        $args = array($p);

        return($api->call('getFileContent', $args, true, false));

    }

    //load tree view of a directory

    function loadTree() {


        $this->disableCache();
        //Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';

        $path = urldecode($this->params['url']['path']);

        //construct path

        $p =  str_replace("@@", "/", $path);

        $args = array($p);

        $fs = $api->call('listFilesAndDirectories', $args, true);

        $data = array();

        foreach ($fs as $n => $dir) {

            $args = array($p . '/' . $dir);

            $details = $api->call('getFileInformations', $args, true);

            $full = $p . '/' . $dir;

            $id   = str_replace("//", "/", $full);
            $id   = str_replace(".", "root_", $id);

            $filename = $details['Name'];
            $filemime = $details['Mime'];
            $ext = explode(".", $filename);

            $ext = end($ext);

            if ($details['IsFile'] && ($ext == 'log' || $ext == 'yml' || $ext == 'properties')) {

                $filemime = 'text/plain';

            }

            $filemime = str_replace("/", "-", $filemime);

            $full =  str_replace("/", "@@", $full);
            $full =  str_replace("@@@@", "@@", $full);
            $type = $details['IsDirectory'] ? 'folder' : 'file';
            $icon = $details['IsDirectory'] ? '' : $this->webroot . 'filemanager/16/'.$filemime. '.png';
            $state = $details['IsDirectory'] ? 'closed' : '';

            $data[$n] = array(

                'attr'  => array('data-path' => $full, 'id' => $id, 'data-type' => $type),
                'data'  => array(
                    'title' => $dir,
                    'icon' => $icon
                    ),
                'state' => $state

            );

        }

        //output the json encoded object

        echo json_encode($data);

    }

}

?>