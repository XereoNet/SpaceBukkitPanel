<?php

class TBackupsController extends AppController {

    public $helpers = array ('Html','Form');

    public $name = 'TBackupsController';

    public function beforeFilter()

      {
        parent::beforeFilter();

        //check if user has rights to do this
        $user_perm = $this->Session->read("user_perm");
        $glob_perm = $this->Session->read("glob_perm");

        if (!($user_perm['pages'] & $glob_perm['pages']['backups'])) { 

           exit("access denied");

        } 

      }

    function index() {  

        if (!isset($api)){
            require APP . 'spacebukkitcall.php';  
        }

        $args = array();   
        $running = $api->call("isServerRunning", $args, true);
        
        $this->set('running', $running);

        //IF "FALSE", IT'S STOPPED. IF "NULL" THERE WAS A CONNECTION ERROR

        if (is_null($running)) {

        $this->layout = 'sbv1_notreached'; 
                     
        } else {

            $args = array();

            //Parse worldlist and add backup buttons
            $allWorlds = $api->call('getAllWorlds', $args, true);
            $backupWorlds = '';
            foreach ($allWorlds as $Wname) {
                $backupWorlds .= "<section>\n<div class=\"b-what\">".$Wname."</div>\n<div class=\"b-when\">".perm_action('backups', 'backupWorlds', $this->Session->read("user_perm"), "<a class=\"button icon like backup\" href=\"./tbackups/backup/World/".$Wname."\">Backup</a>")."</div>\n</section>\n\n";
            }
            $this->set('backupWorlds', $backupWorlds);
            //parse plugin list
            $bPlugins = '';
                $bPlugins .= perm_action('backups', 'backupPlugins', $this->Session->read("user_perm"), "<section>\n<div> <a href=\"./tbackups/backup/Plugins\" class=\"button icon like backup\">Backup All Plugins</a></div>\n</section>");
            if (!$running) {
                $bPlugins = 'Couldn\'t load plugins list (Server is turned off)';
            } else {
                $allPlugins = $api->call('getPlugins', $args, false);
                foreach ($allPlugins as $p) {
                    $bPlugins .= "<section>\n<h3>".$p."\n</section>";
                }
            }
            $this->set('backupPlugins', $bPlugins);
            
            $this->layout = 'sbv1';  

            $this->set('title_for_layout', 'Backups');
        }
    }

    function test() {
        $this->disableCache();
        $this->autoRender = false;
        $user_perm = $this->Session->read("user_perm");
        $glob_perm = $this->Session->read("glob_perm");
        debug($user_perm);
    }

    function backup($type = 'Server', $name = '*', $restart = false) {
        perm('backups', 'backup', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';

            if ($type == 'Server') {
                perm('backups', 'backupServer', $this->Session->read("user_perm"), true);
                $name = '*';
            } else if ($type == 'Plugins') {
                perm('backups', 'backupPlugins', $this->Session->read("user_perm"), true);
                $name = 'plugins';
            } else if ($type == 'World') {
                perm('backups', 'backupWorlds', $this->Session->read("user_perm"), true);
                $type = 'World-'.$name;
            }

            if ($restart) {
                $args = array('SpaceBukkit', 'Server is shutting down for backup!');
                $api->call('broadcastWithName', $args, false);
                sleep(3);
            }

            $args = array($type, $name, $restart);
            $api->call('backup', $args, true);
        }
    }

    function restore($type, $fileName) {
        perm('backups', 'restore', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';

            $args = array('SpaceBukkit', 'Server is shutting down to restore a backups!');
            $api->call('broadcastWithName', $args, false);
            sleep(3);

            $args = array($name);
            $api->call('restore', $args, true);
        }
    }

