<?php
class InstallController extends AppController{
    
    function beforeFilter() {
        $this->Auth->allow('*');
        parent::beforeFilter();  
        $install = new File(TMP."inst.txt");

        if (!$install->exists()) exit("You are not allowed to be here!");
        
    }

    function index() {


      $this->layout = 'install';

      /* Check environment */
     
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
                    App::uses('ConnectionManager', 'Model');
      
                    $db = ConnectionManager::getDataSource('default');
                    $test = executeSQLScript($db, WWW_ROOT.'app.sql');

                    echo "true";
                }
            }
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
            $data['external_address'] = file_get_contents("http://automation.whatismyip.com/n09230945.asp");
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

          if (is_null($running)) {

            $answer = 'Server was not reached. Is the address correct, are the ports open?';

          } elseif ($running == "true") {
            $this->loadModel('Server');
            if ($this->Server->save($add)) {
                $answer = 'true';
            } else {
                $answer = 'The server could not be saved, please try again.';
            }

            

          } elseif ($running == "salt") {

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
        $this->redirect(array('controller' => 'users', 'action' => 'logout'));
      }
      

      $this->layout = 'install';
     
    }    
}
