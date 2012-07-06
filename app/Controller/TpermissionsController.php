<?php

class TPermissionsController extends AppController {

    public $helpers = array ('Html','Form');

    public $name = 'TPermissionsController';

    public function beforeFilter()

      {
        parent::beforeFilter();

        //check if user has rights to do this
        $user_perm = $this->Session->read("user_perm");
        $glob_perm = $this->Session->read("glob_perm");

        if (!($user_perm['pages'] & $glob_perm['pages']['permissions'])) { 

           exit("access denied");

        } 

      }

    function index() {  
        
        /*

        *   Connection Check - Is the server running? Redirect accordingly.

        */

        if (!isset($api)){
              require APP . 'spacebukkitcall.php';  
            }
        
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
        
        $this->layout = 'sbv1';  

        $this->set('title_for_layout', 'Permissions');

        }
    }

    function getGroups() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            //this is static for now
            $worlds = array(
                'Global' => array('Guest', 'Member', 'Builder', 'Moderator', 'Donator', 'Admin', 'Owner'), 
                'world' => array('Guest', 'Member'),
                'world-nether' => array('Builder', 'Moderator'), 
                'world-the-end' => array('Member', 'Donator')
            );
            $json = array('aaData' => array());

            foreach ($worlds as $w => $groups) {
                foreach ($groups as $g) {
                    $buttons = '<a href="./tpermissions/edit_group/'.$g.'" class="button icon edit fancy">Edit</a><a href="./tpermissions/delete_group/'.$g.'" class="button icon remove danger">Delete!</a>';
                    $json['aaData'][] = array($w, $g, $buttons);
                }
            }

            echo json_encode($json);
        }
    }

    function getPlugins() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            //this is static for now
            $plugins = array('All', 'Essentials', 'SetRankPEX');

            $json = array('aaData' => array());

            foreach ($plugins as $p) {
                $json['aaData'][] = array($p);
            }

            echo json_encode($json);
        }
    }

    function getPluginPerms($plugin, $api) {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            $perms = array();

            if (!isset($api)) {require APP.'spacebukkitcall.php';}

            /*$args = array('Multiverse-Core');
            $plugin = $api->call('getPluginInformations', $args, false);

            foreach ($plugin['Permissions'] as $perm){
                $p = $perm['Name'];
                $d = $perm['Description'];

                $perms[$p] = $d;

            }*/

            $perms = array('srpex.reload' => 'Reloads SRPEX', 'srpex.setrank.group' => 'set\'s rank for group');
            
            return $perms;
        }
    }

    function getGroupPerms($world, $group, $api) {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            $perms = array();

            if (!isset($api)) {require APP.'spacebukkitcall.php';}

            $groupInfo = array('srpex.reload' => true, 'srpex.setrank.group' => false);
            
            return $groupInfo;
        }
    }

    function getGaPPerms($world, $group, $plugin) {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            require APP.'spacebukkitcall.php';


            $Pperms = $this->getPluginPerms($plugin, $api);

            $Gperms = $this->getGroupPerms($world, $group, $api);

            foreach($Pperms as $perm => $expl){
                if (array_key_exists($perm, $Gperms)) {
                    if($Gperms[$perm]) {$state = 'yes';}
                    elseif(!$Gperms[$perm]) {$state = 'no';}
                    
                }
                else {$state = 'none';}
                ECHO <<<END
                <span class="tristate tip" id="$perm" value="$state"></span> $perm<div class="tooltip">$expl</div>

                <br>
END;
            }
            echo '<br><input style="height: 20px; font-size: 15px;" id="newperm" placeholder="Enter new permission" name="newperm" type="text">';
        }

    }

    function saveGaPPerm($world, $group, $perm, $state) {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;
            
            echo 'true';

        }
    }

    function addGroup() {
        $this->layout = 'popup';

    }

}