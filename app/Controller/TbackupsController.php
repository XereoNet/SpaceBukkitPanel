<?php

/**
*
*   ####################################################
*   TbackupsController.php
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is relative to the "Backups" page and all it's related functions.
*
*   TABLE OF CONTENTS
*
*   1)  index
*
*   Active functions: (ajax updates)
*       2)  getRunning
*       3)  getBackups
*
*   Passive functions: (after user invocation)
*       4)  backup
*       5)  restore
*       6)  schedule
*
*
* @copyright  Copyright (c) 2012 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Jamy
* @since      File available since Release 1.2
*
*
*/

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

    function index() {      // index function

        if (!isset($api)){
            require APP . 'spacebukkitcall.php';
        }

        $args = array();
        $running = $api->call("isServerRunning", $args, true);

        $this->set('running', $running);

        if (is_null($running) || preg_match("/salt/", $running)) {

            $this->layout = 'sbv1_notreached';

        }

        elseif (!$running) {

            $this->layout = 'sbv1_notrunning_settings';

        }

        elseif ($running) {

            $args = array();

            //Parse worldlist and add backup buttons
            $allWorlds = $api->call('getAllWorlds', $args, true);
            $backupWorlds = '';
            foreach ($allWorlds as $Wname) {
                $backupWorlds .= "<section>\n<div class=\"b-what\">".$Wname."</div>\n<div class=\"b-when\">".perm_action('backups', 'backupWorlds', $this->Session->read("user_perm"), "<a class=\"button icon like backup\" href=\"./tbackups/backup/World/".$Wname."\">".__('Backup')."</a>")."</div>\n</section>\n\n";
            }
            $this->set('backupWorlds', $backupWorlds);
            //parse plugin list
            $bPlugins = '';
            $bPlugins .= perm_action('backups', 'backupPlugins', $this->Session->read("user_perm"), "<section>\n<div> <a href=\"./tbackups/backup/Plugins/plugins\" class=\"button icon like backup\">".__('Backup All Plugins')."</a></div>\n</section>");
            if (!$running) {
                $bPlugins = __("Couldn't load plugins list (Server is turned off)");
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
    }   // end of index

    // --------------------------------------------------------------------------------------------------
    // | Active functions (ajax invoked functions)                                                      |
    // --------------------------------------------------------------------------------------------------


    function getRunning() {     // ajax function to get the info for the running backup
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';

            // --------------------------------------------------------------------------------------------------
            // | Is a backup running? yes / no / done and Current info                                          |
            // --------------------------------------------------------------------------------------------------

            $args = array();
            $bInfo = $api->call('getRunningOperationInfo', $args, true);
            $data = '';

            if (!is_null($bInfo[0])) {
                $r = 'yes';
                $size = round((intval($bInfo[6]) / 1048576), 2);
                $data .= '<h3>'.__('Backing up').' '.$bInfo[0].'</h3>';
                $data .= '<div class="b-what">'.$bInfo[4].'</div>';
                $data .= '<br><div class="b-in">(Started on '.date('l, dS F Y \a\t H:i)', round($bInfo[2] / 1000)).'</div>';
                $data .= '<div class="b-when">'.__('Currently').' '.$size.' '.__('MB').'</div>';
                $pb = $bInfo[3].'%';
            } else {
                $r = 'no';
                $data .= '<div class="col left col_1_3"><img src="./img/info.png" /></div>';
                $data .= '<div class="col right col_2_3"><h3>'.__('No operations running!').'</h3>'."\n".'<div class="b-what">'.__('All your backups are completed!').'</div></div>';
                $pb = '100%';
            }

            // --------------------------------------------------------------------------------------------------
            // | Combine call result                                                                            |
            // --------------------------------------------------------------------------------------------------

            $result = array("running" => $r, "data" => $data, "pb" => $pb);
            echo json_encode($result);
        }

    }   // end of getRunning

    function getFinished() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';

            $args = array();
            $ops = $api->call('getOperations', $args, true);
            $rop = $api->call('getRunningOperation', $args, true);
            $data = '';
            array_reverse($ops);
            foreach ($ops as $op) {
                if((($op[2]/1000)+300 >= time()) && $op[0] != $rop) {
                    $data .= '<section>';
                    $data .= '<div class="col left col_1_3"><img src="./img/win.png" /></div>';
                    $data .= '<div class="col right col_2_3"><h3>'.__('Operation finished!').'</h3>';
                    $data .= '<div class="b-what">'.__('Backup of').' '.$op[1].' '.__('finished').' '.round((time() - $op[2] / 1000) / 60, 0, PHP_ROUND_HALF_DOWN).' '.__('minutes ago!').'</div></div><br><br><br><br>';
                    $data .= '</section>';
                }
            }
            echo $data;
        }
    }

    function getBackups($prevAmount = '3,3,3,3') {      // ajax function that return a json with the data for previous and scheduled backups ans well as the backup stats
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';

        // --------------------------------------------------------------------------------------------------
        // | Functions to aid in parsing previous backups!                                                  |
        // --------------------------------------------------------------------------------------------------

            function backup_type_count($array) {
                $types = array('w' => array(), 'p' => array(), 's' => array());
                foreach ($array as $key => $backup) {
                    if (preg_match("/World-.*/", $backup[1])) {
                        $types['w'][] = $key;
                    } else if ($backup[1] == 'Plugins') {
                        $types['p'][] = $key;
                    } else if ($backup[1] == 'Server') {
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

            // --------------------------------------------------------------------------------------------------
            // | Previous Backups                                                                               |
            // --------------------------------------------------------------------------------------------------

            $tyToWrite = explode(',', $prevAmount);
            $args = array();
            $backups = $api->call('getBackups', $args, true);
            if (empty($backups)) {
                $e = 0;
            } else {
                $e = count($backups);
                $backups = array_reverse($backups); //reverse array, newest on top
                $types = backup_type_count($backups); //Count the backup types

                $prevOutput = array("a" => '', "w" => '', "p" => '', "s" => '');
                $wrote = array("a" => 0, "w" => 0, "p" => 0, "s" => 0);

                $i = 0;
                foreach ($backups as $b) {
                    if (preg_match("/World-.*/", $b[1])) {
                        $text = '';
                        $text .= '<section>';
                        $wn = explode('-', $b[1]);
                        $text .= '<div class="b-what">'.perm_action('backups', 'restore', $this->Session->read("user_perm"), '<a href="./tbackups/restore/'.$b[0].'" class="button icon move restore">'.__('Restore').'</a> ').$wn[0].' "'.$wn[1].'"</div>';
                        $text .= '<div class="b-in">'.round($b[3] / 1048576, 2).__('MB').'</div>';
                        $text .= '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[2] / 1000).'</div>';
                        $text .= '</section>';

                        if ($wrote["w"] < $tyToWrite[1]) {
                            $prevOutput["w"] .= $text;
                            $wrote["w"]++;
                        }
                        if ($wrote["a"] < $tyToWrite[0]) {
                            $prevOutput["a"] .= $text;
                            $wrote["a"]++;
                        }
                    } else if (preg_match("/Plugins/", $b[1])) {
                        $text = '';
                        $text .= '<section>';
                        $text .= '<div class="b-what">'.perm_action('backups', 'restore', $this->Session->read("user_perm"), '<a href="./tbackups/restore/'.$b[0].'" class="button icon move restore">'.__('Restore').'</a> ').__('All Plugins').'</div>';
                        $text .= '<div class="b-in">'.round($b[3] / 1048576, 2).__('MB').'</div>';
                        $text .= '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[2] / 1000).'</div>';
                        $text .= '</section>';

                        if ($wrote["p"] < $tyToWrite[2]) {
                            $prevOutput["p"] .= $text;
                            $wrote["p"]++;
                        }
                        if ($wrote["a"] < $tyToWrite[0]) {
                            $prevOutput["a"] .= $text;
                            $wrote["a"]++;
                        }
                    } else if (preg_match("/Server/", $b[1])) {
                        $text = '';
                        $text .= '<section>';
                        $text .= '<div class="b-what">'.perm_action('backups', 'restore', $this->Session->read("user_perm"), '<a href="./tbackups/restore/'.$b[0].'" class="button icon move restore">'.__('Restore').'</a> ').__('Complete Server').'</div>';
                        $text .= '<div class="b-in">'.round($b[3] / 1048576, 2).'MB</div>';
                        $text .= '<div class="b-when">'.date('l, dS F Y \a\t H:i', $b[2] / 1000).'</div>';
                        $text .= '</section>';

                        if ($wrote["s"] < $tyToWrite[3]) {
                            $prevOutput["s"] .= $text;
                            $wrote["s"]++;
                        }
                        if ($wrote["a"] < $tyToWrite[0]) {
                            $prevOutput["a"] .= $text;
                            $wrote["a"]++;
                        }
                    }
                }
            }
            if ($e == 0) {
                $text = '';
                $text .= '<section>';
                $text .= '<h3>'.__('No backups found!').'</h3>'; //Name
                $text .= '</section>';
                $prevOutput["a"] = $text;
                $prevOutput["w"] = $text;
                $prevOutput["p"] = $text;
                $prevOutput["s"] = $text;
            } else {

                if (count($types["a"]) > $wrote["a"]) {
                    $prevOutput["a"] .= '<section><div class="b-what"><a href="#" class="button icon add" id="updatepa">'.__('More...').'</a></div><div class="b-in"></div><div class="b-when"></div></section>';
                }
                if (count($types["w"]) > $wrote["w"]) {
                    $prevOutput["w"] .= '<section><div class="b-what"><a href="#" class="button icon add" id="updatepw">'.__('More...').'</a></div><div class="b-in"></div><div class="b-when"></div></section>';
                } else if ($wrote["w"] == 0) {
                    $prevOutput["w"] .= '<section><h3>No world backups found!</h3></section>';
                }
                if (count($types["p"]) > $wrote["p"]) {
                    $prevOutput["p"] .= '<section><div class="b-what"><a href="#" class="button icon add" id="updatepp">'.__('More...').'</a></div><div class="b-in"></div><div class="b-when"></div></section>';
                } else if ($wrote["p"] == 0) {
                    $prevOutput["p"] .= '<section><h3>No plugin backups found!</h3></section>';
                }
                if (count($types["s"]) > $wrote["s"]) {
                    $prevOutput["s"] .= '<section><div class="b-what"><a href="#" class="button icon add" id="updateps">'.__('More...').'</a></div><div class="b-in"></div><div class="b-when"></div></section>';
                } else if ($wrote["s"] == 0) {
                    $prevOutput["s"] .= '<section><h3>No server backups found!</h3></section>';
                }
            }

            // --------------------------------------------------------------------------------------------------
            // | Scheduled Backups                                                                              |
            // --------------------------------------------------------------------------------------------------

            $args = array();
            //$jobs = $api->call('getJobs', $args, true);
            $schedOutput = '';
            $nbackups = array();
            foreach ($jobs as $name => $info) {
                if ($info[0] == 'backup') {
                    $nbackups[$name] = array('type' => $info[1][0][0], 'fold' => $info[1][0][1], 'timeType' => $info[2], 'timeArg' => $info[3]);
                }
            }
            if (empty($nbackups)) {
                $schedOutput .= '<section>';
                $schedOutput .= '<h3>'.__('No scheduled backups found!').'</h3>'; //Name
                $schedOutput .= '</section>';
            } else {
                $i = 0;
                foreach ($nbackups as $bname => $binfo) {
                    if ($i >= 3) {
                        echo '';
                    } else {
                        if (preg_match("/EVERYXHOURS/", $binfo['timeType'])) {
                            $when = __('Every').' '.$binfo['timeArg'].' '.__('hours');
                        } else if (preg_match("/EVERYXMINUTES/", $binfo['timeType'])) {
                            $when = __('Every').' '.$binfo['timeArg'].' '.__('minutes');
                        } else if (preg_match("/ONCEPERDAYAT/", $binfo['timeType'])) {
                            $when = __('Once per day at:').' '.$binfo['timeArg'];
                        } else if (preg_match("/XMINUTESPASTEVERYHOUR/", $binfo['timeType'])) {
                            $when = $binfo['timeArg'].' '.__('minutes past every hour');
                        }
                        $schedOutput .= '<section>';
                        $schedOutput .= '<div class="b-what">'.$bname.'</a></div>'; //Name
                        $schedOutput .= '<div class="b-in">'.__('contents').': '.$binfo['type'].', '.__('folder').': '.$binfo['fold'].'</div>'; //Size
                        $schedOutput .= '<div class="b-when">'.$when.'</div>'; //date
                        $schedOutput .= '</section>';
                        $i++;
                    }
                }
            }
            $schedOutput .= '<section>';
            $schedOutput .= '<div class="b-what"><a href="./tbackups/schedule" class="button icon add fancy" id="schedb">'.__('Schedule backup').'</a></div>'; //Name
            $schedOutput .= '<div class="b-in"></div>'; //Size
            $schedOutput .= '<div class="b-when"></div>'; //date
            $schedOutput .= '</section>';

            // --------------------------------------------------------------------------------------------------
            // | Backup information                                                                             |
            // --------------------------------------------------------------------------------------------------

            $args = array();
            $backupInfo = '';
            $backups = $api->call('getBackups', $args, true);
            $bnum = count($backups);
            $bsize = 0;

            foreach ($backups as $b) {
                $bsize += round($b[3] / 1048576, 2);
            }

            $backupInfo .= '<section>';
            $backupInfo .= '<h3>'.__('Backup count').': '.$bnum.'</h3>'; //Name
            $backupInfo .= '</section>';
            $backupInfo .= '<section>';
            $backupInfo .= '<h3>'.__('Total size').': '.round($bsize, 2).__('MB').'</h3>'; //Name
            $backupInfo .= '</section>';

            // --------------------------------------------------------------------------------------------------
            // | Combine call result                                                                            |
            // --------------------------------------------------------------------------------------------------

            $result = array("prev" => $prevOutput, "next" => $schedOutput, "info" => $backupInfo);
            echo json_encode($result);
        }
    } // end of getBackups


    // --------------------------------------------------------------------------------------------------
    // | Passive functions (user invoked)                                                               |
    // --------------------------------------------------------------------------------------------------

    function backup($type, $contents, $restart) {
        perm('backups', 'backup', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';
            if (preg_match("/Server/", $type)) {
                perm('backups', 'backupServer', $this->Session->read("user_perm"), true);
                $name = $type;
                $contents = '*';
            } else if (preg_match("/Plugins/", $type)) {
                perm('backups', 'backupPlugins', $this->Session->read("user_perm"), true);
                $contents = 'plugins';
                $name = $type;
            } else if (preg_match("/World/", $type)) {
                perm('backups', 'backupWorlds', $this->Session->read("user_perm"), true);
                $name = 'World-'.$contents;
            }
            if ($restart == 'true') {
                $args = array($this->Session->read("Sbvars.10"), 'Server is shutting down for backup!');
                $api->call('broadcastWithName', $args, false);
                sleep(3);
            }
            $args = array($name, $contents, $restart);
            $r = $api->call('backup', $args, true);
            if (!preg_match("/error/", $r[0])) {
                w_serverlog($this->Session->read("current_server"), __('[BACKUPS] ').$this->Auth->user('username').' '.__('made a backup of').' '.$name);
            }
        }
    }

    function restore($uid, $cleardest) {    // function to restore a certain backup
        perm('backups', 'restore', $this->Session->read("user_perm"), true);
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;
            require APP . 'spacebukkitcall.php';

            $args = array($this->Session->read("Sbvars.10"), 'Server is shutting down to restore a backup!');
            $api->call('broadcastWithName', $args, false);
            sleep(3);

            $args = array($uid, $cleardest, true);
            $api->call('restoreBackup', $args, true);
            w_serverlog($this->Session->read("current_server"), __('[WORLDS] ').$this->Auth->user('username').' '.__('restored').' '.$name);
        }
    }   // end of restore

    function schedule(){
        if ($this->request->is('post')) {

            $this->autoRender = false;

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
           var_dump($args);

           if($api->call("addJob", $args, true)) {
                echo 'yes';
            } else {
                echo 'no';
            }

       } else {
        require APP . 'spacebukkitcall.php';
            //get world specific information
        $args = array();
        $worlds = $api->call("allWorlds", $args, true);
        $this->set('worlds', $worlds);
    }
    $this->layout = 'popup';
}
}