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
*   2)  calculate_players
*   3)  calculate_java
*   4)  get_chat
*   5)  get_log
*   6)  saysomething
*   
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
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

		if (is_null($running)) {

        $this->layout = 'sbv1_notreached'; 
                     
        } 

        elseif (!$running) {

        $this->layout = 'sbv1_notrunning';

    	} 

    	elseif ($running) {

    	//IF IT'S RUNNING, CONTINUE WITH THE PROGRAM

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

		//worlds stats

		//get all worlds
		$args = array();   	
        $worlds = $api->call("getAllWorlds", $args, true);
        //get the enabled worlds
        $loadedWorlds = $api->call("getWorlds", $args, false);  

        if (!(is_array($loadedWorlds))) {
        	
        	$loadedWorlds = array();

        }

        $worlds_count = array();
        $worlds_count["normal"] = 0;
        $worlds_count["nether"] = 0;
        $worlds_count["sky"] = 0;
        $worlds_count["end"] = 0;

		foreach ($worlds as $w) {

            //if the world is loaded get all info
            if(in_array($w, $loadedWorlds) != NULL){
            
            $args = array($w);
            $worldInfo = $api->call("getWorldInformations", $args, false);  
            
            //count worlds
			if ($worldInfo['Environment'] == "NORMAL") {
			    $worlds_count["normal"] = $worlds_count["normal"]+1;
			} elseif ($worldInfo['Environment'] == "NETHER") {
			    $worlds_count["nether"] = $worlds_count["nether"]+1; 
			} elseif ($worldInfo['Environment'] == "SKYLANDS") {
			    $worlds_count["sky"] = $worlds_count["sky"]+1; 
			} elseif ($worldInfo['Environment'] == "THE_END") {
			    $worlds_count["end"] = $worlds_count["end"]+1; 
			}
			
        	}
    	}
                  

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
    	$this->set('worlds_count', $worlds_count);
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
    

	function calculate_players() {

        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

   	    require APP . 'spacebukkitcall.php';

		$args = array();   
		$server = $api->call("getServer", $args, false);

		$user_online = $server['OnlinePlayers'];
		$user_max = $server['MaxPlayers'];
        //Generate Output

        echo $user_online.' / '.$user_max;
        } 	 
    }
    

	function calculate_ticks() {

        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

   	    require APP . 'spacebukkitcall.php';

		$args = array();   
		$tick = $api->call("getTicks", $args, false);

		echo round($tick);

        } 	 
    }

	function calculate_ram() {

        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

   	    require APP . 'spacebukkitcall.php';


		//Function to get percentage	
		function percent($num_amount, $num_total) {
		$count1 = @($num_amount / $num_total);
		$count2 = $count1 * 100;
		$count = number_format($count2, 0);
		return $count;
		}
		
		$args = array();   
		$ram = array();

		$ram['tot'] = $api->call("getPhysicalMemoryTotal", $args, false);
		$ram['used'] = $api->call("getPhysicalMemoryUsage", $args, false);
		$ram['free'] = $api->call("getPhysicalMemoryFree", $args, false);
		$ram['perc'] = percent($ram['used'], $ram['tot']);

        //Generate Output

		echo json_encode($ram);        
        
        } 	 
    }

	function calculate_cpu() {

        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

   	    require APP . 'spacebukkitcall.php';
	
		//get the Java Memory
		$args = array();   
		$java = array();
		$java['tot'] = $api->call("getNumCpus", $args, false);
		//$java['used'] = $api->call("getCpuFrequency", $args, false);
		$java['used'] = null;
		$java['free'] = null;
		$java['perc'] = $api->call("getCpuUsage", $args, false);

        //Generate Outpu
		echo json_encode($java);        
        
        } 	 
    }

	function calculate_java() {

        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

   	    require APP . 'spacebukkitcall.php';


		//Function to get percentage	
		function percent($num_amount, $num_total) {
		$count1 = @($num_amount / $num_total);
		$count2 = $count1 * 100;
		$count = number_format($count2, 0);
		return $count;
		}
	
		//get the Java Memory
		$args = array();   
		$java = array();
		$java['tot'] = $api->call("getJavaMemoryMax", $args, false);
		$java['used'] = $api->call("getJavaMemoryUsage", $args, false);
		$java['free'] = $java['tot'] - $java['used'];
		$java['perc'] = percent($java['used'], $java['tot']);

        //Generate Output

		echo json_encode($java);        
        
        } 	 
    }
	function get_log() {

        if ($this->request->is('ajax')) 
        {
            
            $this->autoRender = false;
			$log = r_serverlog($this->Session->read("current_server"));
			$logged = array_reverse( preg_split("/(\r?\n)/", $log) );

			$i = 0;

            //Generate Output
            foreach($logged as $line){
            
            $line = explode(']', $line, 2);

            if (isset($line[1])) {

echo <<<END
                      <li>
                        <b>$line[0]</b> 
                        <p class="console-info"> $line[1] </p>
                      </li>

END;
            	
            }

		    if (++$i == 30) break;

			}

        } 

    }

	function get_admins() {

        if ($this->request->is('ajax')) 
        {
            
            $this->autoRender = false;
			
			$this->loadModel('User');

			$users = $this->User->find('all');

			foreach ($users as $user) {

				$c = time();
				$t = $user['User']['active'];

            if (($c - $t) < 1800) {

				$n = $user['User']['username'];

echo <<<END
                      <tr>
                        <td> $n </td>
                      </tr>

END;
            	
            }

			}

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

        	$time = substr($time, 0, -3); 
        	$time = date( "d/m/Y g:i:s A", $time);

        	$chat = explode(':', $chat, 2);

        	if ($chat[0] == "SpaceBukkit") {
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

			echo '<tr><td>'.__('Nobody online :').'(</td></tr>';

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

	      $args = array('SpaceBukkit', "(".$this->Auth->user('username').") ".$say['say']);

	      $runConsole = $api->call("broadcastWithName", $args, false);  
	      echo __('You said ').$say['say'];

		  w_serverlog($this->Session->read("current_server"), '[DASHBOARD] '.$this->Auth->user('username').' said "'.$say['say'].'" ');

	  } 
	  }
              
    }

}

?>