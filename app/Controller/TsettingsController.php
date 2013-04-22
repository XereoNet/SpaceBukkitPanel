<?php

/**
*
*   ####################################################
*   TSettingsController.php
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is relative to the "Settings" page and all it's related functions.
*   Note that this controller is not connected to the bukkit server and therefore does
*   NOT require a connection.
*
*   TABLE OF CONTENTS
*
*   1)  index
*   2)  getUsers
*   3)  getRoles
*   4)  getServer
*   5)  getNoServer
*   6)  getRole
*   7)  update_theme
*   8)  delete_theme
*   9)  update_config
*
*
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class TsettingsController extends AppController {

    public $helpers = array ('Html','Form');

    public function beforeFilter()

      {
        parent::beforeFilter();

        $allowed_actions = array("update_theme");

        //check if user has rights to do this
        if (!(in_array($this->action, $allowed_actions))) {

          if ($this->Auth->user('is_super') != 1) {

            throw new MethodNotAllowedException();

          }

        }
    }

    function index()

    	{

        /*

        *   Connection Check - Is the server running? Redirect accordingly.

        */

        require APP . 'spacebukkitcall.php';

        //CHECK IF SERVER IS RUNNING

        $args = array();
        $running = $api->call("isServerRunning", $args, true);

        $this->set('running', $running);

        //IF "FALSE", IT'S STOPPED. IF "NULL" THERE WAS A CONNECTION ERROR

        if (is_null($running) || preg_match("/salt/", $running)) {

            $this->layout = 'sbv1_notreached_settings';

        }

        elseif (!$running) {

            $this->layout = 'sbv1_notrunning_settings';

        } else {

            $this->layout = 'sbv1';

        }

        $dataSource = ConnectionManager::getDataSource('default');

		//View Specific settings
        $this->set('title_for_layout', 'Settings');
        $this->set('configurations', $dataSource);
        include(APP . 'webroot/vars.php');
        include(APP . 'webroot/system.php');
        $this->set('variables', $variables);
        $this->set('system', $system);

	    }

    function sb_config_save() {

        if ($this->request->is('post')) {

              $this->loadModel('Configurator');

              $data = $this->request->data;
              $this->Configurator->saveVars($data);
              $this->redirect($this->referer());
              $this->Session->write('Page.tab', 5);
        }

    }

    function sb_system_save() {

        if ($this->request->is('post')) {

              $this->loadModel('Configurator');

              $data = $this->request->data;
              $this->Configurator->saveSys($data);
              $this->redirect($this->referer());
              $this->Session->write('Page.tab', 7);

        }

    }

    function getUsers() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        //Get users
        $this->loadModel('User');
        $users = $this->User->find('all');

        $i = 1;
        $num = count($users);

        echo '{ "aaData": [';

        foreach ($users as $user) {

        $name = $user['User']['username'];
        $id = $user['User']['id'];

        $edit = './users/edit_admin/';
        $delete = './users/delete/';

        $buttons = '<a href=\"'.$edit.$id.'\" class=\"button icon edit fancy\" style=\"float: right\">Edit</a><form style=\"position: relative; display: inline;\" name=\"submitForm\" method=\"POST\" action=\"'.$delete.$id.'\"><input type=\"hidden\" name=\"id\" value=\"'.$id.'\"><input type=\"submit\" value=\"Delete\" class=\"button danger\" style=\"float: right\"></form>';

        if ($id == 1) {
            $buttons = '<a href=\"'.$edit.$id.'\" class=\"button icon edit fancy\" style=\"float: right\">Edit</a>';
        }

        ECHO <<<END
            [
              "<span>$name</span>$buttons"
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
    function getUsers2() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        //Get users
        $this->loadModel('User');
        $users = $this->User->find('all');

        $i = 1;
        $num = count($users);

        echo '{ "aaData": [';

        foreach ($users as $user) {

        $name = $user['User']['username'];
        $id = $user['User']['id'];

        $edit = '../users/edit_admin/';
        $delete = '../users/delete/';

        $buttons = '<a href=\"'.$edit.$id.'\" class=\"button icon edit fancy\" style=\"float: right\">Edit</a><form style=\"position: relative; display: inline;\" name=\"submitForm\" method=\"POST\" action=\"'.$delete.$id.'\"><input type=\"hidden\" name=\"id\" value=\"'.$id.'\"><input type=\"submit\" value=\"Delete\" class=\"button danger\" style=\"float: right\"></form>';

        if ($id == 1) {
            $buttons = '<a href=\"'.$edit.$id.'\" class=\"button icon edit fancy\" style=\"float: right\">Edit</a>';
        }

        ECHO <<<END
            [
              "<span>$name</span>$buttons"
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

   function getRoles() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        //Get users
        $this->loadModel('Role');
        $roles = $this->Role->find('all');

        $i = 1;
        $num = count($roles);

        echo '{ "aaData": [';

        foreach ($roles as $role) {

        $title = $role['Role']['title'];
        $id = $role['Role']['id'];
        if ($role["Role"]["fallback"] == 1) {

            $default = '<img src=\"./img/test-pass-icon.png\" />';
            $delete = "";

            } else {

            $delete = '<form style=\"position: relative; display: inline;\" name=\"submitForm\" method=\"POST\" action=\"./roles/delete/'.$id.'\"><input type=\"hidden\" name=\"id\" value=\"'.$id.'\"><input type=\"submit\" value=\"Delete\" class=\"button danger\" style=\"float: right\"></form>';
            $default = "";
        }
        ECHO <<<END
            [
              "$title",
              "<a href=\"./roles/edit/$id\" class=\"button icon edit fancy\" style=\"float: right\">Edit</a>$delete",
              "$default"
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

   function getServers() {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        //Get users
        $servers = $this->Server->find('all');

        $i = 1;
        $num = count($servers);

        //var_dump($servers);

        echo '{ "aaData": [';

        foreach ($servers as $server) {

        $title = $server['Server']['title'];
        $id = $server['Server']['id'];

        ECHO <<<END
            [
              "$title",
              "<a href=\"./servers/edit/$id\" class=\"button icon edit fancy\" style=\"float: right\">Edit</a><form style=\"position: relative; display: inline;\" name=\"submitForm\" method=\"POST\" action=\"./servers/delete/$id\"><input type=\"hidden\" name=\"id\" value=\"$id\"><input type=\"submit\" value=\"Delete\" class=\"button danger\" style=\"float: right\"></form>"
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
    function getServer($user) {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        //Get servers
        $this->loadModel("User");
        $this->loadModel("ServersUsers");

        $username = $this->User->findByUsername($user);

        $servers = $this->ServersUsers->find('all', array('conditions' => array('ServersUsers.user_id' => $username['User']['id'])));
        $i = 1;
        $num = count($servers);

        echo '{ "aaData": [';

        foreach ($servers as $server) {

        $name = $server['Server']['title'];
        $id = $server['ServersUsers']['id'];

        ECHO <<<END
            [
              "<span title=\"$id\">$name</span> <form style=\"position: relative; display: inline;\" name=\"submitForm\" method=\"POST\" action=\"./users/deleteFromServer/$id\"><input type=\"submit\" value=\"Delete\" class=\"button danger\" style=\"float: right\"></form>"
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

   function getNoServer($user) {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        //Get servers
        $this->loadModel("User");
        $this->loadModel("Role");

        $username = $this->User->findByUsername($user);

        $userid = $username['User']['id'];
        $servers = $this->Server->find('all');

        foreach ($servers as $server) {

        $title = $server['Server']['title'];
        $id = $server['Server']['id'];
        $role = $server['Server']['default_role'];

        $output = '<li><form name="addtoaserver" method="POST" action="./users/addToServer/"><input type="hidden" name="server_id" value="'.$id.'"><input type="hidden" name="user_id" value="'.$userid.'"><input type="hidden" name="role_id" value="'.$role.'"><input type="submit" value="'.$title.'" class="button"></form></li>';

            foreach ($server['ServersUsers'] as $su) {

            if ($su['user_id'] == $userid) {

                $output = "";

            }

            }

           echo $output;

        }

    }
    }

    function getRole($id) {

    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        //Get servers
        $this->loadModel("ServersUsers");
        $this->loadModel("Role");

        //get the selected relation

        $usr = $this->ServersUsers->findById($id);

        $roles = $this->Role->find("list");

        $current_role = $usr["Role"]["id"];
        $current_role_name = $usr["Role"]["title"];
        $current_server = $usr['Server']['id'];
        $current_user = $usr['User']['id'];



        ECHO <<<END
        <form name="changeRole" id="role_select" method="POST" action="./users/editRoleOfServer/$id">
            <input type="hidden" name="server_id" value="$current_server">
            <input type="hidden" name="user_id" value="$current_user">
            <select id="roleSelect" name="role_id">
                <option value="$current_role">$current_role_name</option>
END;
    foreach ($roles as $role_key => $role) {

        if ($role_key != $current_role) {

        echo '<option value="'.$role_key.'">'.$role.'</option>';

        }
    }
        ECHO <<<END
            </select>
        </form>
END;
        }
    }

    public function update_theme($name = null) {
        $this->loadModel('User');
    	$id = $this->Auth->user('id');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->Session->setFlash('2', 'blank', array(), 'tab');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->saveField('theme', $name)) {
                $this->Session->setFlash(__('The theme has been saved'));
                $this->Session->delete('current_theme');
                $this->Session->write('current_theme', $name);
                $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('The theme could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
        $this->layout = 'popup';
    }

    public function delete_theme($name = null) {

        if ($this->request->is('post')) {

            if ($name == "Spacebukkit") { exit("You can't delete Spacebukkit theme"); }

                $this->Session->setFlash(__('The theme has been deleted'));

                $this->Session->delete('current_theme');

                function recursive_remove_directory($directory, $empty=FALSE)
                {
                    if(substr($directory,-1) == '/')
                    {
                        $directory = substr($directory,0,-1);
                    }
                    if(!file_exists($directory) || !is_dir($directory))
                    {
                        return FALSE;
                    }elseif(is_readable($directory))
                    {
                        $handle = opendir($directory);
                        while (FALSE !== ($item = readdir($handle)))
                        {
                            if($item != '.' && $item != '..')
                            {
                                $path = $directory.'/'.$item;
                                if(is_dir($path))
                                {
                                    recursive_remove_directory($path);
                                }else{
                                    unlink($path);
                                }
                            }
                        }
                        closedir($handle);
                        if($empty == FALSE)
                        {
                            if(!rmdir($directory))
                            {
                                return FALSE;
                            }
                        }
                    }
                    return TRUE;
                }
                // ------------------------------------------------------------

                $themedir = WWW_ROOT . "themes/".$name;

                recursive_remove_directory($themedir, TRUE);

                rmdir($themedir);

                clearCache();

                $this->Session->write('Page.tab', 4);

                $this->redirect(array('controller' => 'tsettings', 'action' => 'index'));

       }
    }

    function update_config() {

        if ($this->request->is('post')) {

              $this->loadModel('Configurator');

              $data = $this->request->data;
              $this->Configurator->saveDb($data['type'], $data['host'], $data['login'], $data['password'], $data['database']);
              $this->redirect($this->referer());
              $this->Session->write('Page.tab', 5);
        }

    }

}

?>