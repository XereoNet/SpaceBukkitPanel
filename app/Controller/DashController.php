<?php

/**
*
*   ####################################################
*   DashController.php
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is relative to the "Dash" page and all it's related functions.
*
*   TABLE OF CONTENTS
*
*   1)  index
*	Active functions: (ajax updates)
*   	2)  graphs
*   	3)  panelInfo (logs, admins, etc.)
*		4)	serverInfo (users, ticks)
*   4)  get_chat
*   5)  get_log
*   6)  saysomething
*
*
* @copyright  Copyright (c) 2012 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano/Jamy
* @since      File available since Release 1.0
*
*
*/

class DashController extends AppController {

    public $helpers = array ('Html','Form');

    public $name = 'DashController';

	public function beforeFilter()

	  {
    	parent::beforeFilter();

	  	//check if user has rights to do this
	  	$user_perm = $this->Session->read("user_perm");
	  	$glob_perm = $this->Session->read("glob_perm");

        if (!($user_perm['pages'] & $glob_perm['pages']['dash'])) {

           exit("access denied");

        }
	  }

    function index() {

    	/*

    	*	Connection Check - Is the server running? Redirect accordingly.

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

    	require APP . 'webroot/configuration.php';
        $this->layout = 'sbv1';

		//get the data
		$args = array();
		$server = $api->call("getServer", $args, false);

		//Function to get percentage
		function percent($num_amount, $num_total) {
		$count1 = @($num_amount / $num_total);
		$count2 = $count1 * 100;
		$count = number_format($count2, 0);
		return $count;
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

		//Function to get count of array
		function countWhere($input = 1, $operator = '==', $where = 1)
		{
		    $input = is_array($input) ? $input : (array)$input;
		    $operator = !in_array($operator, array('<','>','<=', '>=','==', '!=')) ? '==' : $operator;

		    $i = 0;

		    foreach($input as $current)
		    {
		        $match = null;
		        eval('$match = (bool)("'.$current.'"'.$operator.'"'.$where.'");');

		        $i = $match ? $i+1 : $i;
		    }

		    return $i;
		}

		//get CURRENT craftbukkit version

		$c_bukkit_version = get_string_between($server['Version'], "-b", "jnks");

		//get LATEST craftbukkit version

		$filename = 'http://dl.bukkit.org/api/1.0/downloads/projects/craftbukkit/view/latest-rb/';
		$load_bukkit_version = json_decode(file_get_contents($filename));
		$l_bukkit_version = $load_bukkit_version->build_number;

		//check if update is needed
		if ($c_bukkit_version > $l_bukkit_version) {
		    $m_bukkit_version = '<p class="cell_small win">'.__('Up to date (devbuild)').'!</p>';
		} elseif ($c_bukkit_version == $l_bukkit_version) {
		    $m_bukkit_version = '<p class="cell_small win">'.__('Up to date!').'</p>';
		} else {
		    $m_bukkit_version = '<p class="cell_small fail"><a href="./tservers">'.__('Outdated!').'</a></p>';
		}

		//plugin stats
		$args = array();
		$plugin_count = count($api->call("getPlugins", $args, false));
		$dis_plugin_count = count($api->call("getDisabledPlugins", $args, false));

		//staff stats

		$current_server_id = $this->Server->findById($this->Session->read("current_server"));

		$connected_users = count($current_server_id['ServersUsers']);

		//player stats
        $args = array();

		$whitelist_count = count($api->call("getWhitelist", $args, false));
		$ban_count = count($api->call("getBanned", $args, false));
		$max_players = $server['MaxPlayers'];

		//MOTD

        $args = array("server.properties");
		$config = $api->call("getFileContent", $args, true);
    	$this->set('motd', get_string_between($config, "motd=", "\n"));

		//view-specific settings
    	$this->set('c_bukkit_version', $c_bukkit_version);
       	$this->set('m_bukkit_version', $m_bukkit_version);
    	$this->set('plugin_count', $plugin_count);
    	$this->set('dis_plugin_count', $dis_plugin_count);
    	$this->set('ban_count', $ban_count);
    	$this->set('whitelist_count', $whitelist_count);
    	$this->set('max_players', $max_players);
    	$this->set('connected_users', $connected_users);
    	$this->set('title_for_layout', 'Dashboard');

    	/*

    	*	End Connectioncheck "if" statement

    	*/

     	}
 	}

    // --------------------------------------------------------------------------------------------------
    // | Active functions (ajax invoked functions)                                                      |
    // --------------------------------------------------------------------------------------------------

    function graphs() {
        perm('dash', 'Stats', $this->Session->read("user_perm"), true);

    	if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';
            $args = array();
            // Ram
            //Function to get percentage
			function percent($num_amount, $num_total) {
				$count1 = @($num_amount / $num_total);
				$count2 = $count1 * 100;
				$count = number_format($count2, 0);
				return $count;
			}
			$ram = array();

			$ram['tot'] = $api->call("getPhysicalMemoryTotal", $args, false);
			$ram['used'] = $api->call("getPhysicalMemoryUsage", $args, false);
			$ram['free'] = $api->call("getPhysicalMemoryFree", $args, false);
			$ram['perc'] = percent($ram['used'], $ram['tot']);

            // CPU
			//get the cpu
			$cpu = array();
			$cpu['tot'] = $api->call("getNumCpus", $args, false);
			//$cpu['used'] = $api->call("getCpuFrequency", $args, false);
			$cpu['perc'] = $api->call("getCpuUsage", $args, false);

            // Java
            $java = array();
			$java['tot'] = $api->call("getJavaMemoryMax", $args, false);
			$java['used'] = $api->call("getJavaMemoryUsage", $args, false);
			$java['free'] = $java['tot'] - $java['used'];
			$java['perc'] = percent($java['used'], $java['tot']);

			// Combine
			$result = array("ram" => $ram, "cpu" => $cpu, "java" => $java);
			echo json_encode($result);
		}
    }

    function panelInfo() {
        perm('dash', 'Activity', $this->Session->read("user_perm"), true);
    	if ($this->request->is('ajax')) {
    		$this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            //serverlog
            $log = r_serverlog($this->Session->read("current_server"));
			$logged = array_reverse( preg_split("/(\r?\n)/", $log) );
			$i = 0;
			$serverlog = '';

			foreach ($logged as $line) {
				$line = explode(']', $line, 2);
				if (isset($line[1])) {
					$serverlog .= '<li><b>'.$line[0].']</b><p class="console-info"> '.$line[1].' </p></li>';
				}
				if (++$i == 30) break;
			}
			$serverlog .= '<a href="./servers/clearLog" class="right" style="float: right; font-size: 10px;" id="clearlog">'.__('Clear log!').'</a>';
			//admins
			$admins = '';
			$this->loadModel('User');
			$users = $this->User->find('all');
			foreach ($users as $user) {
				$c = time();
				$t = $user['User']['active'];
				if (($c - $t) < 1800) {
					$n = $user['User']['username'];;
					$admins .= '<tr><td> '.$n.'</td></tr>';
				}
			}

			//combine
			$result = array("serverlog" => $serverlog, "admins" => $admins);
			echo json_encode($result);
        }
    }

    function serverInfo() {
    	if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';
            $args = array();

            //players
            $server = $api->call("getServer", $args, false);
			$players_online = $server['OnlinePlayers'];
			$players_max = $server['MaxPlayers'];
			$players = $players_online.' / '.$players_max;

			//ticks
			$ticks = $api->call("getTicks", $args, false);
			$ticks = round($ticks);

			//combine
			$result = array("players" => $players, "ticks" => $ticks);
			echo json_encode($result);
        }
    }

	function get_chat_new() {

        if ($this->request->is('ajax'))
        {
 	      	require APP . 'spacebukkitcall.php';

            $this->autoRender = false;

            $args = array($this->Session->read("Sbvars.3"));
            $chats = $api->call("getLatestChatsWithLimit", $args, false);

            if(!is_array($chats)) $chats = array($chats);


            //Generate Output
            foreach (array_reverse($chats) as $time => $chat) {

        	$time = round($time / 1000, 0);
        	$time = date("d/m/Y g:i:s A", $time);

        	$chat = explode(':', $chat, 2);

        	if ($chat[0] == $this->Session->read("Sbvars.10")) {
        		$classes = "blue";
        	} else { $classes = "";}

            echo <<<END
            <tr>
              <td class="chatname $classes">$chat[0]</td>
              <td class="chattext">$chat[1]</td>
              <td class="chattime">$time</td>
            </tr>

END;
      		}

    	}

    }

	 function get_chat_players() {

        if ($this->request->is('ajax'))
        {

            $this->autoRender = false;

	      	require APP . 'spacebukkitcall.php';

            $args = array();

			$players = $api->call("getPlayers", $args, false);

			if (count($players) == 0) {

			echo '<tr><td>'.__('Nobody online').' :(</td></tr>';

			} else {

            foreach($players as $player){

			echo '<tr><td>'.$player.'</td></tr>';

				}
			}

        }

    }

	function saysomething() {

	  if ($this->request->is('ajax'))
	  {

	  if ($this->request->is('post')) {

		  $this->disableCache();
	   	  Configure::write('debug', 0);
	      $this->autoRender = false;

	      $say = $this->request->data;

	      require APP . 'spacebukkitcall.php';

	      $args = array($this->Session->read("Sbvars.10"), "(".$this->Auth->user('username').") ".$say['say']);

	      $runConsole = $api->call("broadcastWithName", $args, false);
	      echo __('You said ').$say['say'];

		  w_serverlog($this->Session->read("current_server"), '[DASHBOARD] '.$this->Auth->user('username').' said "'.$say['say'].'" ');

	  }
	  }

    }

}

?>