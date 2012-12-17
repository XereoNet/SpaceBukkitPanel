<?php

/**
*
*   ####################################################
*   GlobalController.php
*   ####################################################
*
*   DESCRIPTION
*
*   This controller manages functions that are accessed globally
*   across the application.
*
*   TABLE OF CONTENTS
*
*   1)  index
*   2)  getServers
*   3)  getConsole
*   4)  reload
*   5)  restart
*   6)  stop
*   7)  start
*   8)  setserver
*   9)  addserver
*   9)  delserver
*   9)  addserver_exec
*   9)  runcommand
*   10)  no_servers_set
*   11)  no_servers_set_manage
*   12)  no_servers_assoc
*
*
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class GlobalController extends AppController {

    public $helpers = array ('Html','Form');

    public function beforeFilter()

    {
      parent::beforeFilter();

    }

    public $name = 'GlobalController';

      function index() {

        $this->redirect($this->referer());

      }

      function login() {

            $this->autoRender = false;

            //GET request to XereoNet for statistics

            include APP . 'webroot/configuration.php';

            if($sbconf['token'] == '%*TOKEN*%') {

                $this->loadModel('Configurator');
                $sbconf['token'] = $this->Configurator->saveCore();

            }

            $this->loadModel('Server');
            $this->loadModel('User');

            $url = 'api.xereo.net/Spacebukkit/store/'.$sbconf['token'].'/'.$this->Server->find('count').'/'.$this->User->find('count');

            $c = curl_init($url);
            curl_setopt($c, CURLOPT_PORT, 80);
            curl_setopt($c, CURLOPT_HEADER, false);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_exec($c);
            curl_close($c);

            //check if the user has access to dash

            $user_perm = $this->Session->read("user_perm");
            $glob_perm = $this->Session->read("glob_perm");

            if ($user_perm['pages'] & $glob_perm['pages']['dash']) {

               $this->redirect($this->Auth->redirect());

            }

            //if not, do a foreach with all "pages" perms to check what page is allowed

            else {

              if ($this->Auth->user('is_super') == 1) {

                $redirect = 'dash';

              } else {

              foreach ($glob_perm['pages'] as $desc => $node) {

                if ($user_perm['pages'] & $node) {

                   $redirect = $desc;

                   break;

                }

              }

              }

              if ($redirect == 'users') {
                $this->redirect(array('controller' => 'tplayers', 'action' => 'index'));
              } elseif ($redirect == 'dash') {
                $this->redirect(array('controller' => 'dash', 'action' => 'index'));
              } elseif ($redirect == 'plugins') {
                $this->redirect(array('controller' => 'tplugins', 'action' => 'index'));
              } elseif ($redirect == 'worlds') {
                $this->redirect(array('controller' => 'tworlds', 'action' => 'index'));
              } elseif ($redirect == 'servers') {
                $this->redirect(array('controller' => 'tservers', 'action' => 'index'));
              } else {
                exit('You have absolutely no permissions on this Spacebukkit, sorry :(');
              }

            }

      }

      function avatar($name = 'Antariano', $size = 100) {

        header("Content-type: image/png");

        $this->autoRender = false;

        //1) check if avatar exists in /avatars

        $avatar = new File(TMP . 'avatars' . DS . $name .'.png');

        //2) check if it younger then 6h

        if ($avatar->exists()) {

          $last_modified = filemtime($avatar->path);

          $current_time = time();

          $dif = $current_time - $last_modified;

        }
        //generate avatar if !1) || !2) and save him

        if (!$avatar->exists() || !$dif > 21600 ) {

          $src = @imagecreatefrompng("http://minecraft.net/skin/{$name}.png");

          if (!$src) {
            $src = @imagecreatefrompng(APP . 'webroot/img/char.png');
          }

          $dest   = imagecreatetruecolor(8, 8);
          imagecopy($dest, $src, 0, 0, 8, 8, 8, 8);   // copy the face

          // Check to see if the helm is not all same color
          $bg_color = imagecolorat($src, 0, 0);

          $no_helm = true;

          // Check if there's any helm
          for ($i = 1; $i <= 8; $i++) {
            for ($j = 1; $j <= 4; $j++) {
              // scanning helm area
              if (imagecolorat($src, 40 + $i, 7 + $j) != $bg_color) {
                $no_helm = false;
              }
            }

            if (!$no_helm)
              break;
          }


          if (!$no_helm) {
            // copy the helm
            imagecopy($dest, $src, 0, -1, 40, 7, 8, 4);
          }

          // now resize
          $final = imagecreatetruecolor($size, $size);
          imagecopyresized($final, $dest, 0, 0, 0, 0, $size, $size, 8, 8);

          // cleanup time
          imagepng($final, $avatar->path);

          imagedestroy($dest);
          imagedestroy($final);
          readfile($avatar->path);
          exit();

        } else {

          readfile($avatar->path);
          exit();

        }

      }

      function getServer($id) {

      if ($this->request->is('ajax')) {

            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $bukkit = $this->Server->findById($id);

            //DATABASE SERVER RETRIVAL
            $server = $bukkit['Server']['address'];
            $salt = $bukkit['Server']['password'];

            //call API
            $api = new SpaceBukkitAPI($server, 2011, 2012, $salt);
            $args = array();

            $running = $api->call("isServerRunning", $args, true);

                  if($running == 1)
                  {

                    $run = "circle_green.png";

                  } elseif ($running == 0)

                  {

                    $run = "circle_orange.png";

                  } else {

                    $run = "circle_red.png";

                  }

                echo '<img src="img/'.$run.'" style="margin-right: 10px"/>';
      }
    }

    function test() {

            require APP . 'spacebukkitcall.php';

            $this->disableCache();
            $this->autoRender = false;

            $methods = array('broadcast', 'broadcast');
            $args = array(
              array('test'),
              array('test')
            );

            $api->callMultiple($methods, $args);
    }

      function getConsole($filter=null) {

        if ($this->request->is('ajax'))
        {

            require APP . 'spacebukkitcall.php';

            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            $args = array($this->Session->read("Sbvars.1"));
            $log = $api->call("getLatestConsoleLogsWithLimit", $args, false);

            echo '<ul>';

            foreach (array_reverse($log) as $c) {

              $hidden = 'hidden';

              //split the string
              $c = explode("[", $c, 2);

              //check for color the string
              if (strpos($c[1], 'WARNING' ) === 0) {

                $class = "warning";

                if ($filter == 'warning') {
                  $hidden = '';
                }

              }
              elseif (strpos($c[1], 'SEVERE') === 0) {

               $class = "warning";
                if ($filter == 'severe') {
                  $hidden = '';
                }
              }
              elseif (strpos($c[1], 'INFO') === 0) {

                $class = "info";
                if ($filter == 'info') {
                  $hidden = '';
                }

              } else {
                $class = "info";
              }

              if ($filter == 'all') {
                $hidden = '';
              }

              echo <<<END
                <li class="$hidden"><b>$c[0]</b> <p class="console-$class"> [$c[1]</p></li>
END;

            }
            echo '</ul>';


        }

    }
      function getUpTime() {

        if ($this->request->is('ajax'))
        {

            require APP . 'spacebukkitcall.php';

            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            $args = array();
            $secs = $api->call("getUpTime", $args, false);

            //echo date('d:h:m:s', $time);
           $times = array(3600, 60, 1);
           $time = '';
           $tmp = '';
           for($i = 0; $i < 3; $i++) {
              $tmp = floor($secs / $times[$i]);
              if($tmp < 1) {
                 $tmp = '00';
              }
              elseif($tmp < 10) {
                 $tmp = '0' . $tmp;
              }
              $time .= $tmp;
              if($i < 2) {
                 $time .= ':';
              }
              $secs = $secs % $times[$i];
           }
           echo $time;

        }

    }

      function reload() {

        require APP . 'spacebukkitcall.php';

        $args = array();
        $api->call("reloadServer", $args, false);

        w_serverlog($this->Session->read("current_server"), '[GLOBAL] '.$this->Auth->user('username').' '.__('reloaded the server.'));

        //Dummy call to listen for reload
        $args = array();
        $api->call("getWorlds", $args, true);

        sleep(10);

        $this->redirect($this->referer());


      }

      function restart() {

        require APP . 'spacebukkitcall.php';

        $args = array(true);
        $api->call("restartServer", $args, true);

        w_serverlog($this->Session->read("current_server"), '[GLOBAL] '.$this->Auth->user('username').' '.__('restarted the server.'));

        //Dummy call to listen for reload
        $args = array();
        $api->call("getWorlds", $args, true);

        $this->redirect($this->referer());

      }

      function frestart() {

        require APP . 'spacebukkitcall.php';

        $args = array();
        $api->call("forceRestart", $args, true);

        w_serverlog($this->Session->read("current_server"), '[GLOBAL] '.$this->Auth->user('username').' '.__('forced a restart on the server.'));

        //Dummy call to listen for reload
        $args = array();
        $api->call("getWorlds", $args, true);

        $this->redirect($this->referer());

      }
      function stop() {

        require APP . 'spacebukkitcall.php';
        $args = array();
        $running = $api->call("isServerRunning", $args, true);

        if ($running)
        {
        $api->call("stopServer", $args, true);
        sleep(5);
        }

        w_serverlog($this->Session->read("current_server"), '[GLOBAL] '.$this->Auth->user('username').' '.__('stopped the server.'));

        $this->redirect($this->referer());

      }

      function fstop() {

        require APP . 'spacebukkitcall.php';
        $args = array();
        $running = $api->call("isServerRunning", $args, true);
        if ($running)
        {
        $api->call("forceStop", $args, true);
        sleep(5);
        }

        w_serverlog($this->Session->read("current_server"), '[GLOBAL] '.$this->Auth->user('username').' '.__('forced the server to stop.'));

        $this->redirect($this->referer());

      }
      function start() {

        require APP . 'spacebukkitcall.php';
        $args = array();
        $running = $api->call("isServerRunning", $args, true);

        if ($running == 0)
        {
        $api->call("startServer", $args, true);
        sleep(13);
        }
        $this->redirect($this->referer());

        w_serverlog($this->Session->read("current_server"), '[GLOBAL] '.$this->Auth->user('username').' '.__('started the server.'));

      }


      function setserver($id) {

        $data = $this->ServersUsers->find('first', array('conditions' => array('ServersUsers.user_id' => $this->Auth->user('id'), 'Server.id' => $id)));

        if ((!empty($data)) || ($this->Auth->user('is_super') == 1)) {

        $this->Session->write("current_server", $id);

        } else { exit("You can't do that!");}

        $this->redirect($this->referer());

    }

      function addserver() {

        $this->layout = 'popup';

    }

    function delserver($id = null) {
        $this->Server->id = $id;
        if (!$this->Server->exists()) {
            throw new NotFoundException(__('Invalid server!'));
        }
        if ($this->Server->delete()) {
            $this->Session->setFlash(__('The server has been deleted!'));
            $getserver = $this->Server->find('first');
            $this->Session->write("current_server", $getserver['Server']['title']);
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('The server was not deleted!'));
        $this->redirect($this->referer());
    }

      function addserver_exec() {

        if ($this->request->is('post')) {
            if ($this->Server->save($this->request->data)) {
                $this->Session->setFlash(__('The server has been added!'));
            }
        }
                   $this->redirect($this->referer());

    }


      function runcommand() {

      if ($this->request->is('ajax'))
      {

            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

      if ($this->request->is('post')) {

          $command = $this->request->data;

          require APP . 'spacebukkitcall.php';

          $command = str_replace("/", "", $command['command']);

          $args = array($command);

          $runConsole = $api->call("consoleCommand", $args, true);
          echo __('The command').' "' . $command . '" '.__('was executed!');
          //Sleep if command is 'stop'
          if ($command == 'stop') {
             sleep(7);
          }

      }
      }
      w_serverlog($this->Session->read("current_server"), '[GLOBAL] '.$this->Auth->user('username').' '.__('executed the command').' "'.$command.'"');

    }

      function call() {

      if ($this->request->is('ajax'))
      {

            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

        if ($this->request->is('post')) {

            $data = $this->request->data;

            require APP . 'spacebukkitcall.php';

            $data['call'];

            $args = array($data['args']);

            $result = $api->call($data['rtk'], $args, $data['rtk']);

        }

      }

    }

      function debug_call($call=null, $arg=null, $rtk = false) {



            $this->autoRender = false;

            $data = $this->request->data;

            require APP . 'spacebukkitcall.php';

            $data['call'] = $call;
            $data['args'] = $arg;

            if ($data['args'] == NULL) {
              $args = array();
            } else {
              $args = array($arg);
            }

            $starttime = microtime(true);

            $result = $api->call($call, $args, $rtk);

            $stoptime  = microtime(true);

            $time = floor(($stoptime - $starttime) * 1000);

            echo <<<END

=============================================================<br><br>

You called '$data[call]' with the arguments '$data[args]' <br><br>

The server responded in $time milliseconds with:<br><br>

=============================================================<br><br>

END;

debug($result, true, false);

    }

    function no_servers_set() {
      $this->set('title_for_layout', __('No servers set'));
      $this->layout = 'ajax';

    }

    function no_servers_set_manage() {
      $this->set('title_for_layout', __('No server set | Manage'));
      $this->layout = 'ajax';

    }

    function no_servers_assoc() {
      $this->set('title_for_layout', __('No servers associated'));
      $this->layout = 'ajax';

    }

    function maintenance() {
      $this->set('title_for_layout', __('SpaceBukkit is in maintenance mode'));
      $this->layout = 'ajax';

    }

    function serverConnectionInfo($id) {

      if ($this->request->is('ajax')) {

        $this->disableCache();
        Configure::write('debug',3);
        $this->layout = 'ajax';

        $this->loadModel('Server');

        $server = $this->Server->findById($id);

        $this->set('server', $server);

        //check ports

        $string1 = $server['Server']['address'].':'.$server['Server']['port1'].'/ping';
        $string2 = $server['Server']['address'].':'.$server['Server']['port2'].'/ping';


        if($this->get_data_curl($string1) == "Pong!" ) {
          $this->set('port1', 'Pinged successfully');
        } else {
          $this->set('port1', 'Could not ping port. is it forwarded correctly, is it being used at all by SpaceBukkit?');
        }

        if($this->get_data_curl($string2) == "Pong!" ) {
          $this->set('port2', 'Pinged successfully');
        } else {
          $this->set('port2', 'Could not ping port. is it forwarded correctly, is it being used at all by SpaceBukkit?');
        }

        //check salt

        include APP.'spacebukkitcall.php';

        $args = array();
        $running = $api->call("isServerRunning", $args, true);

        $this->set('running', $running);

        if (is_null($running)) {

          $answer = 'Server was not reached. Could not check Salt.';

        } elseif ($running == "salt") {

          $answer = 'Incorrect Salt supplied. If you changed it in the config, make sure you restarted Remote Toolkit with ".stopwrapper" and "sh rtoolkit.sh".';

        } elseif ($running == 'true' || $running == 'false') {

          $answer = 'Correct Salt supplied.';

        }

        $this->set('salt', $answer);

      }

    }

    function get_data_curl($url)
    {
      $c = curl_init($url);
      curl_setopt($c, CURLOPT_HEADER, false);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($c);
      curl_close($c);
      return $result;
    }

}
?>
