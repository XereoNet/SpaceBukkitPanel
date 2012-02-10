<!-- Navigation -->
<nav id="mainnav">
  <ul> 
        <?php if (($user_perm['pages'] & $glob_perm['pages']['dash']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./dash"> <span class="icon dashboard"></span><?php echo __(' Dashboard') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['users']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./tplayers"> <span class="icon users"></span><?php echo __(' Players ') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['plugins']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./tplugins"> <span class="icon plugins"></span><?php echo __(' Plugins ') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['worlds']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./tworlds"> <span class="icon world"></span><?php echo __(' Worlds ') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['server']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="current bounce fadein"> <a href="./tservers"> <span class="icon server"></span><?php echo __(' Server ') ?></a> </li>
        <?php } ?>
        <?php if ($is_super == 1) { ?>
        <li class="bounce fadein"> <a href="./tsettings"> <span class="icon settings"></span><?php echo __(' Settings ') ?></a> </li>
        <?php } ?>
  </ul>
</nav>
<!-- End Navigation --> 

<!-- Tabs -->
<nav id="smalltabs">
        <ul>
                <li class="current"><a href="#tab1">CraftBukkit</a></li>
                <li><a href="#tab2"><?php echo __('Server properties') ?></a></li>
                <li><a href="#tab3"><?php echo __('Shedules') ?></a></li>
        </ul>
</nav>
<!-- End Tabs -->
<!-- Content -->

<section id="content"> 

<div class="tab" id="tab1">
<section class="box boxpad"> 
 
        <header>
            <h2><?php echo __('CraftBukkit RB Chooser') ?></h2> 
        </header>
        
       <section>
             
       <p class="description">
       <?php echo __('Hover over an RB to see it\'s details. Click on an RB to install it for this server. Installing another CraftBukkit build will stop the server during the process!') ?>  
       </p>

       <div id="rb_chooser">
        <div class="rb_builds">

        <?php 

          $i = 0;
          //Function to get strings
          function get_string_between($string, $start, $end){
          $string = " ".$string;
          $ini = strpos($string,$start);
          if ($ini == 0) return "";
          $ini += strlen($start);
          $len = strpos($string,$end,$ini) - $ini;
          return substr($string,$ini,$len);
          }

          $c_bukkit_version = get_string_between($server['Version'], "-b", "jnks");

          foreach ($versions as $version) {

            $version_number = get_string_between($version['link'], "dev-CraftBukkit/", "/");

            $rb = "";

            if ($version_number == $c_bukkit_version) { $rb = "currentrb"; }
 
            echo '<a href="./tservers/install_cb/'.$version_number.'" class="confirmCB"><div class="rb bounce tip '.$rb.'">'.$version_number.'</div></a>';
            echo '<div class="tooltip">'.$version['description'].'</div>';

            if (++$i == 8) break;
          }

        ?>

        </div>
               <div class="timeline_start"></div>
               <div class="timeline"></div>
               <div class="timeline_end"></div>

       </div>

       <div class="clear"></div>
             <br /><br />
       <p class="description">
       <?php echo __('Alternatively you can specify a custom build here:') ?>
       </p>
       
      <form id="rb_chooser" class="bwl1" method="post" action="./tservers/install_cb">

      <fieldset>
       
      <input id="cb" name="cb" type="text" placeholder="<?php echo __('e.g. 1000') ?>"/>
      <input type="submit" class="button big primary submit confirmCB" value="<?php echo __('Download & Install this Build') ?>">
        </fieldset>

      </form>   
       
       </section> 
                        
</section>
<div class="clear"></div>

</div>

<div class="tab" id="tab2">
<section class="box boxpad"> 
    <header>
        <h2><?php echo __('Server properties') ?></h2> 

    </header>

    <section>
        <form id="ServerAddForm" method="post" action="./tservers/saveConfig">
        <input type="submit" class="button primary submit leftsubmit" name="save" style="top: -48px" value="<?php echo __('Save') ?>">
        <div class="col left">

            <section>
              <label for="title">
                <?php echo __('Server Name') ?>
              </label>
            
              <div>
                <input id="server-name" name="server-name" type="text" value="<?php echo $server_name ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Server ID') ?>
              </label>
            
              <div>
                <input id="server-id" name="server-id" type="text" value="<?php echo $server_id ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Level Name') ?>
              </label>
            
              <div>
                <input id="level-name" name="level-name" type="text" value="<?php echo $level_name ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Level Seed') ?>
              </label>
            
              <div>
                <input id="level-seed" name="level-seed" type="text" value="<?php echo $level_seed ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('MOTD') ?>
              </label>
            
              <div>
                <input id="motd" name="motd" type="text" value="<?php echo $motd ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Server port') ?>
              </label>
            
              <div>
                <input id="server-port" name="server-port" type="text" value="<?php echo $server_port ;?>"/>
              </div>
            </section>
          
             <section>
              <label for="title">
               <?php echo __(' Server IP') ?>
              </label>
            
              <div>
                <input id="server-ip" name="server-ip" type="text" value="<?php echo $server_ip ;?>"/>
              </div>
            </section>

             <section>
              <label for="title">
               <?php echo __('Maximum Players') ?>
              </label>
            
              <div>
                <input id="max-players" name="max-players" type="text" value="<?php echo $max_players ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('View Distance') ?>
              </label>
            
              <div>
                <input id="view-distance" name="view-distance" type="text" value="<?php echo $view_distance ;?>"/>
              </div>
            </section>
            </div>


            
            <div class="col right">
             <section>
              <label for="title">
                <?php echo __('Difficulty') ?>
              </label>
            
              <div>
              
                <select name="difficulty" id="difficulty">

                  <option value="0"<?php if ($difficulty == "0") {echo " selected";}?>><?php echo __('Peaceful') ?></option>
                  <option value="1"<?php if ($difficulty == "1") {echo " selected";}?>><?php echo __('Easy') ?></option>
                  <option value="2"<?php if ($difficulty == "2") {echo " selected";}?>><?php echo __('Normal') ?></option>
                  <option value="3"<?php if ($difficulty == "3") {echo " selected";}?>><?php echo __('Hard') ?></option>

                </select>   
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Gamemode') ?>
              </label>
            
              <div>
               <select name="gamemode" id="difficulty">

                  <option value="0"<?php if ($gamemode == "0") {echo " selected";}?>><?php echo __('Survival') ?></option>
                  <option value="1"<?php if ($gamemode == "1") {echo " selected";}?>><?php echo __('Creative') ?></option>

                </select>   
             </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Whitelist') ?>
              </label>
            
              <div>
                <input id="white-list" name="white-list" type="checkbox" value="true"  <?php if ($white_list == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Online Mode') ?>
              </label>
            
              <div>
                <input id="online-mode" name="online-mode" type="checkbox" value="true" <?php if ($online_mode == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Allow Flight') ?>
              </label>
            
              <div>
                <input id="allow-flight" name="allow-flight" type="checkbox" value="true"   <?php if ($allow_flight == "true") {echo " checked";}?>/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Allow Nether') ?>
              </label>
            
              <div>
                <input id="allow-nether" name="allow-nether" type="checkbox" value="true"   <?php if ($allow_nether == "true") {echo " checked";}?>/>
              </div>
            </section>

             <section>
              <label for="title">
                <?php echo __('Spawn Animals') ?>
              </label>
            
              <div>
                <input id="spawn-animals" name="spawn-animals" type="checkbox" value="true"   <?php if ($spawn_animals == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('PVP') ?>
              </label>
            
              <div>
                <input id="pvp" name="pvp" type="checkbox" value="true"   <?php if ($pvp == "true") {echo " checked";}?>/>
              </div>
            </section>

             <section>
              <label for="title">
                <?php echo __('Spawn Monsters') ?>
              </label>
            
              <div>
                <input id="spawn-monsters" name="spawn-monsters" type="checkbox" value="true"   <?php if ($spawn_monsters == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Enable Rcon') ?>
              </label>
            
              <div>
                <input id="enable-rcon" name="enable-rcon" type="checkbox" value="true" <?php if ($enable_rcon == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Enable Query') ?>
              </label>
            
              <div>
                <input id="enable-query" name="enable-query" type="checkbox" value="true" <?php if ($enable_query == "true") {echo " checked";}?>/>
              </div>
            </section>

        </div>
        </form>

        <div class="clear"></div>

    </section> 
                        
 </section>

</div>       <!-- End col right -->
<div class="clear"></div>

<div class="tab" id="tab3">
  <section class="box boxpad"> 
         
    <header>
        <h2><?php echo __('Add Schedule') ?></h2> 

    </header>

    <section>

      <form id="scheduler" class="scheduler" method="post" action="./tservers/addTask">
      <div class="error_box"></div>

      <div>

      <select name="timeType" id="timeType">

        <option value="1">Every X Hours</option>
        <option value="2">Every X Minutes</option>
        <option value="3">Once per day at</option>
        <option value="4">At X minutes after every hour</option>

      </select>   

      <input id="timeArgument1" name="timeArgument1" type="text" placeholder="hours" />
      <input id="timeArgument2" name="timeArgument2" style="display: none" type="text" placeholder="Minutes"/>

      <select name="type" id="type">

        <!-- <option value="1">Backup Worlds</option> -->
        <option value="2">Disable Whitelisting</option>
        <option value="3">Enable Whitelisting</option>
        <option value="4">Restart Server</option>
        <option value="5">Restart Server (if empty)</option>
        <option value="6">Save Worlds</option>
        <option value="7">Say something</option>
        <option value="8">Run Console Command</option>
        <option value="9">Start the server</option>
        <option value="10">Stop the server</option>

      </select> 

      <input id="arguments" name="arguments" type="text" style="display: none" placeholder="Arguments"/>

      <input type="submit" class="button primary submit big leftsubmit" value="<?php echo __('Add this schedule') ?>">
             
      </div>

      </form>

    </section> 
                        
 </section>

<div class="clear"></div>
<br /><br />
  <div class="table_container">

    <header>

      <h2><?php echo __('Schedules') ?></h2>


    </header>
<table class="datatable dtb1 notitle" id="schedules_table"> 
<thead> 
  <tr> 
    <th>ID</th>
    <th>Type</th>
    <th>Arguments</th>
    <th>Time type</th>
    <th>Time</th>
    <th>Actions</th>
  </tr> 
</thead> 

<tbody>

</tbody> 

</table>
</div>
</div>

<div class="clear"></div>
</section>
<!-- End #content --> 
<script>
$('document').ready(function() {

  //listen for change of select box
  $('#type').live("change", function() {

      var value = $(this).val();

      if (value=="7" || value=="8") 
        {
          $('#arguments').fadeIn(); 
        } 
      else
        {
          $('#arguments').fadeOut();        
        }

  });

  //listen for change of select box
  $('#timeType').live("change", function() {

      var value = $(this).val();

      if (value=="3") 
        {
          $('#timeArgument2').fadeIn(); 
        } 
      else
        {
          $('#timeArgument2').fadeOut();        
        }

      if (value=="1") 
        {
          $('#timeArgument1').attr('placeholder', 'hours');
        } 

      if (value=="2") 
        {
          $('#timeArgument1').attr('placeholder', 'minutes');
        } 

      if (value=="3") 
        {
          $('#timeArgument1').attr('placeholder', 'hour (24 format)');
        } 

      if (value=="4") 
        {
          $('#timeArgument1').attr('placeholder', 'minutes');
        } 


  });
        
  Table1 = $('.dtb1').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tservers/getTasks'
  });
     

  $(".confirmCB").click(function(event) {
    var r=confirm("Are you sure you want to install this CraftBukkit version?");
    if (r==true)
      {
      }
    else
      {
      event.preventDefault();
      }
  });

});

</script>