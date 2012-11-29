<?php

/**
*
*   ####################################################
*   UserController.php
*   ####################################################
*
*   DESCRIPTION
*
*   This controller manages all user related functions
*   like logins and logouts, CRUD, theme chooser, USR
*   and validation (found in the model).
*
*   TABLE OF CONTENTS
*
*   1)  beforeFilter
*   2)  index
*   3)  login
*   4)  logout
*   5)  add (includes "fileslist" function)
*   6)  edit
*   7)  delete
*   8)  theme
*   9)  addToServer
*   10) removeFromServer
*   11) editRoleOfServer
*
*
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/


class UsersController extends AppController {

    /*
       ###################################################################################
       The following functions regulate all user related manners like logins and CRUD
       ###################################################################################
    */

    public function beforeFilter() {
        parent::beforeFilter();

        $allowed_actions = array("index", "login", "logout", "edit", "theme");

        if (!(in_array($this->action, $allowed_actions))) {

          if ($this->Auth->user('is_super') != 1) {

            throw new MethodNotAllowedException();

          }

        }

    }

    public function index() {
        $this->redirect(array('controller' => 'dash', 'action' => 'index'));
    }

    public function login() {

      if ($this->Auth->login()) {
          $this->Session->write("current_theme", $this->Auth->user('theme'));
          $this->Session->write("current_server", $this->Auth->user("favourite_server"));

          $this->redirect(array('controller' => 'global', 'action' => 'login'));

      }

      //check for uncle Ant's news

      $this->loadModel('Configurator');

      $setting1 = $this->Configurator->returnSys(3);
      $setting2 = $this->Configurator->returnSys(4);

      if($setting1["val"] == "true" && $setting2["val"] == 'true') {

        $filename = 'http://dl.nope.bz/sb/build/news.xml';
        $message = simplexml_load_file($filename);

        $json = json_encode($message);
        $message = json_decode($json, TRUE);
        $this->set('message', $message);

      }

      $this->set('title_for_layout', __('Login to SpaceBukkit'));

      if (!empty($this->Auth->request->data)) {
        $this->set('flash', $this->Auth->loginError);
      } else {
        $this->set('flash', $this->Session->read('auth'));
      }

      $this->layout = 'login';

    }

    public function logout() {
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }

    public function add() {

        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('controller' => 'tsettings', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
            $this->loadModel("Server");
            $this->set('all_servers', $this->Server->find("all"));

        /*

         *  FIND ALL THEMES AND SET THEM FOR THE VIEW

         */

            function filelist ($startdir="./", $searchSubdirs=0, $directoriesonly=1, $maxlevel="1", $level=1) {

        //list the directory/file names that you want to ignore

        $ignoredDirectory[] = ".";

        $ignoredDirectory[] = "..";

        $ignoredDirectory[] = "_vti_cnf";

        global $directorylist;    //initialize global array

        if (is_dir($startdir)) {

            if ($dh = opendir($startdir)) {

                while (($file = readdir($dh)) !== false) {

                    if (!(array_search($file,$ignoredDirectory) > -1)) {

                     if (filetype($startdir . $file) == "dir") {

                           //build your directory array however you choose;

                           //add other file details that you want.

                           $directorylist[$startdir . $file]['level'] = $level;

                           $directorylist[$startdir . $file]['dir'] = 1;

                           $directorylist[$startdir . $file]['name'] = $file;

                           $directorylist[$startdir . $file]['path'] = $startdir;

                           if ($searchSubdirs) {

                               if ((($maxlevel) == "all") or ($maxlevel > $level)) {

                                   filelist($startdir . $file . "/", $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);

                               }

                           }

                       } else {

                           if (!$directoriesonly) {

                               //if you want to include files; build your file array

                               //however you choose; add other file details that you want.

                             $directorylist[$startdir . $file]['level'] = $level;

                             $directorylist[$startdir . $file]['dir'] = 0;

                             $directorylist[$startdir . $file]['name'] = $file;

                             $directorylist[$startdir . $file]['path'] = $startdir;

          }}}}

               closedir($dh);

        }}

        return($directorylist);

        }

        $themes = filelist(APP . "webroot/themes/",1,1);

        $this->set('themes', $themes);

        //get all languages

        require APP . 'webroot/configuration.php';

        $this->set('languages', $languages);

        $this->layout = 'popup';

    }

    function edit($id = null) {
        $this->User->id = $id;
        if ($this->request->is('get')) {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
            $this->set('edituser', $this->request->data);
            $this->loadModel("Server");
            $this->set('all_servers', $this->Server->find("all"));


        /*

         *  FIND ALL THEMES AND SET THEM FOR THE VIEW

         */

            function filelist ($startdir="./", $searchSubdirs=0, $directoriesonly=1, $maxlevel="1", $level=1) {

        //list the directory/file names that you want to ignore

        $ignoredDirectory[] = ".";

        $ignoredDirectory[] = "..";

        $ignoredDirectory[] = "_vti_cnf";

        global $directorylist;    //initialize global array

        if (is_dir($startdir)) {

            if ($dh = opendir($startdir)) {

                while (($file = readdir($dh)) !== false) {

                    if (!(array_search($file,$ignoredDirectory) > -1)) {

                     if (filetype($startdir . $file) == "dir") {

                           //build your directory array however you choose;

                           //add other file details that you want.

                           $directorylist[$startdir . $file]['level'] = $level;

                           $directorylist[$startdir . $file]['dir'] = 1;

                           $directorylist[$startdir . $file]['name'] = $file;

                           $directorylist[$startdir . $file]['path'] = $startdir;

                           if ($searchSubdirs) {

                               if ((($maxlevel) == "all") or ($maxlevel > $level)) {

                                   filelist($startdir . $file . "/", $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);

                               }

                           }

                       } else {

                           if (!$directoriesonly) {

                               //if you want to include files; build your file array

                               //however you choose; add other file details that you want.

                             $directorylist[$startdir . $file]['level'] = $level;

                             $directorylist[$startdir . $file]['dir'] = 0;

                             $directorylist[$startdir . $file]['name'] = $file;

                             $directorylist[$startdir . $file]['path'] = $startdir;

          }}}}

               closedir($dh);

        }}

        return($directorylist);

        }

        $themes = filelist(APP . "webroot/themes/",1,1);

        $this->set('themes', $themes);

        //get all languages

        require APP . 'webroot/configuration.php';

        $this->set('languages', $languages);

        $this->layout = 'popup';

        } else {

            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Your User has been updated.'));
                $data = $this->request->data;
                $this->_refreshAuth('username', $data['username']);
                $this->_refreshAuth('language', $data['language']);

                $this->Session->write('Auth.User.username', $data['username']);
                $this->Session->write('Auth.User.language', $data['language']);

                $this->redirect(array('controller' => 'tsettings', 'action' => 'index'));

            } else {
                $this->Session->setFlash(__('Unable to update your User.'));
            }
        }
    }

    function edit_admin($id = null) {

        $this->User->id = $id;
        if ($this->request->is('get')) {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
            $this->set('edituser', $this->request->data);
            $this->loadModel("Server");
            $this->set('all_servers', $this->Server->find("all"));

        /*

         *  FIND ALL THEMES AND SET THEM FOR THE VIEW

         */

            function filelist ($startdir="./", $searchSubdirs=0, $directoriesonly=1, $maxlevel="1", $level=1) {

        //list the directory/file names that you want to ignore

        $ignoredDirectory[] = ".";

        $ignoredDirectory[] = "..";

        $ignoredDirectory[] = "_vti_cnf";

        global $directorylist;    //initialize global array

        if (is_dir($startdir)) {

            if ($dh = opendir($startdir)) {

                while (($file = readdir($dh)) !== false) {

                    if (!(array_search($file,$ignoredDirectory) > -1)) {

                     if (filetype($startdir . $file) == "dir") {

                           //build your directory array however you choose;

                           //add other file details that you want.

                           $directorylist[$startdir . $file]['level'] = $level;

                           $directorylist[$startdir . $file]['dir'] = 1;

                           $directorylist[$startdir . $file]['name'] = $file;

                           $directorylist[$startdir . $file]['path'] = $startdir;

                           if ($searchSubdirs) {

                               if ((($maxlevel) == "all") or ($maxlevel > $level)) {

                                   filelist($startdir . $file . "/", $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);

                               }

                           }

                       } else {

                           if (!$directoriesonly) {

                               //if you want to include files; build your file array

                               //however you choose; add other file details that you want.

                             $directorylist[$startdir . $file]['level'] = $level;

                             $directorylist[$startdir . $file]['dir'] = 0;

                             $directorylist[$startdir . $file]['name'] = $file;

                             $directorylist[$startdir . $file]['path'] = $startdir;

          }}}}

               closedir($dh);

        }}

        return($directorylist);

        }

        $themes = filelist(APP . "webroot/themes/",1,1);

        $this->set('themes', $themes);

        //get all languages

        require APP . 'webroot/configuration.php';

        $this->set('languages', $languages);

        $username = $this->User->findById($this->User->id);

        $this->set("username", $username["User"]["username"]);

        $this->layout = 'popup';

        } else {
          $this->User->validate = $this->User->validatewithoutpw;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Your User has been updated.'));
                $this->redirect(array('controller' => 'tsettings', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('Unable to update your User.'));
            }
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->id == 1) {
            throw new MethodNotAllowedException();
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect($this->referer());
    }


    /*
       ###################################################################################
       The following functions are relative to views
       ###################################################################################
    */

    function theme() {
        $this->layout = 'popup';
    }

    /*
       ###################################################################################
       The following functions regulate the user-server-roles relationships
       ###################################################################################
    */

    public function addToServer() {

        $this->loadModel("ServersUsers");

        if ($this->request->is('post')) {
            $this->ServersUsers->create();
            if ($this->ServersUsers->save($this->request->data)) {
                $this->Session->setFlash(__('The server has been saved'));
                $this->redirect(array('controller' => 'tsettings', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The server could not be saved, please try again.'));
            }
        }
        $this->redirect($this->referer());

    }

    public function deleteFromServer($id = null) {

        $this->loadModel("ServersUsers");

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->ServersUsers->id = $id;
        $data = $this->ServersUsers->findById($id);
        $this->User->id = $data['User']['id'];
        $this->User->saveField('favourite_server', 0);

        if (!$this->ServersUsers->exists()) {
            throw new NotFoundException(__('Invalid ServersUsers'));
        }
        if ($this->ServersUsers->delete()) {
            $this->Session->setFlash(__('ServersUsers deleted'));
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('ServersUsers was not deleted'));
        $this->redirect($this->referer());

    }

    public function editRoleOfServer($id = null) {


    if ($this->request->is('ajax')) {
        $this->disableCache();
        Configure::write('debug', 0);
        $this->autoRender = false;

        $this->loadModel("ServersUsers");

        $this->ServersUsers->id = $id;
        if (!$this->ServersUsers->exists()) {
            throw new NotFoundException(__('Invalid ServersUsers'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ServersUsers->save($this->request->data)) {
                echo __('Saved!');
            } else {
                echo __('Error :(');
            }
        }
    }
    }

}