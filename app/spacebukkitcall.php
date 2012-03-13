<?php

/**
*
*   ####################################################
*   SpaceBukkitAPI.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This file was written to shorten the amount of lines each SpaceBukkit request needs.
*	It is "included" in every function that wants to do an API call.
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/
$this->loadModel('Server'); 
$this->loadModel('Variables'); 

//DATABASE SERVER RETRIVAL
$id = $this->Session->read("current_server");
$getserver = $this->Server->findById($id);
$server = $getserver['Server']['address'];
$salt = $getserver['Server']['password'];
$p1 = $getserver['Server']['port1'];
$p2 = $getserver['Server']['port2'];

//call API

include 'SpaceBukkitAPI.php';          // This line is used to include the ressources file.
$api = new SpaceBukkitAPI($server, $p1, $p2, $salt);
