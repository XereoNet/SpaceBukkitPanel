<?php

class TBackupsController extends AppController {

    public $helpers = array ('Html','Form');

    public $name = 'TBackupsController';

    public function beforeFilter()

      {
        parent::beforeFilter();

        //check if user has rights to do this

      }

    function index() {  

        if (!isset($api)){
            require APP . 'spacebukkitcall.php';  
        }

        $args = array();
        $allWorlds = $api->call('getAllWorlds', $args, true);
        $backupWorlds = '';
        foreach ($allWorlds as $Wname) {
            $backupWorlds .= "<section>\n<div class=\"b-what\">".$Wname."</div>\n<div class=\"b-when\"><a class=\"button icon like backup\" href=\"./tbackups/backup/World/".$Wname."\">Backup</a></div>\n</section>\n\n";
        }
        $this->set('backupWorlds', $backupWorlds);

        $allPlugins = $api->call('getPlugins', $args, false);
        $bPlugins = '';
        $bPlugins .= "<section>\n<div> <a href=\"./tbackups/backup/Plugins\" class=\"button icon like backup\">Backup All Plugins</a></div>\n</section>";
        foreach ($allPlugins as $p) {
            $bPlugins .= "<section>\n<h3>".$p."\n</section>";
        }
        $this->set('backupPlugins', $bPlugins);
        
        $this->layout = 'sbv1';  

        $this->set('title_for_layout', 'Backups');
    }

    function sort_array($array) {
        $sorter = array();
        $new = array();
        foreach ($array as $int => $array2) {
            $sorter[$array2[3]] = $int;
        }
        ksort($sorter);
        foreach ($sorter as $key) {
            $new[] = $array[$key];
        }
        $new = array_reverse($new);
        return $new;
    }

    function test() {
        $this->disableCache();
        //Configure::write('debug', 0);
        $this->autoRender = false;

        require APP . 'spacebukkitcall.php';

        $args = array();

        $test = $api->call('getBackups', $args, true);

        debug($test);
    }

    function backup($type = 'Server', $name = '*', $restart = false) {
        if ($this->request->is('ajax') || true) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';

            if ($type == 'Server') {
                $name = '*';
            }

            elseif ($type == 'Plugins') {
                $name = 'plugins';
            }

            elseif ($type == 'World') {
                    $type = 'World-'.$name;
            }

            if ($restart) {
                $args = array('SpaceBukkit', 'Server is shutting down for backup!');
                $api->call('broadcastWithName', $args, false);
                sleep(3);
            }

            $args = array($type, $name);
            var_dump($api->call('backup', $args, true));
        }
    }

    function isRunning() {
        if ($this->request->is('ajax') || true) {
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
                echo '<div class="b-what">Backup of '.$bInfo[0].' finished '.round((240 + time() - $bInfo[2] / 1000) / 60, 0, PHP_ROUND_HALF_DOWN).' minutes ago!</div></div>';
            }else{
                echo '<div class="col left col_1_3"><img src="./img/info.png" /></div>';
                echo '<div class="col right col_2_3"><h3>No backups running!</h3>'."\n".'<div class="b-what">All your backups are completed!</div></div>';

            }
        }
    }

    function getPrevBackups($type = 'All', $amount = 3) {
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
                $backups = $this->sort_array($backups); //reverse array, newest on top
                $i = 0; //How many lines?
                $e = 0; //How many lines were written?
                foreach ($backups as $b) {
                    if ($i >= $amount) {
                        echo '';
                    } else {
                        if ($b[1] == 'Server' && ($type == 'All' || $type == 'Server')) {
                            $e++;
                            echo '<section>';
                            echo '<div class="b-what">Complete Server</div>';
                            echo '<div class="b-in">'.round($b[2] / 8388608, 2).'MB</div>';
                            echo '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[3] / 1000).'</div>';
                            echo '</section>';
                        }

                        else if ($b[1] == 'Plugins' && ($type == 'All' || $type == 'Plugins')) {
                            $e++;
                            echo '<section>';
                            echo '<div class="b-what">All Plugins</div>';
                            echo '<div class="b-in">'.round($b[2] / 8388608, 2).'MB</div>';
                            echo '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[3] / 1000).'</div>';
                            echo '</section>';
                        }

                        else if ($b[1] == 'Worlds' && ($type == 'All' || $type == 'Worlds')) {
                            $e++;
                            echo '<section>';
                            $wn = explode('-', $b[1]);
                            echo '<div class="b-what">'.$wn[0].' "'.$wn[1].'"</div>';
                            echo '<div class="b-in">'.round($b[2] / 8388608, 2).'MB</div>';
                            echo '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[3] / 1000).'</div>';
                            echo '</section>';
                        }
                    }
                    $i++;
                }
            }

            if ($e == 0) {
                echo '<section>';
                echo '<h3>No backups found!</h3>'; //Name
                echo '</section>';
            } elseif(count($backups) > $amount) {
                echo '<section>';
                if ($type == 'All') {
                    echo '<div class="b-what"><a href="#" class="button icon add" id="updatepa">More...</a></div>'; //Name
                } elseif ($type == 'Worlds') {
                    echo '<div class="b-what"><a href="#" class="button icon add" id="updatepw">More...</a></div>'; //Name
                } elseif ($type == 'Plugins') {
                    echo '<div class="b-what"><a href="#" class="button icon add" id="updatepp">More...</a></div>'; //Name
                } elseif ($type == 'Server') {
                    echo '<div class="b-what"><a href="#" class="button icon add" id="updateps">More...</a></div>'; //Name
                }
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

            echo '<section>';
            echo '<h3>No scheduled backups found!</h3>'; //Name
            echo '</section>';

        }
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

            echo '<section>';
            echo '<h3>Aantal backups: '.$bnum.'</h3>'; //Name
            echo '</section>';

            echo '<section>';
            echo '<h3>Aantal backups: '.$bnum.'</h3>'; //Name
            echo '</section>';
            
        }
    }
}