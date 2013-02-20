<?php
class InstallController extends AppController{
	
	function beforeFilter() {
		$this->Auth->allow('*');
		parent::beforeFilter();  
		$install = new File(TMP."inst.txt");

		if (!$install->exists()) exit("You are not allowed to be here!");
		App::uses('ConnectionManager', 'Model');

		
	}

	function index() {


		$this->layout = 'install';

		/* Check environment */

	}

	function upgrade($db = false) {
		if($this->request->is('post')) {
			$this->loadModel('Configurator');
			$this->disableCache();
			Configure::write('debug', 0);
			$this->autoRender = false;

		  //get all the data from the old database
			$hostname   = $this->request->data["hostname"];
			$username   = $this->request->data["username"]; 
			$password   = $this->request->data["password"]; 
			$database   = $this->request->data["database"]; 
		  //connect to old database
			$mysqli = new mysqli("$hostname", "$username", "$password", "$database");
			if ($mysqli->connect_errno) {
				$status =  "Failed to connect to MySQL: " . $mysqli->connect_error;
				$ret = array('status' => $status);
			} else { 
				$status = 'true';
				$mysql['users'] = $mysqli->query("SELECT * FROM `users` ORDER BY `users`.`id` ASC");
				if ($mysql['users']) {
					while ($row = $mysql['users']->fetch_array(MYSQLI_ASSOC)) {
						$users[] = $row;
					}
				} else {$status = '<br>Table \'users\' not found!';}

			//fetch servers
				$mysql['servers'] = $mysqli->query("SELECT * FROM `servers` ORDER BY `servers`.`id` ASC");
				if ($mysql['servers']) {
					while ($row = $mysql['servers']->fetch_array(MYSQLI_ASSOC)) {
						$servers[] = $row;
					}
				} else {$status .= '<br>Table \'servers\' not found!';}
			//fetch roles
				$mysql['roles'] = $mysqli->query("SELECT * FROM `roles` ORDER BY `roles`.`id` ASC");
				if ($mysql['roles']) {
					while ($row = $mysql['roles']->fetch_array(MYSQLI_ASSOC)) {
						$roles[] = $row;
					}
				} else {$status .= '<br>Table \'roles\' not found!';}
				$mysql['servers_users'] = $mysqli->query("SELECT * FROM `servers_users` ORDER BY `servers_users`.`id` ASC");
				if ($mysql['servers_users']) {
					while ($row = $mysql['servers_users']->fetch_array(MYSQLI_ASSOC)) {
						$servers_users[] = $row;
					}
				} else {$status .= '<br>Table \'servers_users\' not found!<br>Did you choose the correct database?';}

		  		//insert into mysql database
				if ($db == 'mysql') {
					$this->Configurator->saveDb('Database/Mysql', $hostname, $username, $password, $database);
					//import new database layout

					function executeSQLScript($db, $fileName) {
						$statements = file_get_contents($fileName);
						$statements = explode(';', $statements);

						foreach ($statements as $statement) {
							if (trim($statement) != '') {
								$db->query($statement);
							}
						}
					}

					$test = executeSQLScript($mysqli, WWW_ROOT.'app.sql');

					$mysqli->query("TRUNCATE TABLE  `space_servers_users`");
					$mysqli->query("TRUNCATE TABLE  `space_servers`");
					$mysqli->query("TRUNCATE TABLE  `space_users`");
					$mysqli->query("TRUNCATE TABLE  `space_roles`");

					foreach ($users as $u) {
						$query = "INSERT INTO  `space_users` (`id` ,`favourite_server` ,`username` ,`password` ,`created` ,`modified` ,`theme` ,`language` ,`is_super` ,`active`) VALUES ('$u[id]',  '$u[favourite_server]',  '$u[username]',  '$u[password]', NULL , NULL ,  '$u[theme]',  '$u[language]',  '$u[is_super]',  NULL);";
						$mysqli->query($query);
					}
					foreach ($servers as $s) {
						if (preg_match("/localhost/", $s['address']) || preg_match("/127.0.0.1/", $s['address']) || preg_match("/::1/", $s['address'])) {
							$s['external_address'] = file_get_contents("http://icanhazip.com/");
						} else {
							$s['external_address'] = $s['address'];
						}
						$query = "INSERT INTO  `space_servers` (`id` ,`title` ,`address` ,`password` ,`port1` ,`port2` ,`default_role` ,`external_address`) VALUES ('$s[id]',  '$s[title]',  '$s[address]',  '$s[password]',  '$s[port1]',  '$s[port2]',  '$s[default_role]',  '$s[external_address]');";
						$mysqli->query($query);
					}
					foreach ($roles as $r) {
						$query = "INSERT INTO  `space_roles` (`id` ,`title` ,`pages` ,`global` ,`dash` ,`users` ,`plugins` ,`worlds` ,`servers` ,`settings` ,`fallback`) VALUES ('$r[id]',  '$r[title]',  '$r[pages]',  '$r[global]',  '$r[dash]',  '$r[users]',  '$r[plugins]',  '$r[worlds]',  '$r[servers]',  '$r[settings]',  '$r[fallback]');";
						$mysqli->query($query);
					}
					foreach ($servers_users as $su) {
						$query = "INSERT INTO  `servers_users` (`id` ,`user_id` ,`server_id` ,`role_id`) VALUES ('$su[id]',  '$su[user_id]',  '$su[server_id]',  '$su[role_id]');";
						$mysqli->query($query);
					}


				} else if ($db == 'sqlite') {
					$this->Configurator->saveDb("Database/Sqlite", "", "", "", '../spacebukkit.sqlite');
					$db = new sqlite3('../spacebukkit.sqlite');
			//clear all tables
					$db->query("DELETE FROM  `space_servers_users`");
					$db->query("DELETE FROM  `space_users`");
					$db->query("DELETE FROM  `space_servers`");
					$db->query("DELETE FROM  `space_roles`");

			//import old db
					foreach ($users as $u) {
						$db->query("INSERT INTO  `space_users` (`id` ,`favourite_server` ,`username` ,`password` ,`created` ,`modified` ,`theme` ,`language` ,`is_super` ,`active`) VALUES ('$u[id]',  '$u[favourite_server]',  '$u[username]',  '$u[password]', NULL , NULL ,  '$u[theme]',  '$u[language]',  '$u[is_super]',  NULL);");
					}
					foreach ($servers as $s) {
						if (preg_match("/localhost/", $s['address']) || preg_match("/127.0.0.1/", $s['address']) || preg_match("/::1/", $s['address'])) {
							$s['external_address'] = file_get_contents("http://icanhazip.com/");
						} else {
							$s['external_address'] = $s['address'];
							$db->query("INSERT INTO  `space_servers` (`id` ,`title` ,`address` ,`password` ,`port1` ,`port2` ,`default_role` ,`external_address`) VALUES ('$s[id]',  '$s[title]',  '$s[address]',  '$s[password]',  '$s[port1]',  '$s[port2]',  '$s[default_role]',  '$s[external_address]');");              
						}
						foreach ($roles as $r) {
							$db->query("INSERT INTO  `space_roles` (`id` ,`title` ,`pages` ,`global` ,`dash` ,`users` ,`plugins` ,`worlds` ,`servers` ,`settings` ,`fallback`) VALUES ('$r[id]',  '$r[title]',  '$r[pages]',  '$r[global]',  '$r[dash]',  '$r[users]',  '$r[plugins]',  '$r[worlds]',  '$r[servers]',  '$r[settings]',  '$r[fallback]');");
						}
						foreach ($servers_users as $su) {
							$db->query("INSERT INTO  `servers_users` (`id` ,`user_id` ,`server_id` ,`role_id`) VALUES ('$su[id]',  '$su[user_id]',  '$su[server_id]',  '$su[role_id]');");
						}

					}

				}

				echo $status;
			}
		} else {
				$this->layout = 'install';
		}
	}

