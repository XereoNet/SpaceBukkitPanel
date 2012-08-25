<?php

/**
*
*   ####################################################
*   tplayerscontroller.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is relative to the "User" page and all it's related functions.
*
*   TABLE OF CONTENTS
*   
*   1)  index
*   2)  getPlayers
*   3)  shouldIGetPlayers
*   4)  getWhitelist
*   5)  getBlacklist
*   6)  kill
*   7)  heal
*   8)  feed
*   9)  kick
*   10) ban
*   11) blacklist_add
*   12) blacklist_del
*   13) whitelist_add
*   14) whitelist_del
*   15) op
*   16) deop
*   17) inventory
*   
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class TPlayerscontroller extends AppController {

    public $helpers = array ('Html','Form');

    public $uses = array('Configurator');

    public $name = 'TPlayersController';

    public function beforeFilter()

      {
        parent::beforeFilter();

        //check if user has rights to do this
        $user_perm = $this->Session->read("user_perm");
        $glob_perm = $this->Session->read("glob_perm");

        if (!($user_perm['pages'] & $glob_perm['pages']['users'])) { 

           exit("access denied");

        } 

      }

    function index() {  
        
        /*

        *   Connection Check - Is the server running? Redirect accordingly.

        */

        include APP.'spacebukkitcall.php';
        
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

        $this->set('title_for_layout', 'Players');

        }
    }

    function getPlayers() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        //Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        //Get Players           
        $args = array();   
        $players = $api->call("getPlayers", $args, false);
        $ops = $api->call("getOps", $args, false);
        $playerslist = array();
        foreach ($players as $player) {
            
            $args = array($player);   
            $playerslist[] = $api->call("getPlayerInformations", $args, false);

        };

        //Function to get percentage  
        function percent($num_amount, $num_total) {
        $count1 = @($num_amount / $num_total);
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        return $count;
        }

        //Output
        $args = array();   
        $server = $api->call("getServer", $args, false);

        $num = count($playerslist);

        if ($server['OnlinePlayers'] == 0) 
        { 
            $noPl = __('There are no players online!');
            ECHO <<<END
{ "aaData": [
[
"",
"",
"",
"$noPl",
"",
""
]
] }
END;
    }
        else {
            $i = 1;
            echo '{ "aaData": [';  
                         
            foreach ($playerslist as $p) {

            $name = $p['Name'];
            $ip = $p['IP'];

            $life = percent($p['Health'], '20');
            $hunger = percent($p['FoodLevel'], '20');
            $lvl = $p['Level'];
            $gamemode = $p['GameMode'];
            if($p['GameMode'] == 'SURVIVAL') {

                $gamemode = __('Survival');
                $gamemode .= perm_action('users', 'changeGamemode', $this->Session->read("user_perm"), '<span class=\'button-group\'><a href=\'./tplayers/gameMode/'.$name.'/1\'  class=\'button icon arrowup ajax_table1\'>'.__('Set to creative').'</a></span>');


            } elseif($p['GameMode'] == 'CREATIVE') {
                $gamemode = __('Creative');
                $gamemode .= perm_action('users', 'changeGamemode', $this->Session->read("user_perm"), '<span class=\'button-group\'><a href=\'./tplayers/gameMode/'.$name.'/0\'  class=\'button icon arrowdown ajax_table1\'>'.__('Set to survival').'</a></span>');


            }
            $exp = $p['TotalExperience'];
            if (in_array($name, $ops)) {
                $op = __('Yes');                 
                $op .=  perm_action('users', 'op', $this->Session->read("user_perm"), '  <span class=\'button-group\'><a href=\'./tplayers/deop/'.$name.'\'  class=\'button icon arrowdown ajax_table1\'>'.__('Deop').'</a>');            
            } else {
                $op = __('No');                 
                $op .=  perm_action('users', 'op', $this->Session->read("user_perm"), '  <span class=\'button-group\'><a href=\'./tplayers/op/'.$name.'\'  class=\'button icon arrowup ajax_table1\'>'.__('Op').'</a>');            
            }
            $lifeText = '<div id=\'progress1\' class=\'sprogress green\'><span style=\'width: '.$life.'%\'><b> '.__('Health').' </b> </span></div><div id=\'progress1\' class=\'sprogress red\'><span style=\'width: '.$hunger.'%\'> <b> '.__('Food').' </b> </span></div> '.__('Lvl').': '.$lvl.' // '.__('Exp').': '.$exp.' <br />';           

            $action1 = perm_action('users', 'healAndFeed', $this->Session->read("user_perm"), '<a href=\'./tplayers/heal/'.$name.'\'  class=\'button icon like ajax_table1\'>'.__('Heal').'</a><a href=\'./tplayers/feed/'.$name.'\'  class=\'button icon like ajax_table1\'>'.__('Feed').'</a>');
            $action2 = perm_action('users', 'seeInventory', $this->Session->read("user_perm"), '<a href=\'./tplayers/inventory/'.$name.'\' class=\'button fancy icon user\'>'.__('Inventory').'</a>');
            $action3 = perm_action('users', 'kill', $this->Session->read("user_perm"), '<a href=\'./tplayers/kill/'.$name.'\' class=\'button icon remove danger ajax_table1\'>'.__('Kill').'</a>');
            $action4 = perm_action('users', 'kick', $this->Session->read("user_perm"), '<a href=\'./tplayers/kick/'.$name.'\' class=\'button icon remove danger ajax_table1\'>'.__('Kick').'</a>');
            $action5 = perm_action('users', 'ban', $this->Session->read("user_perm"), '<a href=\'./tplayers/ban/'.$name.'\' class=\'button icon remove danger ajax_table3\'>'.__('Ban').'</a>');
            $action6 = perm_action('users', 'ban', $this->Session->read("user_perm"), '<a href=\'./tplayers/ipban/'.$name.'/'.$ip.'\' class=\'button icon remove danger ajax_table4\'>'.__('IPBan').'</a>');

            $actionText = '<span class=\'button-group\'>'.$action1.$action2.'</span> <span class=\'button-group\'>'.$action3.$action4.$action5.$action6.'</span>';
            ECHO <<<END
                [
                  "<img src=\"./global/avatar/$name/40\" class=\"avatar\" />",
                  "$lifeText",
                  "$name ($ip)",
                  "$gamemode",
                  "$op",
                  "$actionText"

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
    }


   function shouldIgetPlayers() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        //Get if someone has joined in the last 10 seconds           
        $args = array(10);   
        $hasjoined = $api->call("wasThereAConnection", $args, false);
        echo $hasjoined;

        }
    }

    function gameMode($plr, $mode) {

        perm('users', 'changeGamemode', $this->Session->read("user_perm"), true);
                
        if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';
        
        $args = array($plr, $mode);   
        $chmode = $api->call("setGameMode", $args, false);
        if($mode == 0){
            $mode = __('Survival');
        }else if($mode == 1){
            $mode = __('Creative');
        }
        echo $plr.__('was set to ').$mode."!";

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('set').' '.$plr.' '.__('to').' '.$mode); 
        }
            
    }

    function getWhitelist() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        //Get Players           
        $args = array();   
        $whitelist = $api->call("getWhitelist", $args, false);

        //Output

        $num = count($whitelist);
        if (!isset($whitelist)) { echo '';}
        else {
            $i = 1;
            echo '{ "aaData": [';  
                         
            foreach ($whitelist as $w) {               

                $action = perm_action('users', 'whitelist', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tplayers/whitelist_del/'.$w.'\"  class=\"button icon danger arrowdown ajax_table2\">'.__('Remove').'</a>');

            ECHO <<<END
                [
                  "<img src=\"./global/avatar/$w/40\" class=\"avatar\" />",
                  "$w",
                  "$action"
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
    }

    function getBlacklist() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        //Get Players           
        $args = array();   
        $blacklist = $api->call("getBanned", $args, false);

        //Output
        $num = count($blacklist);
        if (!isset($blacklist)) { echo '';}
        else {
            $i = 1;
            echo '{ "aaData": [';  
                         
            foreach ($blacklist as $b) {

                $action = perm_action('users', 'ban', $this->Session->read("user_perm"), '<span class=\"button-group\"><a href=\"./tplayers/blacklist_del/'.$b.'\"  class=\"button icon danger arrowdown ajax_table3\">'.__('Remove').'</a>');

            ECHO <<<END
                [
                  "<img src=\"./global/avatar/$b/40\" class=\"avatar\" />",
                  "$b",
                  "$action"
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
    }

    function getBannedIps() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 2);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        //Get IP bans
        $ips = array();
        $bip = $api->call('getBannedIPs', array(), false);
        if (!is_null($bip)) {
            foreach ($bip as $ip) {
                $ips[] = array($ip, perm_action('users', 'ban', $this->Session->read("user_perm"), '<span class=\"button-group"><a href="./tplayers/ipban_del/'.$ip.'"  class="button icon danger arrowdown ajax_table4">'.__('Remove').'</a>'));
            }
        } else {
            $ips = array(array('No Banned IP\'s found!', ''));
        }
        echo json_encode(array('aaData' => $ips));

        }
    }

    function kill($player) {      

    perm('users', 'kill', $this->Session->read("user_perm"), true);

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';
        
        $args = array($player);   
        $kill = $api->call("killPlayer", $args, false);

        $mex = $this->Configurator->returnVars(11);

        $mex = htmlspecialchars_decode(str_replace("{player}", $player, $mex['val']), ENT_QUOTES);

        $args = array($this->Session->read("Sbvars.10"), $mex);   
        $api->call("broadcastWithName", $args, false); 
         
        echo $mex;

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('killed').' '.$player);

        } 
    }


    function heal($player) {     

    perm('users', 'healAndFeed', $this->Session->read("user_perm"), true);

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';
        

        $args = array($player, '20');   
        $sethealth = $api->call("setHealth", $args, false);

        $mex = $this->Configurator->returnVars(12);

        $mex = htmlspecialchars_decode(str_replace("{player}", $player, $mex['val']), ENT_QUOTES);

        $args = array($this->Session->read("Sbvars.10"), $mex);   
        $api->call("broadcastWithName", $args, false); 
         
        echo $mex;

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('healed').' '.$player);
        
        }    
    }


    function feed($player) {    

    perm('users', 'healAndFeed', $this->Session->read("user_perm"), true);

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $args = array($player, '20');   
        $sethealth = $api->call("setFoodLevel", $args, false);

        $mex = $this->Configurator->returnVars(13);

        $mex = htmlspecialchars_decode(str_replace("{player}", $player, $mex['val']), ENT_QUOTES);

        $args = array($this->Session->read("Sbvars.10"), $mex);   
        $api->call("broadcastWithName", $args, false); 
         
        echo $mex;

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('fed').' '.$player);
        
        }    
    }

    function kick($player) {      

    perm('users', 'kick', $this->Session->read("user_perm"), true);

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';
        
        $args = array($player, 'Kicked by Admin');   
        $sethealth = $api->call("kickPlayer", $args, false);

        $mex = $this->Configurator->returnVars(14);

        $mex = htmlspecialchars_decode(str_replace("{player}", $player, $mex['val']), ENT_QUOTES);

        $args = array($this->Session->read("Sbvars.10"), $mex);   
        $api->call("broadcastWithName", $args, false); 
         
        echo $mex;

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('kicked').' '.$player);
        
        }    
    }

    function ban($player) {      

    perm('users', 'ban', $this->Session->read("user_perm"), true);

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $args = array($player);   
        $api->call("ban", $args, false);
        $args2 = array($player, 'You have been banned from server.');   
        $api->call("kickPlayer", $args2, false);

        $mex = $this->Configurator->returnVars(15);

        $mex = htmlspecialchars_decode(str_replace("{player}", $player, $mex['val']), ENT_QUOTES);

        $args = array($this->Session->read("Sbvars.10"), $mex);   
        $api->call("broadcastWithName", $args, false); 
         
        echo $mex;

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('banned').' '.$player);
        
        }    
    }

    function ipban($player, $ip) {      

    perm('users', 'ban', $this->Session->read("user_perm"), true);

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $command = 'ban-ip '.$ip;

        $args = array($command);   
        $api->call("consoleCommand", $args, true);
        $args2 = array($player, 'You have been banned from server.');   
        $api->call("kickPlayer", $args2, false);

        $mex = $this->Configurator->returnVars(15);

        $mex = htmlspecialchars_decode(str_replace("{player}", $player, $mex['val']), ENT_QUOTES);

        $args = array($this->Session->read("Sbvars.10"), $mex);   
        $api->call("broadcastWithName", $args, false); 
         
        echo $mex;

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('banned').' '.$player);
        
        }    
    }
    function blacklist_add() {

    perm('users', 'ban', $this->Session->read("user_perm"), true);

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';
        $name = $this->request->data;
        $args = array($name['name']); 
        $api->call("ban", $args, false);

        echo $name['name'].__(' was banned and added to blacklist.');

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('banned').' '.$name);

        }   
    }

    function ipban_add() {

    perm('users', 'ban', $this->Session->read("user_perm"), true);

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $ip = $this->request->data;

        $command = 'ban-ip '.$ip['name'];

        $args = array($command);   
        $api->call("consoleCommand", $args, true);
        $mex = $this->Configurator->returnVars(15);

        $mex = htmlspecialchars_decode(str_replace("{player}", $ip['name'], $mex['val']), ENT_QUOTES);

        $args = array($this->Session->read("Sbvars.10"), $mex);   
        $api->call("broadcastWithName", $args, false); 
         
        echo $mex;

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('banned').' '.$ip['name']);

        }    
    }

    function blacklist_del($name) {

    perm('users', 'ban', $this->Session->read("user_perm"), true);

         if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $args = array($name); 

        $api->call("unban", $args, false);

        echo $name.__(' was removed from blacklist.');

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('unbanned').' '.$name);

        }    
    }

    function ipban_del($ip) {

    perm('users', 'ban', $this->Session->read("user_perm"), true);

         if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $args = array('pardon-ip '.$ip); 

        $api->call("consoleCommand", $args, true);

        echo $ip.__(' was removed from blacklist.');

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('unbanned').' '.$ip);

        }    
    }

    function whitelist_add() {

    perm('users', 'whitelist', $this->Session->read("user_perm"), true);

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;


        include APP.'spacebukkitcall.php';
        $name = $this->request->data;
        $args = array($name['name']); 
        $api->call("addToWhitelist", $args, false);

        echo $name['name'].__(' was added to whitelist.');

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('added').' '.$name['name'].__('to the whitelist'));

        }
    }

    function whitelist_del($name) {

    perm('users', 'whitelist', $this->Session->read("user_perm"), true);

        if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $args = array($name); 

        $api->call("removeFromWhitelist", $args, false);

        echo $name.__(' was removed from whitelist.');

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('removed').' '.$name.' '.__('from the whitelist'));

        }    
    }

    function op($name) {

    perm('users', 'op', $this->Session->read("user_perm"), true);

        if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $args = array($name); 

        $api->call("opPlayer", $args, false);

        echo $name.__(' was opped!');

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('opped').' '.$name);

        }    
    }

    function deop($name) {

    perm('users', 'op', $this->Session->read("user_perm"), true);

        if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        include APP.'spacebukkitcall.php';

        $args = array($name); 

        $api->call("deopPlayer", $args, false);

        echo $name.__(' was deopped!');

        w_serverlog($this->Session->read("current_server"), __('[USERS] ').$this->Auth->user('username').' '.__('deopped').' '.$name);

        }    
    }

    function inventory($name) {

       if ($this->request->is('ajax')) {
            $this->disableCache();

            perm('users', 'seeInventory', $this->Session->read("user_perm"), true);

            include APP.'spacebukkitcall.php';

            $args = array($name); 
            $items = $api->call("getInventory", $args, false);

            $dir = new Folder(WWW_ROOT . 'inventory/icons/');
            $allitems = $dir->find('.+\.png'); 

            foreach ($allitems as $slot => $item) {
                $allitems[$slot] = substr($item, 0, -4);
            }
            
            foreach ($items as $slot => $item) {
                if(isset($item['id'])) {
                    $items[$slot]['comb'] = $items[$slot]['id'].'-'.$items[$slot]['data'];
                    if ($item['amount'] == 0) $items[$slot]['amount'] = '';     
                    if (!in_array($items[$slot]['comb'] , $allitems))  $items[$slot]['comb'] = 'none';       
                } else {
                    $items[$slot]['comb'] = '0-0';
                    $items[$slot]['amount'] = '';
                }
                
            }

            $this->set('name', $name);
            $this->set('item', $items);

            $this->layout = 'popup';
        }
    }

    function inventory_delete($name, $slot) {
    perm('users', 'seeInventory', $this->Session->read("user_perm"), true);

       if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            include APP.'spacebukkitcall.php';

            $args = array($name, $slot); 
            $items = $api->call("clearInventorySlot", $args, false);

        }

    }

}