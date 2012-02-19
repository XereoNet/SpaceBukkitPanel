<?php

/**
*
*   ####################################################
*   BukgetController.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This controller manages the BukGet interface and it's related functions
*
*   TABLE OF CONTENTS
*   
*   1)  index
*   2)  getPlugins
*   3)  installPlugin
*   
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class Bukget2Controller extends AppController {

    public $helpers = array('Html','Form');

    public $components = array('RequestHandler');

    function index() {

  	  //view-specific settings
      $this->layout = 'bukget';
 
    }

}