		function getOldMysql() {
			if ($this->request->is('post')) { 
				$this->disableCache();
				Configure::write('debug', 0);
				$this->autoRender = false;

				$hostname   = $this->request->data["hostname"];
				$username   = $this->request->data["username"]; 
				$password   = $this->request->data["password"]; 
				$database   = $this->request->data["database"]; 
		  //connect to old database
				$mysqli = new mysqli("$hostname", "$username", "$password", "$database");
				if ($mysqli->connect_errno) {
					$status =  "Failed to connect to MySQL: " . $mysqli->connect_error;
					$ret = array('status' => $status);
				} else { 
					$status = 'true';

			//fetch users
					$mysql['users'] = $mysqli->query("SELECT * FROM `users` ORDER BY `users`.`id` ASC");
					if ($mysql['users']) {
						while ($row = $mysql['users']->fetch_array(MYSQLI_ASSOC)) {
							$users[] = $row;
						}
					} else {$status = '<br>Table \'users\' not found!';}

			//fetch servers
					$mysql['servers'] = $mysqli->query("SELECT * FROM `servers` ORDER BY `servers`.`id` ASC");
					if ($mysql['servers']) {
						while ($row = $mysql['servers']->fetch_array(MYSQLI_ASSOC)) {
							$servers[] = $row;
						}
					} else {$status .= '<br>Table \'servers\' not found!';}
			//fetch roles
					$mysql['roles'] = $mysqli->query("SELECT * FROM `roles` ORDER BY `roles`.`id` ASC");
					if ($mysql['roles']) {
						while ($row = $mysql['roles']->fetch_array(MYSQLI_ASSOC)) {
							$roles[] = $row;
						}
					} else {$status .= '<br>Table \'roles\' not found!<br>Did you choose the correct database?';}

			//parse users
					$userOutput = '';
					foreach ($users as $u) {
						$userOutput .= "<section><div class=\"b-what\">$u[username]</div></section>";
					}

					$serverOutput = '';
					foreach ($servers as $s) {
						$serverOutput .= "<section><div class=\"b-what\">$s[title]</div></section>";
					}
					if($serverOutput == '') $serverOutput == '<section><div class="b-what">No servers found!</div></section>';

					$roleOutput = '';
					foreach ($roles as $r) {
						if (!(preg_match("/Administrator/", $r['title']) ||
							preg_match("/Owner/", $r['title']) ||
							preg_match("/Moderator/", $r['title']) ||
							preg_match("/Viewer/", $r['title']))
							) {
							$roleOutput .= "<section><div class=\"b-what\">$r[title]</div></section>";
					}
					if ($roleOutput == '') {
						$roleOutput = '<section><div class="b-what">No custom roles found!</div></section>';
					}
				}

				$ret = array('status' => $status, 'users' => $userOutput, 'servers' => $serverOutput, 'roles' => $roleOutput);


			}
			echo json_encode($ret);
		}
	}

