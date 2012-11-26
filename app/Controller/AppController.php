<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 *
 * @package       Cake.Controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 *
 *
*
*   ####################################################
*   AppController.php
*   ####################################################
*
*   DESCRIPTION
*
*   This controller wraps around the entire application. It is set to execute different tasks and set different variables
*   according to specific situations.
*
*   The basic layout is:
*
*
*/

/* Class declaration and components */

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class AppController extends Controller {

	public $components = array(
	        'Session',
	        'Auth' => array(
	            'loginRedirect' => array('controller' => 'dash', 'action' => 'index'),
	            'logoutRedirect' => array('controller' => 'users', 'action' => 'login')
	        )
	    );

	function beforeFilter() {

        /* Configure Auth class */

        $this->Auth->loginError = __('This usernames/password combination was not found, did you enter the correct password?');
        $this->Auth->authError = __('This error shows up when the user tries to access a part of the website that is protected.');

        /* Check for installation */

        $install = new File(TMP."inst.txt");

        $allowed = array("Install");

        if (($install->exists()) && (!(in_array($this->name, $allowed)))) {

            $this->redirect(array('controller' => 'install', 'action' => 'index'));

            } elseif (in_array($this->name, $allowed)) {

                //do something for Installation Process

            } else  { //not installation process, continue

            /* Check for maintenance */

            $maintenance = new File(APP."webroot/.maintenance");

            $allowed = array("Users");

            /* Are we logged in? */

            if (!$this->Auth->user() && !(in_array($this->name, $allowed)) )
            {
                echo $this->name;
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }

            $allowed = array("maintenance");

            if(!is_null($this->Auth->user())) {

                    $this->set('username',  $this->Auth->user('username'));
                    $this->set('current_user_id', $this->Auth->user('id'));

                    $this->set('is_super', $this->Auth->user('is_super'));

                /* Maintenance */

                if (($maintenance->exists()) && (!(in_array($this->action, $allowed))) && ($this->Auth->user('is_super') < 1)) {

                    $this->redirect(array('controller' => 'global', 'action' => 'maintenance'));

                    } elseif (in_array($this->name, $allowed)) {


                    } else  { //not maintenance process, continue

                    /* STORE SPACEBUKKIT VARIABLES TO SESSION */

                    require APP . 'webroot/vars.php';
                    require APP . 'webroot/system.php';

                    foreach ($variables as $k => $var) {

                        $this->Session->write("Sbvars.".$k, $var['val']);

                    }

                    foreach ($system as $k => $var) {

                        $this->Session->write("Sbsys.".$k, $var['val']);

                    }

                    /* If this is not a post request, continue */

                    if (!($this->request->is('post'))) {

                      $this->loadModel('Server');

                      /* If this is not an ajax request, continue */

                      if (!($this->request->is('ajax'))) {

                        /* Setup Spacebukkit stuff like versioning and messages */

                        require APP.'webroot/configuration.php';
                        $c_sb = $sbconf['app_version'];

                        $app = $sbconf['app'];

                        $this->set('spacebukkitbuildcurrent', $c_sb);

                        if ($this->action == "index") {

                            //do we want this?

                            if($this->Session->read("Sbsys.3") == "true") {

                                //is the user authorized?

                                if (($this->Session->read("Sbvars.16") == "s" && $this->Auth->user('is_super') == 1) || $this->Session->read("Sbvars.16") == "e") {
                                    $this->loadModel('Configurator');
                                    //get LATEST SpaceBukkit version

                                    $l_sb = $this->Configurator->xml('build.xml');

                                    //Set the notifier

                                    if ($app < $l_sb["BUILD"]["APP"]) {

                                        $this->set('spacebukkitbuildready', "new");
                                        $this->set('spacebukkitbuildnew', $l_sb["BUILD"]["VERSION"]);
                                        $this->set('spacebukkitbuildfile', './update');

                                    }

                                    //check for uncle Ant's messages

                                    $message = $this->Configurator->xml('message.12.xml');

                                    //set the message

                                    if ($message["MESSAGES"]["STATUS"] > 0) {

                                        $this->set('antmessage', $message["MESSAGES"]["MESSAGE"]);

                                        switch ($message["MESSAGES"]["TYPE"]) {
                                            case 0:
                                                $this->set('antmessagetype', "red");
                                                break;
                                            case 1:
                                                $this->set('antmessagetype', "blue");
                                                break;
                                            case 2:
                                                $this->set('antmessagetype', "green");
                                                break;
                                        }
                                    }

                                    //check for uncle Ant's doodles

                                    if ($message["DOODLES"]["STATUS"] > 0) {

                                        $this->set('doodle', "http://dl.nope.bz/sb/build/".$message["DOODLES"]["IMAGE"]);
                                    }

                                }

                            }

                        }


                            $all_servers = $this->Server->find("all");

                            $allowed_actions = array("no_servers_set", "no_servers_set_manage", "logout");

                            if ((count($all_servers) < 1) && (!(in_array($this->action, $allowed_actions)))) {

                                if ($this->Auth->user('is_super') != 1) {

                                $this->redirect(array('controller' => 'global', 'action' => 'no_servers_set'));

                                } elseif ($this->Auth->user("is_super") == 1) {

                                $this->redirect(array('controller' => 'global', 'action' => 'no_servers_set_manage'));

                                }

                            } elseif (in_array($this->action, $allowed_actions)) {} else  {


                    /* ####################################################
                    *   6)  If the user is not "SuperUser" and not associated to any server, redirect to "global/no_servers_set"
                    ##################################################### */

                            $this->loadModel('User');
                            $this->loadModel('ServersUsers');

                            $user_data = $this->User->findById($this->Auth->user("id"));
                            $allowed_actions = array("no_servers_assoc", "logout");

                            if (empty($user_data["ServersUsers"]) && !(in_array($this->action, $allowed_actions)) && ($this->Auth->user('is_super') < 1)) {

                                $this->redirect(array('controller' => 'global', 'action' => 'no_servers_assoc'));

                            } elseif (in_array($this->action, $allowed_actions)) {} else {

                    /* ####################################################
                     *   7)  Set roles for server. If the user role is not defined, change it to default
                    ##################################################### */

                            if ( empty($user_data["ServersUsers"]) ) {

                                $current_server = $this->Session->read("current_server");

                                //Check if cookie for current server was set. If not, set it to default
                                if (empty($current_server)) {
                                        $s = $this->Server->find("first");
                                        $this->Session->write("current_server", $s['Server']['id']);
                                        $current_server = $s['Server']['id'];

                                }

                            }  else {

                                $current_server = $this->Session->read("current_server");

                                //Check if cookie for current server was set. If not, set it to default
                                if (empty($current_server)) {

                                    if ( $user_data["User"]['favourite_server'] != 0 ) {

                                        $this->Session->write("current_server", $user_data['User']['favourite_server']);
                                        $current_server =  $user_data['User']['favourite_server'];

                                    }
                                    else
                                    {
                                        $s = $this->ServersUsers->find('first', array('conditions' => array("ServersUsers.user_id" => $this->Auth->user("id"))));
                                        $this->Session->write("current_server", $s['Server']['id']);
                                        $current_server = $s['Server']['id'];

                                    }

                                }
                            }

                            //New variable "$usr" stores all data relative to the user, relative to the current server
                            $conditions = array("ServersUsers.server_id" => $current_server, "ServersUsers.user_id" => $this->Auth->user("id"));
                            $usr = $this->ServersUsers->find('first', array('conditions' => $conditions));
                            $usr['AllowedServers'] = $this->ServersUsers->find('all', array('conditions' => array("ServersUsers.user_id" => $this->Auth->user("id"))));

                            //If superuser, construct his "$usr" manually

                            if ($this->Auth->user("is_super") == 1) {

                                $usr = array();

                                $usr["User"] = $user_data["User"];
                                $conditions = array("Server.id" => $current_server);
                                $server = $this->Server->find('first', array('conditions' => $conditions));
                                $usr["Server"] = $server["Server"];
                                $usr["Role"] = array(

                                    "id" => 99999,
                                    "title" => "superuser",
                                    "pages" => 255,
                                    "global" => 255,
                                    "dash" => 255,
                                    "users" => 255,
                                    "plugins" => 255,
                                    "worlds" => 255,
                                    "servers" => 255,
                                    "backups" => 255,
                                    "permissions" => 255,
                                    "timeline" => 255,
                                    );

                            }

                            $conditions = array("Server.id" => $current_server);
                            $s = $this->Server->find('first', array('conditions' => $conditions));

                            //write server config to session

                            $this->Session->write('Server.address', $s['Server']['address']);
                            $this->Session->write('Server.external_address', $s['Server']['external_address']);
                            $this->Session->write('Server.salt', $s['Server']['password']);
                            $this->Session->write('Server.p1', $s['Server']['port1']);
                            $this->Session->write('Server.p2', $s['Server']['port2']);

                            //security reset to fallback role if role does not exist

                            if (is_null($usr["Role"]["id"])) {

                                $conditions = array("Role.fallback" => "1");

                                $this->loadModel('Role');

                                $fallback = $this->Role->find('first', array("conditions" => $conditions));

                                $this->ServersUsers->updateAll(
                                    array('ServersUsers.role_id' => $fallback["Role"]["id"]),
                                    array('ServersUsers.role_id' => $usr["ServersUsers"]["role_id"])
                                    );

                                //Re-read USR
                                $conditions = array("ServersUsers.server_id" => $current_server, "ServersUsers.user_id" => $this->Auth->user("id"));
                                $usr = $this->ServersUsers->find('first', array('conditions' => $conditions));

                            }


                    /* ####################################################
                     *   8)  Set current server, language, global variables etc.
                    ##################################################### */

                            $this->Session->write('Config.language', $usr['User']['language']);

                            } //end else user_data empty

                            $this->set('all_servers', $all_servers);
                            $this->set('current_server', $current_server);
                            $usr['Role']['is_super'] = $this->Auth->user('is_super');
                            $this->set('glob_perm', $permissions);
                            $this->set('current_server_name', $usr["Server"]["title"]);
                            $this->set('user_data', $usr);
                            $this->set('user_perm', $usr['Role']);
                            $this->Session->write('glob_perm', $permissions);
                            $this->Session->write('user_perm', $usr['Role']);

                    /* ####################################################
                     *   8b)  Write timestamp for "Admins online" section
                    ##################################################### */
                            $this->User->id = $this->Auth->User('id');

                            $data = array(
                               'User' => array(
                                            'active'          =>    time()
                               )
                            );

                            $this->User->save($data);

                            }
                        }
                    }
                } //maintenance
            } //logged in
        } //endif install
    }

/* ####################################################
 *   9)  Set current theme. If non existent, set it to default.
##################################################### */

	function beforeRender()

	  {
        //Check if current theme exists. If not, set it to default

        $theme = $this->Session->read("current_theme");

        $themefile = new File(WWW_ROOT . "themes/".$theme."/theme.xml");

        if ($themefile->exists()){
            $this->set('current_theme', $theme);
        } else {
            $this->set('current_theme', "Spacebukkit");

        }

        $this->set('gototab', $this->Session->read('Page.tab'));
        $this->Session->delete('Page.tab');

      }

/**
 * Refreshes the Auth session with new/updated data
 * @param string $field
 * @param string $value
 * @return void
 */
function _refreshAuth($field = '', $value = '') {
    if (!empty($field) && !empty($value)) {
        $this->Session->write($this->Auth->sessionKey .'.'. $field, $value);
    } else {
        if (isset($this->User)) {
            $this->Auth->login($this->User->read(false, $this->Auth->user('id')));
        } else {
            $this->Auth->login(ClassRegistry::init('User')->findById($this->Auth->user('id')));
        }
    }
}

}


