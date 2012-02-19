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

class BukgetController extends AppController {

    public $helpers = array('Html','Form');

    public $components = array('RequestHandler');

    public $name = 'BukgetController';

    function index() {
      
  	//get all categories
  	$cats = json_decode(file_get_contents("http://api.bukget.org/api/categories"));

	  //view-specific settings
    $this->layout = 'popup';
    $this->set('cats', $cats);
 
    }

    function getPlugins($cat) {
      set_time_limit(60);
      if ($this->request->is('ajax')) {
      $this->disableCache();
      $this->autoRender = false;

       //get all plugins installed
      require APP . 'spacebukkitcall.php';

      $args = array();   
      $installed = $api->call("getPlugins", $args, false); 

      function arraytolower(array $array, $round = 0){ 
        return unserialize(strtolower(serialize($array))); 
      }    

      $installed2 = arraytolower($installed);
          
      $installed3 = str_replace("", " ", $installed);
          
      $installed4 = str_replace("-", " ", $installed);    
      
      //get all plugins in the cat

      $cat = str_replace("#", "", $cat); 
      $plugins = json_decode(file_get_contents("http://api.bukget.org/api/category/".$cat));

      foreach ($plugins as $plugin) {

      if (in_array($plugin, $installed) || in_array($plugin, $installed2) || in_array($plugin, $installed3) || in_array($plugin, $installed4) ) {
        $button = '<a href="#" class="nobutton approve">'.__('Installed!').'</a>';
      } else {
        $button = '<a href="./bukget/installPlugin/'.$plugin.'" class="button icon favorite installer">'.__('Install').'</a>';
      }
        
      echo <<<END
<li class="plugin">
            <div class="first_row">
              <div class="col left col_2_3">
                <h4>$plugin</h4>
                <a href="#" class="button icon arrowdown more">More info</a>
              </div>
              <div class="col right col_1_3" style="text-align: right; margin-top: 3px">
                $button
              </div>
            </div>
            <div class="details">
              <div class="col left">
                 <table class="table"> 

                        <tbody> 
                            <tr> 
                                <td>Authors</td> 
                                <td class="ar"></td> 
                            </tr> 
                            <tr> 
                                <td>Categories</td> 
                                <td class="ar"></td> 
                            </tr> 
                            <tr> 
                                <td>Bukkitdev</td> 
                                <td class="ar"></td> 
                            </tr> 
                        </tbody> 

                    </table>
              </div>
              <div class="col right">
                 <table class="table"> 

                        <tbody> 
                            <tr> 
                                <td>Status</td> 
                                <td class="ar"></td> 
                            </tr> 
                            <tr> 
                                <td>Hard Dependencies</td> 
                                <td class="ar"></td> 
                            </tr> 
                            <tr> 
                                <td>Soft Dependencies</td> 
                                <td class="ar"></td> 
                            </tr> 
                        </tbody> 
                    </table>
              </div>            
          </li>
END;
        } 
      }  
    }


    function installPlugin($name) {
 
      if ($this->request->is('ajax')) {
      $this->disableCache();
      Configure::write('debug', 0);
      $this->autoRender = false;   
      
      require APP . 'spacebukkitcall.php';

      $args = array($name);   
      $api->call("pluginInstall", $args, true);    

      }   
    }

}
