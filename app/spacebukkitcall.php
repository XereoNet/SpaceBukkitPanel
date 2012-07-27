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

//DATABASE SERVER RETRIVAL

$server = $this->Session->read("Server.address");
$salt 	= $this->Session->read("Server.salt");
$p1 	= $this->Session->read("Server.p1");
$p2 	= $this->Session->read("Server.p2");

//call API

include 'SpaceBukkitAPI.php';          // This line is used to include the ressources file.
$api = new SpaceBukkitAPI($server, $p1, $p2, $salt);
