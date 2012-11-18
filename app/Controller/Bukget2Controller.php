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

      $url = "http://bukget.org";

      $handle = curl_init($url);
      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

      /* Get the HTML or whatever is linked in $url. */
      $response = curl_exec($handle);

      /* Check for 404 (file not found). */
      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

      if($httpCode == 503 || $httpCode == 404) {

        $this->layout = 'bukgetdown';


      } else {

        //get all categories
        $cats = json_decode(file_get_contents("http://api.bukget.org/api2/categories"));
        $latest = json_decode(file_get_contents("http://api.bukget.org/api"), TRUE);

        $this->set('cats', $cats);
        $this->set('latest', $latest['changes']);

        //view-specific settings
        $this->layout = 'bukget';

      }

      curl_close($handle);

    }

    function search($string) {

      set_time_limit(60);
      $this->layout = 'ajax';

       //get all plugins installed
      require APP . 'spacebukkitcall.php';

      $args = array();
      $installed = $api->call("getPlugins", $args, false);

      function arraytolower(array $array, $round = 0){
        return unserialize(strtolower(serialize($array)));
      }

      $installed2 = arraytolower($installed);

      $output = '';

      $installed3 = str_replace("", " ", $installed);

      $installed4 = str_replace("-", " ", $installed);

      //get all plugins in the cat

      $string = str_replace("#", "", $string);
      $plugins = json_decode(file_get_contents("http://api.bukget.org/api/search/name/like/".$string));

      foreach ($plugins as $plugin) {

      if (in_array($plugin, $installed) || in_array($plugin, $installed2) || in_array($plugin, $installed3) || in_array($plugin, $installed4) ) {
        $button = '<a href="#" class="nobutton approve">'.__('Installed!').'</a>';
      } else {
        $button = '<a href="./bukget2/installPlugin/'.$plugin.'" class="button icon favorite installer">'.__('Install').'</a>';
      }

      $output .= '<li class="plugin"><div class="first_row"><div class="col left col_2_3"><h4>'.$plugin.'</h4></div><div class="col right col_1_3" style="text-align: right; margin-top: 3px">
                '.$button.'</div></div></li>';

        }

      $this->set('output', $output);


      $this->set('string', $string);

    }

    function cat($cat) {

      set_time_limit(60);
      $this->layout = 'bukget';

       //get all plugins installed
      require APP . 'spacebukkitcall.php';

      $args = array();
      $installed = $api->call("getPlugins", $args, false);

      function arraytolower(array $array, $round = 0){
        return unserialize(strtolower(serialize($array)));
      }

      $installed2 = arraytolower($installed);

      $output = '';

      $installed3 = str_replace("", " ", $installed);

      $installed4 = str_replace("-", " ", $installed);

      //get all plugins in the cat

      $cat = str_replace("#", "", $cat);
      $plugins = json_decode(file_get_contents("http://api.bukget.org/api2/bukkit/category/".$cat));

      foreach ($plugins as $plugin) {

      if (in_array($plugin->name, $installed) || in_array($plugin->name, $installed2) || in_array($plugin->name, $installed3) || in_array($plugin->name, $installed4) ) {
        $button = '<a href="#" class="nobutton approve">'.__('Installed!').'</a>';
      } else {
        $button = '<a href="./bukget2/installPlugin/'.$plugin->name.'" class="button icon favorite installer">'.__('Install').'</a>';
      }

      $output .= '<li class="plugin"><div class="first_row"><div class="col left col_2_3"><h4>'.$plugin->name.'</h4></div><div class="col right col_1_3" style="text-align: right; margin-top: 3px">
                '.$button.'</div></div></li>';

        }

      $this->set('output', $output);


      $this->set('cat', $cat);

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

      $api = json_decode(file_get_contents("http://api.bukget.org/api2/bukkit/plugin/".$plugin), TRUE);

      echo('<h3>'.$api['name'].'</h3> <a href="'.$api['link'].'" target="_blank">(BukkitDev)</a>');

      }
    }

   function getDetails($plugin) {

      if ($this->request->is('ajax')) {
      $this->disableCache();
      $this->autoRender = false;

      $api = json_decode(file_get_contents("http://api.bukget.org/api2/bukkit/plugin/".$plugin), TRUE);

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

      $status       = $api['stage'];
      $categories   = implode(', ', $api['categories']);
      $authors   = implode(', ', $api['authors']);
      $desc   = $api['description'];

      $data = file_get_contents($api['link']);

      $img = get_string_between($data, 'data-full-src="', '"');

      echo <<<END
<ul>
  <li>
    <b>Status</b>
    <p>$status</p>
  </li>
  <li>
    <b>Categories</b>
    <p>$categories</p>
  </li>
    <li>
    <b>Authors</b>
    <p>$authors</p>
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

    function installPlugin($name) {

      perm('plugins', 'removeAddPlugin', $this->Session->read("user_perm"), true);

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