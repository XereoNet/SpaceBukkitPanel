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
      
	  //get all categories
	  $cats = json_decode(file_get_contents("http://api.bukget.org/api/categories"));
    $latest = json_decode(file_get_contents("http://api.bukget.org/api"), TRUE);

    $this->set('cats', $cats);
    $this->set('latest', $latest['changes']);

  	  //view-specific settings
      $this->layout = 'bukget';
 
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
              </div>
              <div class="col right col_1_3" style="text-align: right; margin-top: 3px">
                $button
              </div>
 			</div>
</li>
END;
        } 
      }  
    }

    function getLatest() {

      if ($this->request->is('ajax')) {
      $this->disableCache();
      $this->autoRender = false;

      $api = json_decode(file_get_contents("http://api.bukget.org/api"), TRUE);
      
      echo '<ul>';
      
      foreach ($api['changes'] as $plugin) 
      {

echo <<<END
    <li>
    <b>Plugin 1</b>
    <p>Date modified</p>
    </li>
END;
      } 

      echo '</ul>';

      }  
    }

   function getHeading($plugin) {

      if ($this->request->is('ajax')) {
      $this->disableCache();
      $this->autoRender = false;

      $api = json_decode(file_get_contents("http://api.bukget.org/api/plugin/".$plugin), TRUE);
      
      echo('<h3>'.$api['plugin_name'].'</h3> <a href="'.$api['bukkitdev_link'].'" target="_blank">(BukkitDev)</a>');

      }  
    }

   function getDetails($plugin) {

      if ($this->request->is('ajax')) {
      $this->disableCache();
      $this->autoRender = false;

      $api = json_decode(file_get_contents("http://api.bukget.org/api/plugin/".$plugin), TRUE);
      
      //debug($api);

      //Function to get strings
      function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
      }

      $authors      = implode(', ', $api['authors']);
      $status       = $api['status'];
      $categories   = implode(', ', $api['categories']);
      $desc   = $api['desc'];

      $data = file_get_contents($api['bukkitdev_link']);

      

      $img = get_string_between($data, 'data-full-src="', '"');

      echo <<<END
<ul>
  <li>
    <b>Authors</b>
    <p>$authors</p>
  </li>
  <li>
    <b>Status</b>
    <p>$status</p>
  </li>
  <li>
    <b>Categories</b>
    <p>$categories</p>    
  </li>
  <li>
    <b>Description</b>
    <p>
    <img src="$img" width="250px" />
    $desc
    </p>
  </li>
</ul>'


END;

      }  
    }

}
