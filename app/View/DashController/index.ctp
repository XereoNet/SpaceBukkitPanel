<!-- Content -->
<section id="content" class="dashboard_content"> 

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
                echo $m_bukkit_version; 
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

</section>
         	
<!-- End #content -->
    <script>

$(document).ready(function() {
  
  doAndRefresh('#user_percentage', './dash/calculate_players', 3000);
  doAndRefresh('#java_percentage', './dash/calculate_java', 3000);
  doAndRefresh('#log', './dash/get_log', 15000);

    });
</script> 