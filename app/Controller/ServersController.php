<?php

/**
*
*   ####################################################
*   ServersController.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This controller manages all server related functions. 
*   This includes CRUD.
*   
*   TABLE OF CONTENTS
*   
*   1)  index
*   2)  add
*   3)  edit
*   4)  delete
*   
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class ServersController extends AppController {

    public function index() {
        $this->redirect(array('controller' => 'dash', 'action' => 'index'));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Server->create();
            if ($this->Server->save($this->request->data)) {
                $this->Session->setFlash(__('The Server has been saved'));
                $this->redirect(array('controller' => 'tsettings', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Server could not be saved. Please, try again.'));
            }
        }
        $this->layout = 'popup';

        $this->loadModel('Role'); 

        $this->set('roles', $this->Role->find("all"));

    }
    
    public function edit($id = null) {
        $this->Server->id = $id;
        if (!$this->Server->exists()) {
            throw new NotFoundException(__('Invalid Server'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Server->save($this->request->data)) {
                $this->Session->setFlash(__('The Server has been saved'));
                $this->redirect(array('controller' => 'tsettings', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Server could not be saved. Please, try again.'));
            }
        } else {
            $this->set('editserver', $this->Server->read(null, $id));
        }
        $this->layout = 'popup';
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Server->id = $id;
        if (!$this->Server->exists()) {
            throw new NotFoundException(__('Invalid Server'));
        }
        if ($this->Server->delete()) {
            $this->Session->setFlash(__('Server deleted'));
            $this->redirect($this->referer());
        }
        $this->Session->setFlash(__('Server was not deleted'));
        $this->redirect($this->referer());
    }

}