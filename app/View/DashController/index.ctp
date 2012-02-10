
<!-- Navigation -->
<nav id="mainnav">
	<ul> 
        <?php if (($user_perm['pages'] & $glob_perm['pages']['dash']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="current bounce fadein"> <a href="./dash"> <span class="icon dashboard"></span><?php echo __(' Dashboard') ?></a> </li>
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
        <li class="bounce fadein"> <a href="./tservers"> <span class="icon server"></span><?php echo __(' Server ') ?></a> </li>
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
    <li class="current"><a href="#tab1"><?php echo __('Start') ?></a></li>
    <li><a href="#tab2"><?php echo __('Chat') ?></a></li>
  </ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content" class="dashboard_content"> 

<div class="tab" id="tab1">

<div id="server_presentation">
    <header>

        <table class="full" width="100%">
            <tbody>
            <tr style="width: 100px"><td><h3><?php echo $current_server_name; ?></h3></td></tr>

            <tr><td style="width: 300px; padding-bottom: 10px"><?php echo $motd; ?></td></tr>

            <tr><td><div id="user_percentage"></div></td></tr>

            <tr><td><div id="java_percentage"></div></td></tr>

            </tbody>
        </table>

    </header>

    <section>

        <div class="cell">
            <h4><?php echo __('Plugins') ?></h4>
            <div class="cell_data">
               <p><?php echo $plugin_count; ?> | <span class="greyed"><?php echo $dis_plugin_count; ?> </span></p>
               <p class="cell_medium">
               <b class="cell_left"><?php echo __('installed') ?></b>  
               <b class="cell_right greyed"><?php echo __('disabled') ?></b>
               </p>
            </div>
        </div>

        <div class="cell">
            <h4><?php echo __('Players') ?></h4>
            <div class="cell_data">
               <p><?php echo $whitelist_count; ?>  | <span class="greyed"><?php echo $ban_count; ?> </span></p>
               <p class="cell_medium">
               <b class="cell_left"><?php echo __('whitelist') ?></b>  
               <b class="cell_right greyed"><?php echo __('banned') ?></b>
               </p>
               <p><?php echo $max_players; ?></p>
               <p class="cell_medium">
               maximum
            </div>
        </div>

        <div class="cell">
            <h4><?php echo __('Worlds') ?></h4>
            <div class="cell_data worlds">
               <p class="normal_world rtip"><?php echo $worlds_count["normal"];?></p>  
               <div class="tooltip" >
                <?php echo __('Normal Worlds') ?>
               </div>            
               <p class="nether_world rtip"><?php echo $worlds_count["nether"];?></p>   
               <div class="tooltip" >
                <?php echo __('Nether Worlds') ?>
               </div>      
               <p class="skylands_world rtip"><?php echo $worlds_count["sky"];?></p>    
               <div class="tooltip" >
                <?php echo __('Skyland Worlds') ?>
               </div>      
               <p class="end_world rtip"><?php echo $worlds_count["end"];?></p>  
               <div class="tooltip" >
                <?php echo __('End Worlds') ?>
               </div>      
               </div>
        </div>

        <div class="cell">
            <h4><?php echo __('Staff') ?></h4>
            <div class="cell_data">
               <p><?php echo $connected_users; ?></span></p>
               <p class="cell_medium"><?php echo __('members connected with this server') ?></p>
            </div>
        </div>

        <div class="cell">
            <h4><?php echo __('CraftBukkit') ?></h4>
            <div class="cell_data">
               <p><?php echo $c_bukkit_version; ?></p>
               <?php

               // echo $m_bukkit_version; 

               ?>
                              
            </div>
        </div>   
    </section>
    

</div>

<div class="clear"></div>
<div class="col left">
<section class="box boxpad"> 
 
        <header>
            <h2><?php echo __('Activity Feed (latest on top)') ?></h2> 
        </header>
        
       <section>
        <div id="log">

        </div>         
        
    	</section> 
                        
 </section>

</div>   <!-- End col left --> 
<div class="col right">

<section class="box boxpad"> 
 
    <header>
        <h2><?php echo __('Admins online') ?></h2> 
    </header>

    <section>

    //work in progress
      
    </section> 
                        
 </section>

</div>       <!-- End col right -->
<div class="clear"></div>
</div>


  <div class="tab" id="tab2">

  <section class="chat">

    <div class="col left chatleft">
      <div class="chatwindow">
        <table class="zebra-striped chat_table">
          <tbody class="chat_chat">                      
          </tbody>
        </table>
      </div>
      <div class="chatinput">
      <form id="saysomething" class="saysomething" method="post" action="./dash/saysomething">
      <div>
      <input id="say" name="say" type="textarea" class="chatarea" rows="6" cols="20"/>
      <input type="submit" class="button primary submit" value="<?php echo __('Say it') ?>">
      </div>
      </form>
      </div>
      <div class="clear"></div>

    </div>

    <div class="col right chatright ">
        <table class="zebra-striped chat_table">
          <tbody class="chat_list">  
            <tr>
            </tr>                    
          </tbody>
        </table>
    </div>

    <div class="clear"></div> 

  </section>
 
   </div>
</section>
         	
<!-- End #content -->
    <script>

$(document).ready(function() {
  
  /* attach a submit handler to the form */
  $(".saysomething").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $(this),
        term = $form.find( 'input[name="say"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post(url, {say: term},
      function( data ) {
         notifications.show(data);
      }
    );
    $(".chatarea").val('');

  });

  doAndRefresh('#user_percentage', './dash/calculate_players', 3000);
  doAndRefresh('#java_percentage', './dash/calculate_java', 3000);
  doAndRefresh('.chat_list', './dash/get_chat_players', 10000);
  doAndRefreshChat('.chat_chat', './dash/get_chat_new', 3000);
  doAndRefresh('#log', './dash/get_log', 15000);

    });
</script> 