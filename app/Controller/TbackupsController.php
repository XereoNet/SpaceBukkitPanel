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

        if (is_null($running)) {

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
            $groups = array('Guest', 'Member', 'Builder', 'Moderator', 'Donator', 'Admin', 'Owner');

            $i = 1;
            $num = count($groups);

            echo '{ "aaData": [';

            foreach ($groups as $group) {
                $edit = './tpermissions/edit_group/';
                $delete = './tpermissions/delete_group/';

                $buttons = '<a href=\"'.$edit.$group.'\" class=\"button icon edit fancy\" style=\"float: right\">Edit</a><form style=\"position: relative; display: inline;\" name=\"submitForm\" method=\"POST\" action=\"'.$delete.$group.'\"><input type=\"hidden\" name=\"id\" value=\"'.$group.'\"><input type=\"submit\" value=\"Delete\" class=\"button danger\" style=\"float: right\"></form>';

            ECHO <<<END
            [
              "<span>$group</span>$buttons"
            ]
        
END;

            if($i < $num) {
                echo ",";
            }
                $i++;

            }
            echo '] }';
        }
    }

    function getPlugins() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            //this is static for now
            $plugins = array('All', 'Essentials', 'SetRankPEX');

            $i = 1;
            $num = count($plugins);

            echo '{ "aaData": [';

            foreach ($plugins as $plugin) {

            ECHO <<<END
            [
              "<span>$plugin</span>"
            ]
        
END;

            if($i < $num) {
                echo ",";
            }
                $i++;

            }
            echo '] }';
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

    function getGroupPerms($group, $api) {
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

    function getGaPPerms($group, $plugin) {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            //Configure::write('debug', 0);
            $this->autoRender = false;

            require APP.'spacebukkitcall.php';


            $Pperms = $this->getPluginPerms($plugin, $api);

            $Gperms = $this->getGroupPerms($group, $api);

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

            
        }

    }

    function saveGaPPerm($group, $perm, $state) {
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