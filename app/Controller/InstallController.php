<?php
class InstallController extends AppController{
    
    function beforeFilter() {
        $this->Auth->allow('*');
        parent::beforeFilter();  
               
    }

    function index() {
       $install = new File(TMP."inst.txt");
  if (!$install->exists()) exit("You are not allowed to be here!");
      $this->layout = 'login';
     
    }

    function step1() {

    	$failed = "Some tests failed. Please correct the issues to advance.";

       $install = new File(TMP."inst.txt");
  if (!$install->exists()) exit("You are not allowed to be here!");

      $this->layout = 'login';
   
      //set results
      $this->set('result', '<p>'.__('All tests successful! You may proceed to the next step.').'</p>');
      $this->set('result_bool', 1);

      //check PHP version

      if (strnatcmp(phpversion(),'5.2.6') >= 0)
      {

        $sting = '<span class="success"><b>PHP: </b>'.phpversion().' > 5.2.6 &check;';
        $this->set('php_version', $sting);

      }
      else
      {
        $sting = '<span class="failed">'.phpversion().' < 5.2.6'.__('Please update your PHP to at least 5.2.6.').'</p>';
        $this->set('php_version', $sting);

      $this->set('result', '<span class="failed">'.$failed.'</p>');
      $this->set('result_bool', 0);
      }

      //check TMP folder

      if (is_writable(TMP))
      {

        $sting = '<span class="success"><b>app/tmp</b> folder is writable &check;';
        $this->set('tmp_folder', $sting);

      }
      else
      {

        $sting = '<span class="failed">Please CHMOD <b>app/tmp</b> so that it is writable';
        $this->set('tmp_folder', $sting);
        $this->set('result', '<span class="failed">'.__('You didn\'t pass all tests. Please go fix all issues to continue'));
        $this->set('result_bool', 0);

      }

      //check Webroot folder

      if (is_writable(APP . 'webroot'))
      {

        $sting = '<span class="success"><b>app/webroot</b> folder is writable &check;</span>';
        $this->set('webroot_folder', $sting);

      }
      else
      {

        $sting = '<span class="failed">"app/webroot" folder is not writable</span>';
        $this->set('webroot_folder', $sting);

      $this->set('result', '<span class="failed">'.$failed.'</p>');
      $this->set('result_bool', 0);
      }

      //check configuration writability

      $conf = new File(APP."configuration.php");

      if ($conf->writable())
      {

        $sting = '<span class="success"><b>app/configuration.php</b> is writable &check;</span>';
        $this->set('configuration', $sting);

      }
      else
      {

        $sting = '<span class="failed">app/configuration.php '.('is not writable').'</span>';
        $this->set('configuration', $sting);

      $this->set('result', '<span class="failed">'.__('You didn\'t pass all tests. Please go fix all issues to continue').'</span>');
      $this->set('result_bool', 0);
      }

      //check db writability

      $dbd = new File(APP."Config/database.php");
	
      if ($dbd->writable())
      {

        $sting = '<span class="success"><b>app/Config/database.php</b> is writable &check;</span>';
        $this->set('database', $sting);

      }
      else
      {

        $sting = '<span class="failed">app/Config/database.php '.__('is not writable').'</span>';
        $this->set('database', $sting);

      $this->set('result', '<span class="failed">'.__('You didn\'t pass all tests. Please go fix all issues to continue').'</span>');
      $this->set('result_bool', 0);
      }

      //check php_fopen 


      if(ini_get('allow_url_fopen')) 
      {

        $sting = '<span class="success">'.__('<b>allow_url_fopen</b> is enabled').' &check;</span>';
        $this->set('php_fopen', $sting);

      }
      else
      {

        $sting = '<span class="failed">'.__('allow_url_fopen is disabled').'</span>';
        $this->set('php_fopen', $sting);

      $this->set('result', '<span class="failed">'.__('You didn\'t pass all tests. Please go fix all issues to continue').'</span>');
      $this->set('result_bool', 0);
      }

      //check curl

    if  (in_array  ('curl', get_loaded_extensions())) 
      {

        $sting = '<span class="success">'.__('<b>CURL</b> is enabled. Make sure ports 2011 and 2012 are open').' &check;</span>';
        $this->set('php_curl', $sting);

      }
      else
      {

        $sting = '<span class="failed">'.__('CURL is not enabled').'</span>';
        $this->set('php_curl', $sting);

      $this->set('result', '<span class="failed">'.__('You didn\'t pass all tests. Please go fix all issues to continue').'</span>');
      $this->set('result_bool', 0);
      }

    }


    public function step2() {
      
       $install = new File(TMP."inst.txt");
  if (!$install->exists()) exit("You are not allowed to be here!");

      require APP.'configuration.php';
      $this->layout = 'login';

      //if POST request, test database, add if OK, redirect accordingly


    if ($this->request->is('post')) { 

        $hostname = $this->request->data["host"];
        $username = $this->request->data["login"]; 
        $password = $this->request->data["password"]; 
        $database = $this->request->data["database"]; 

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

            $config = APP.'Config/database.php'; 
               
            //read the entire string

                $old = array();

                $old['username'] = "%login%";
                $old['password'] = "%password%";
                $old['database'] = "%database%";
                $old['host'] =  "%host%";

                $new = array();

                $new['username'] = $this->request->data['login'];
                $new['password'] = $this->request->data['password'];
                $new['database'] = $this->request->data['database'];
                $new['host'] = $this->request->data['host'];

                $str=implode(file($config));

                $fp=fopen($config,'w');
                
            $str=str_replace($old,$new,$str);

                //now, TOTALLY rewrite the file

            fwrite($fp,$str,strlen($str));

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

            $this->redirect(array('controller' => 'install', 'action' => 'step3'));
          }
        } 
        $this->set("result", $result);
      }
     
    }

    function step3() {

       $install = new File(TMP."inst.txt");
  if (!$install->exists()) exit("You are not allowed to be here!");

      $this->layout = 'login';

      $this->loadModel('Role'); 

      $this->set('roles', $this->Role->find("all"));

      //if POST request, test the server, add if OK, redirect accordingly
      if ($this->request->is('post')) { 

      $data = $this->request->data;

      $server = $data['address'];
      $salt = $data['password'];
      $p1 = $data['port1'];
      $p2 = $data['port2'];

      //call API

      include APP.'SpaceBukkitAPI.php';          // This line is used to include the ressources file.
      $api = new SpaceBukkitAPI($server, $p1, $p2, $salt);

      
      //CHECK IF SERVER IS RUNNING

      $args = array();   
      $running = $api->call("isServerRunning", $args, true);
    
      $this->set('running', $running);

          //IF "FALSE", IT'S STOPPED. IF "NULL" THERE WAS A CONNECTION ERROR

      if (is_null($running)) {

          $this->set("result", __("The server was not reached. Please double check your data."));
                       
          } 

        elseif ($running) {

          //save data
          $this->loadModel("Server");
            $this->Server->create();
            if ($this->Server->save($this->request->data)) {
                $this->Session->setFlash(__('The server has been saved!'));

                //delete install file

                unlink(TMP."inst.txt");

                $this->redirect(array('controller' => 'install', 'action' => 'step4'));
            } else {
                $this->Session->setFlash(__('The server could not be saved; please try again.'));
            }
        
        }    

      }

    }

    function step4() {

      $this->layout = 'login';

      //delete install file
     
    }   
  
}