	function step2() {
		$this->loadModel('Configurator');
		if ($this->request->is('post')) { 
			$this->disableCache();
			Configure::write('debug', 0);
			$this->autoRender = false;  

			$datasource = "Database/Mysql";
			$hostname   = $this->request->data["hostname"];
			$username   = $this->request->data["username"]; 
			$password   = $this->request->data["password"]; 
			$database   = $this->request->data["database"]; 

			$link = mysql_connect("$hostname", "$username", "$password");
			if (!$link) {
				$result = mysql_error();
			}
			if ($database) {
				$dbcheck = mysql_select_db("$database");
				if (!$dbcheck) {
					$result .= "<br />".mysql_error();
				} else {
					//the settings are correct. Set the DB variables and install the database
					$this->Configurator->saveDb($datasource, $hostname, $username, $password, $database);
					$db = new mysqli("$hostname", "$username", "$password", "$database");

					//now run the sql file
					function executeSQLScript($db, $fileName) {
						$statements = file_get_contents($fileName);
						$statements = explode(';', $statements);

						foreach ($statements as $statement) {
							if (trim($statement) != '') {
								$db->query($statement);
							}
						}
					}

					$test = executeSQLScript($db, WWW_ROOT.'app.sql');
					echo "true";
				}
			}

			if (isset($result)) echo $result;

		} else if ($this->request->is('ajax')) {
			$this->disableCache();
			Configure::write('debug', 0);
			$this->autoRender = false;  
			$this->Configurator->saveDb("Database/Sqlite", "", "", "", '../spacebukkit.sqlite');

			echo "true";
		}
		$this->layout = 'install';  
	}    

	function step3() {

		if ($this->request->is('post')) {

			$this->disableCache();
			Configure::write('debug', 0);
			$this->autoRender = false;   

			$data = $this->request->data;
			$data['id'] = 1;

			$this->loadModel('User');

			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));

				echo 'true';

			} else {
				echo 'The user could not be saved. Please, try again.';
			}
		}

		$this->layout = 'install';
		
		require(APP. 'webroot/configuration.php');

		$this->set('language', $languages);

	}

	function step4() {

		if ($this->request->is('post')) {

			$this->disableCache();
			Configure::write('debug', 3);
			$this->autoRender = false;   

			$data = $this->request->data;
			if (preg_match("/localhost/", $data['address']) || preg_match("/127.0.0.1/", $data['address']) || preg_match("/::1/", $data['address'])) {
				$data['external_address'] = file_get_contents("http://icanhazip.com/");
			} else {
				$data['external_address'] = $data['address'];
			}

			$add = array('title' => $data['name'], 'address' => $data['address'], 'password' => $data['salt'], 'port1' => $data['port1'], 'port2' => $data['port2'], 'external_address' => $data['external_address']);

			$server   = $data['address'];
			$salt     = $data['salt'];
			$p1       = $data['port1'];
			$p2       = $data['port2'];

		  //call API

		  include APP.'SpaceBukkitAPI.php';          // This line is used to include the ressources file.
		  $api = new SpaceBukkitAPI($server, $p1, $p2, $salt);

		  
		  //CHECK IF SERVER IS RUNNING

		  $args = array();   
		  $running = $api->call("isServerRunning", $args, true);

		  $this->set('running', $running);

		  if (is_null($running)) 
		  {

		  	$answer = 'Server was not reached. Is the address correct, are the ports open?';

		  } 
		  elseif ($running == "true" || $running == true || $running == 1 ) 
		  {

		  	$this->loadModel('Server');

		  	if ($this->Server->save($add)) 
		  	{
		  		$answer = 'true';
		  	} 
		  	else 
		  	{
		  		$answer = 'The server could not be saved, please try again.';
		  	}

		  } 
		  elseif ($running == "salt") 
		  {

		  	$answer = 'Incorrect Salt supplied. If you changed it in the config, make sure you restarted Remote Toolkit with ".stopwrapper" and "sh rtoolkit.sh".';

		  }

		  echo $answer;

		}

		$this->layout = 'install';

		$this->loadModel('Role'); 

		$this->set('roles', $this->Role->find("all"));      

	}

	function step5($next = false) {
		if ($next) {
			$file = new File(TMP.'inst.txt');
			$file->delete();  
            $this->loadModel('Configurator');
            $this->Configurator->saveCore();

			$this->redirect(array('controller' => 'users', 'action' => 'logout'));
		}


		$this->layout = 'install';

	}    
}