    function isRunning() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $args = array();
            $status = $api->call('isBackupRunning', $args, true);
            if($status) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    function getPB() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $args = array();
            $bInfo = $api->call('getBackupInfo', $args, true);
            echo $bInfo[3].'%';
        }
    }

    function getRunning() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';

            $args = array();

            $status = $api->call('isBackupRunning', $args, true);

            $bInfo = $api->call('getBackupInfo', $args, true);

            $messageTime = round(($bInfo[2] / 1000) + 240);

            if ($status) {
                $size = round((intval($bInfo[7]) / 1048576), 2);
                $title = '<h3>'.'Backing up '.$bInfo[0].'</h3>';
                $timeRunning = '<div class="b-what">'.$bInfo[6].$bInfo[5].'</div>';
                $startTime = '<br><div class="b-in">(Started on '.date('l, dS F Y \a\t H:i)', round($bInfo[2] / 1000)).'</div>';
                $bSize = '<div class="b-when">Currently '.$size.' MB</div>';

                echo<<<END
$title
$timeRunning
$startTime
$bSize
END;
            } else if($messageTime >= time()) {
                echo '<div class="col left col_1_3"><img src="./img/win.png" /></div>';
                echo '<div class="col right col_2_3"><h3>Backup finished!</h3>';
                echo '<div class="b-what">Backup of '.$bInfo[0].' finished '.round((time() - $bInfo[2] / 1000) / 60, 0, PHP_ROUND_HALF_DOWN).' minutes ago!</div></div>';
            }else{
                echo '<div class="col left col_1_3"><img src="./img/info.png" /></div>';
                echo '<div class="col right col_2_3"><h3>No backups running!</h3>'."\n".'<div class="b-what">All your backups are completed!</div></div>';

            }
        }
    }

    function getPrevBackups($type = 'a', $amount = 3) {

        function backup_type_count($array) {
            $types = array('w' => array(), 'p' => array(), 's' => array());
            foreach ($array as $key => $backup) {
                if (preg_match("/World-.*/", $backup[1])) {
                    $types['w'][] = $key;
                } else if ($backup[1] == 'Plugins') {
                    $types['p'][] = $key;
                } else if ($backup[1] == 'Server'){
                    $types['s'][] = $key;
                }
                $types['a'] = $array;
            }
            return $types;
        }

        function time_sort_array($array) {
            $sorter = array();
            $new = array();
            foreach ($array as $int => $array2) {
                $k = intval($array2[3] / 10000);
                while (array_key_exists($k, $sorter)) {
                    $k++;
                }
                $sorter[$k] = $int;
            }
            ksort($sorter);
            foreach ($sorter as $key) {
                $new[] = $array[$key];
            }
            $new = array_reverse($new);
            return $new;
        }

        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';
            $args = array();
            $backups = $api->call('getBackups', $args, true);
            if (empty($backups)) {
                $e = 0;
            } else {
                $e = count($backups);
                $backups = time_sort_array($backups); //reverse array, newest on top
                $types = backup_type_count($backups); //Count the backup types
                $bToWrite = array();
                if ($type == 'a') {
                    $bToWrite = $backups;
                } else if ($type == 'w') {
                    foreach ($types['w'] as $z) {
                        $bToWrite[] = $backups[$z];
                    }
                } else if ($type == 'p') {
                    foreach ($types['p'] as $z) {
                        $bToWrite[] = $backups[$z];
                    }
                } else if ($type == 's') {
                    foreach ($types['s'] as $z) {
                        $bToWrite[] = $backups[$z];
                    }
                } else {
                    echo 'Unsupported backup type!';
                }

                $i = 0;
                foreach ($bToWrite as $b) {
                    if ($i >= $amount) {
                        echo '';
                    } else {
                        if (preg_match("/[aw]/", $type) && preg_match("/World-.*/", $b[1])) {
                            echo '<section>';
                            $wn = explode('-', $b[1]);
                            echo '<div class="b-what">'.perm_action('backups', 'restore', $this->Session->read("user_perm"), '<a href="./tbackups/restore/Worlds/'.$b[0].'" class="button icon move backup">Restore</a> ').$wn[0].' "'.$wn[1].'"</div>';
                            echo '<div class="b-in">'.round($b[2] / 1048576, 2).'MB</div>';
                            echo '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[3] / 1000).'</div>';
                            echo '</section>';
                            $i++;
                        } else if (preg_match("/[ap]/", $type) && preg_match("/Plugins/", $b[1])) {
                            echo '<section>';
                            echo '<div class="b-what">'.perm_action('backups', 'restore', $this->Session->read("user_perm"), '<a href="./tbackups/restore/Plugins/'.$b[0].'" class="button icon move backup">Restore</a> ').'All Plugins</div>';
                            echo '<div class="b-in">'.round($b[2] / 1048576, 2).'MB</div>';
                            echo '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[3] / 1000).'</div>';
                            echo '</section>';
                            $i++;
                        } else if (preg_match("/[as]/", $type) && preg_match("/Server/", $b[1])) {
                            echo '<section>';
                            echo '<div class="b-what">'.perm_action('backups', 'restore', $this->Session->read("user_perm"), '<a href="./tbackups/restore/Server/'.$b[0].'" class="button icon move backup">Restore</a> ').'Complete Server</div>';
                            echo '<div class="b-in">'.round($b[2] / 1048576, 2).'MB</div>';
                            echo '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[3] / 1000).'</div>';
                            echo '</section>';
                            $i++;
                        }
                    }
                }
            }
            if ($e == 0) {
                echo '<section>';
                echo '<h3>No backups found!</h3>'; //Name
                echo '</section>';
            } else if (count($types[$type]) > $i) {
                echo '<section>';
                echo '<div class="b-what"><a href="#" class="button icon add" id="updatep'.$type.'">More...</a></div>'; //Name
                echo '<div class="b-in"></div>'; //Size
                echo '<div class="b-when"></div>'; //date
                echo '</section>';
            }
        }
    }

    function getNextBackups($type = 'All', $amount = 3) {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            require APP . 'spacebukkitcall.php';
            $args = array();
            $jobs = $api->call('getJobs', $args, true);
            $nbackups = array();
            foreach ($jobs as $name => $info) {
                if ($info[0] == 'backup') {
                    $nbackups[$name] = array('type' => $info[1][0][0], 'fold' => $info[1][0][1], 'timeType' => $info[2], 'timeArg' => $info[3]);
                }
            }
            if (empty($nbackups)) {
                echo '<section>';
                echo '<h3>No scheduled backups found!</h3>'; //Name
                echo '</section>';
            } else {
                $i = 0;
                foreach ($nbackups as $bname => $binfo) {
                    if ($i >= 3) {
                        echo '';
                    } else {
                        if (preg_match("/EVERYXHOURS/", $binfo['timeType'])) {
                            $when = 'Every '.$binfo['timeArg'].' hours';
                        } else if (preg_match("/EVERYXMINUTES/", $binfo['timeType'])) {
                            $when = 'Every '.$binfo['timeArg'].' minutes';
                        } else if (preg_match("/ONCEPERDAYAT/", $binfo['timeType'])) {
                            $when = 'Once per day at: '.$binfo['timeArg'];
                        } else if (preg_match("/XMINUTESPASTEVERYHOUR/", $binfo['timeType'])) {
                            $when = $binfo['timeArg'].' minutes past every hour';
                        }
                        echo '<section>';
                        echo '<div class="b-what">'.$bname.'</a></div>'; //Name
                        echo '<div class="b-in">contents: '.$binfo['type'].', folder: '.$binfo['fold'].'</div>'; //Size
                        echo '<div class="b-when">'.$when.'</div>'; //date
                        echo '</section>';
                        $i++;
                    }
                }
            }

            echo '<section>';
            echo '<div class="b-what"><a href="./tbackups/schedule" class="button icon add fancy" id="schedb">Schedule backup</a></div>'; //Name
            echo '<div class="b-in"></div>'; //Size
            echo '<div class="b-when"></div>'; //date
            echo '</section>';

        }
    }

    function schedule(){
        if ($this->request->is('post')) { 

            $data = $this->request->data;

            $type = $data["type"];
            $timetype = $data["timeType"];
            $id = $data["name"];
            $bname = $type;

            if ($type == 'world') {
                $bname = 'World-'.$data['sworlds'];
                $fold = $data['sworlds'];
            } else if ($type == 'server') {
                $bname = 'Server';
                $fold = '*';
            } else if ($type == 'plugins') {
                $bname = 'Plugins';
                $fold = 'plugins';
            }

            $arguments = array($bname, $fold, false);

            if (!(isset($data["timeArgs2"]))) {
                $data["timeArgs2"] = 'null';
            }

            if ($data['timeArgs2'] == "null") {

               $timeargs = $data["timeArgs1"];
                
            } else {
               
               $timeargs = $data["timeArgs1"].':'.$data['timeArgs2'];

            }


            require APP . 'spacebukkitcall.php';
            
            $args = array($data["name"], 'backup', $arguments, $timetype, $timeargs);
     
            $api->call("addJob", $args, true);
        } else {
            require APP . 'spacebukkitcall.php';
            //get world specific information
            $args = array();
            $worlds = $api->call("allWorlds", $args, true);
            $this->set('worlds', $worlds);
        }
        $this->layout = 'popup';
    }

    function getBackupStats() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';
            $args = array();
            $backups = $api->call('getBackups', $args, true);
            $bnum = count($backups);
            $bsize = 0;

            foreach ($backups as $b) {
                $bsize += round($b[2] / 1048576, 2);
            }

            echo '<section>';
            echo '<h3>Backup count: '.$bnum.'</h3>'; //Name
            echo '</section>';

            echo '<section>';
            echo '<h3>Total size: '.$bsize.'MB</h3>'; //Name
            echo '</section>';
            
        }
    }
}