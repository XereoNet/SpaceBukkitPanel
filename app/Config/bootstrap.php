<?php

/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as 
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @package       app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Setup a 'default' cache configuration for use in the application.

Cache::config('default', array('engine' => 'File'));

Configure::write('Spacebukkit.theme', "Spacebukkit");

App::import('Vendor', 'serverlog'); 

function perm($node, $perm, $user_perm, $message=false) {

	require APP.'webroot/configuration.php';

	if (($user_perm[$node] & $permissions[$node][$perm]) || ($user_perm['is_super'] == 1)) 
	{
		return true;
	}
	else 
	{
		if ($message) {
			exit('Permission denied - you are not allowed to be here!');
		}
		else {
		return false;	
		}
		
	}

}

function perm_action($node, $perm, $user_perm, $value=null) {

	require APP.'webroot/configuration.php';

	if (($user_perm[$node] & $permissions[$node][$perm]) || ($user_perm['is_super'] == 1)) 
	{

		return $value;

	}
	else 
	{
		
		return false;	
		
	}

}

/* LOAD SPACEBUKKIT CONFIGURATION */

require APP . 'webroot/system.php';

Configure::write('debug', $system[0]['val']);

Configure::write('Cache.disable',  $system[1]['val']);

Configure::write('Security.salt',  "Oijasfdj544dsASd44dsh9a9sdASdgjyky8455s1as8w789q");

Configure::write('Security.cipherSeed',  "3196725290708910560802715405054");

date_default_timezone_set( $system[2]['val']);

?>