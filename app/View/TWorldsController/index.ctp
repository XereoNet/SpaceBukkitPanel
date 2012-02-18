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
        <li class="current bounce fadein"> <a href="./tworlds"> <span class="icon world"></span><?php echo __(' Worlds ') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['server']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./tservers"> <span class="icon server"></span><?php echo __(' Server ') ?></a> </li>
        <?php } ?>
        <?php if ($is_super == 1) { ?>
        <li class="bounce fadein floatright"> <a href="./tsettings"> <span class="icon settings"></span><?php echo __(' Settings ') ?></a> </li>
        <?php } ?>
	</ul>
</nav>
<!-- End Navigation --> 

<!-- Tabs -->
<nav id="smalltabs">
	<ul>
		<li class="current"><a href="#tab1"><?php echo __('Overview') ?></a></li>
		<li><a href="#tab2"><?php echo __('Map') ?></a></li>
		<li><a href="#tab3"><?php echo __('Chunkster') ?></a></li>
		<li><a href="#tab4"><?php echo __('MapAutoTrim') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

	<div class="tab" id="tab1">
		<p class="bukget_information"><?php echo __('Attention: some or more features may not be supported be your multiworld plugin! If your using MultiVerse please make sure your worlds are imported at first, otherwise loading won\'t work!'); ?></p>	

  <div class="table_container">

    <header>

      <h2><?php echo __('Worlds') ?></h2>

	<?php if($wmpl != 0){ ?>

	<a href="./tworlds/addWorld" id="add_world" class="button icon add fancy floatright" style="right: 250px"> <?php echo __('Add'); ?></a>

	<?php }else{ ?> 

	<a href="./tplugins" id="add_multiw" class="button icon arrowdown floatright" style="right: 250px"> <?php echo __('Install multiworld plugin'); ?></a>

	<?php } ?> 

	<a href="#" id="update_worlds" class="button icon reload floatright" style="right: 250px"><?php echo __('Refresh') ?></a>

    </header>		
		
  <table class="datatable adtb notitle">
    <thead> 
      <tr> 
        <th width="35px"><?php echo __('Active')?></th>
        <th><?php echo __('Name') ?></th> 
        <th width="140px"><?php echo __('Time') ?></th> 
        <th width="130px"><?php echo __('Animals') ?></th> 
        <th width="130px"><?php echo __('Hostiles') ?></th> 
        <th width="130px"><?php echo __('PVP') ?></th> 
        <th width="160px"><?php echo __('Difficulty') ?></th> 
        <th><?php echo __('Environment') ?></th> 
        <th><?php echo __('Actions') ?></th> 
      </tr> 
    </thead> 

    <tbody>
    </tbody> 

  </table> 
  </div>
		</div>
	<div class="clear"></div>

	<div class="tab" id="tab2">	

  <div class="table_container">

    <header>

      <h2><?php echo __('Map') ?></h2>
	
	</header>
	<section><center><p class="description">Coming soon to a SpaceBukkit enabled server near you!</p></center></section>
  </div>
		</div>
	<div class="clear"></div>

	<div class="tab" id="tab3">
		<div class="colorbox blue">
		    <h3><?php echo __('Chunkster') ?></h3> 
		    <p> 
	        <?php echo __('Use this utility if you are encountering chunk errors over and over in the error log and would like them repaired. This repairs an underlying issue of duplicate/bad pointers.
	        No responsibility is taken if worlds get corrupted/destroyed by this tool. A backup is reccomended first!<br />
	        <a href="http://forums.bukkit.org/threads/admin-chunkster.8186/">Bukkit Thread</a>') ?>
		    </p> 
		</div>
		<div class="clear"></div>

		<div class="col left">

		  <section class="box" id="autotrim"> 
		   
		    <header>
		        <h2><?php echo __('Parameters') ?></h2> 
		    </header>
		    
		    <section>
		    <form id="chunkster" method="post" action="./tworlds/chunkster">     
			    <section>
			      <label for="title">
			        <?php echo __('World'); ?>
			      </label>
			    
			      <div>
			        <select name="world">
			        <?php
			        foreach ($worlds as $world) {
			        	
			        	echo '<option value="'.$world.'">'.$world.'</option>';
			        }

			        ?>
			        </select>
			      </div>
			    </section>
		    	<input type="submit" id="chunkster" class="button big primary submit" value="<?php echo __('Run Chunkster'); ?>">

		    </form>
		  </section> 
		  </section> 
		<div class="clear"></div>

		</div>

		<div id="chunksterloader" class="col right" style="text-align: center; display: none;">
		<br />
		<br />
		<img src="img/big_loader.gif" /><br /><br />
		<div class="progress"><span id="chunkster_progress" style="width: 33%;"><b>1/3</b></span></div>	
		<span id="chunkster_message"><?php echo __('Notifying players of shutdown...') ?><span/>	

		<div class="clear"></div>

		</div>

		<div class="clear"></div>
				<br />

	<div class="clear"></div>
	</div>

	<div class="tab" id="tab4">

		<div class="colorbox blue">
		    <h3><?php echo __('MapAutoTrim') ?></h3> 
		    <p> 
	    	<?php echo __('Useful tool to migrate to another version of bukkit and getting new terrain features without sacrificing structures.
	        The aim is: delete as many old chunks as possible to be replaced by new chunks, while the chunks which contain structures remain.<br/>
	        <a href="http://forums.bukkit.org/threads/tool-admin-minecraft-map-auto-trim-v0-2.37846/">Bukkit Thread</a>') ?>
		    </p> 
		</div>
		<div class="clear"></div>

		<div class="col left">

		  <section class="box" id="autotrim"> 
		   
		    <header>
		        <h2><?php echo __('Parameters') ?></h2> 
		    </header>
		    
		    <section>
		    <form id="mapautotrim" method="post" action="./tworlds/mapautotrim">     
			    <section>
			      <label for="title">
			        <?php echo __('World') ?>
			      </label>
			    
			      <div>
			        <select name="world">
			        <?php
			        foreach ($worlds as $world) {
			        	
			        	echo '<option value="'.$world.'">'.$world.'</option>';
			        }

			        ?>
			        </select>
			      </div>
			    </section>
			    <section>
			      <label for="title">
			        <?php echo __('Dilatation Size') ?>
			        <small><?php echo __('Indicates the amount of chunks that should be preserved around a "positive" chunk.') ?></small>
			      </label>
			    
			      <div>
			        <input id="dilatation" name="dilatation" type="text"/>
			      </div>
			    </section>			    <section>
			      <label for="title">
			        <?php echo __('Preserved Block IDs') ?>
			        <small><?php echo __('Define your own preserve block id list. This is useful to design your own trim method. <a href="http://forums.bukkit.org/threads/tool-admin-minecraft-map-auto-trim-v0-2.37846/">Read here for default</a>') ?></small>
			      </label>
			    
			      <div>
			        <input id="blocks" name="blocks" type="text"/>
			      </div>
			    </section>
		    <input type="submit" id="mapautotrim" class="button big primary submit autotrim" value="<?php echo __('Run MapAutoTrim') ?>">

		    </form>
		  </section> 
		  </section> 
		<div class="clear"></div>

		</div>

		<div id="autotrimloader" class="col right" style="text-align: center; display: none;">
		<br />
		<br />
		<img src="img/big_loader.gif" /><br /><br />
		<div class="progress"><span id="autotrim_progress" style="width: 33%;"><b>1/3</b></span></div>	
		<span id="autotrim_message"><?php echo __('Notifying players of shutdown...') ?><span/>	

		<div class="clear"></div>

		</div>

		<div class="clear"></div>
				<br />
		<br />
	</div>

</section>
<!-- End #content --> 
<script>
$('document').ready(function() {
	  Table1 = $('.adtb').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tworlds/getWorlds'

  } );

  $('#update_worlds').click(function() {
    Table1.fnReloadAjax("./tworlds/getWorlds")
  });

  $(".backup").live('click', (function(){
  	
  	window.alert('Function will be available soon!');

  }));

  $(".remove").live('click', (function(){
  	
  	if(confirm("Are you sure you want to delete this world?!\nThis will restart the server...")){
  		// Create overlay and append to body:
    	showOverlay('Removing world and restarting server...');
    	
  		var source = $(this).attr("href");
  
		$.ajax({
  			url: source,
  			success: function(data) {
	     		notifications.show(data);
	      		Table1.fnReloadAjax("./tworlds/getWorlds")
	      		hideOverlay();
  			}
		
		});
  	}
  	return false;
  }));

  $(".ajax_table1").live('click', (function(){

  var source = $(this).attr("href");
  
$.ajax({
  url: source,
  success: function(data) {
      notifications.show(data);
      Table1.fnReloadAjax("./tworlds/getWorlds")

  }
});
      return false;

}));

$("#mapautotrim").submit(function() {
	$('.buttons').hide();
	$('.bounce').hide();
    $('input[type=submit]', this).attr('disabled', 'disabled').addClass("disable");
    $("#autotrimloader").fadeIn(2000);
	setTimeout( function() { 
	$('#autotrim_message').html('Shutting server down...');
	$('#autotrim_progress').animate({width: '66%'}, 1000).html('<b>2/3</b>');
	}, 10000 );
	setTimeout( function() { 
	$('#autotrim_message').html('Running MapAutoTrim...');
	$('#autotrim_progress').animate({width: '100%'}, 1000).html('<b>3/3</b>');
	}, 20000 );
});

$("#chunkster").submit(function() {
	$('.buttons').hide();
	$('.bounce').hide();
    $('input[type=submit]', this).attr('disabled', 'disabled').addClass("disable");
    $("#chunksterloader").fadeIn(2000);
	setTimeout( function() { 
	$('#chunkster_message').html('Shutting server down...');
	$('#chunkster_progress').animate({width: '66%'}, 1000).html('<b>2/3</b>');
	}, 10000 );
	setTimeout( function() { 
	$('#chunkster_message').html('Running Chunkster...');
	$('#chunkster_progress').animate({width: '100%'}, 1000).html('<b>3/3</b>');
	}, 20000 );
});

});
</script>