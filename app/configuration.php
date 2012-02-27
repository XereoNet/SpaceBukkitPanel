<?php

/**
*
*   ####################################################
*   configuration.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This file stores global informations about SpaceBukkit.
*   IT is also used for i18n and role permissions
* 
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

	$sbconf['app_version'] = "Open Beta 1.1-01";
    $sbconf['app'] = "2";
    $sbconf['theme'] = "Spacebukkit";

    $languages = array();

    $languages['English'] = 'eng'; 
    $languages['Finnish'] = 'fin'; 
    $languages['German'] = 'ger'; 
    $languages['Polish'] = 'pol'; 
    $languages['French'] = 'fre'; 

    $permissions = array();

	$permissions["pages"] = array(
    'dash'      => 1, 
    'users' 	=> 2, 
    'plugins'   => 4, 
    'worlds'    => 8, 
    'server'    => 16, 
    'servertools'    => 32,
    'console'    => 64
    );

	$permissions["global"] = array(
    'addRemoveServer'      => 1, 
    'stopStartServer' 	=> 2, 
    'reloadServer'   => 4, 
    'restartServer'    => 8, 
    'vanillaMode'     => 16, 
    'configureServer'    => 32
	);

	$permissions["dash"] = array(
    'seeConsole'      => 1, 
    'runCommand' 	=> 2, 
    'Activity'   => 4, 
    'Chat'    => 8, 
    'Stats'     => 16
	);

	$permissions["users"] = array(
    'healAndFeed'      => 1, 
    'kill' 	=> 2, 
    'seeInventory'   => 4, 
    'kick'    => 8, 
    'ban'     => 16, 
    'whitelist'    => 32, 
    'op'    => 64, 
    'editInventory'    => 128
	);

	$permissions["plugins"] = array(
    'disablePlugin'      => 1, 
    'removeAddPlugin' 	=> 2, 
    'configurePlugin'   => 4, 
    'removeAddAddons'    => 8, 
    'updatePlugin'     => 16
	);

	$permissions["worlds"] = array(
    'runChunkster'      => 1, 
    'runMapAutoTrim' 	=> 2
	);	

	$permissions["servers"] = array(
    'addRemoveShedule'      => 1, 
    'changeBukkit' 	=> 2
	);

	$permissions["settings"] = array(
    'seeUsers'      => 1, 
    'editUser' 	=> 2, 
    'addRemoveUser'   => 4, 
    'seeRoles'    => 8, 
    'addRemoveRoles'     => 16, 
    'editRoles'    => 32, 
    'seeThemes'    => 64, 
    'installRemoveTheme'    => 128,
    'editSpaceBukkit'    => 256
	);

?>
