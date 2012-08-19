
<!-- Tabs -->
<nav id="smalltabs">
	<ul>
		<li class="current"><a href="#tab1"><?php echo __('Overview') ?></a></li>
		<li><a href="#tab2"><?php echo __('Map') ?></a></li>
		<li><a href="#tab4"><?php echo __('MapAutoTrim') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

	<div class="tab" id="tab1">


	<div class="alert alert-info">
	<p><?php echo __('Attention: some or more features may not be supported be your multiworld plugin! If your using MultiVerse please make sure your worlds are imported at first, otherwise loading won\'t work!'); ?></p>
	</div>

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
	<section>
		<div><?php if ($dynmap) { ?>
			<iframe src="<?php echo $dynmapurl; ?>" style="width: 100%; height: 100%; min-height: 810px"></iframe>
			<?php } else { ?>
			<div class="alert alert-info"> 
	        <?php echo __('Dynmap not found!').' Please install it!' ?>
		    </div> 
		    <?php } ?>
		</div>
	</section>
  </div>
		</div>
	<div class="clear"></div>

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
			<p></p>
			<br />
			<br />		

			<div class="progress-new progress-striped active">
			  <div class="bar" id="autotrim_progress"></div>
			</div>

			<div class="colorbox blue">
			<span id="autotrim_message"><?php echo __('Notifying players of shutdown...') ?><span/>	
			</div>

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

  $(".remove").live('click', (function(){
  	
  	if(confirm("Are you sure you want to delete this world?!\nThis will restart the server...")){
  		// Create overlay and append to body:
    	showOverlay('Removing world and restarting server...');
    	
  		var source = $(this).attr("href");
  
		$.ajax({
  			url: source,
  			success: function(data) {
	     		notifications.show({msg:data, icon:'img/win.png'});
	      		Table1.fnReloadAjax("./tworlds/getWorlds")
	      		hideOverlay();
  			}
		
		});
  	}
  	return false;
  }));

	$("#autotrim").submit(function() {
		$('.buttons').hide();
		$('.bounce').hide();
	    $('input[type=submit]', this).attr('disabled', 'disabled').addClass("disable");
	    $("#autotrimloader").fadeIn(2000);
		$('#autotrim_progress').animate({width: '33%'}, 1000);    
	    $("#autotrimloader p").activity({'color' : 'white'});
		setTimeout( function() { 
		$('#autotrim_message').html('Shutting server down...');
		$('#autotrim_progress').animate({width: '66%'}, 1000);
		}, 10000 );
		setTimeout( function() { 
		$('#autotrim_message').html('Running autotrim...');
		$('#autotrim_progress').animate({width: '100%'}, 1000);
		}, 20000 );
	});

	$("#chunkster").submit(function() {
		$('.buttons').hide();
		$('.bounce').hide();
	    $('input[type=submit]', this).attr('disabled', 'disabled').addClass("disable");
	    $("#chunksterloader").fadeIn(2000);
		$('#chunkster_progress').animate({width: '33%'}, 1000);    
	    $("#chunksterloader p").activity({'color' : 'white'});
		setTimeout( function() { 
		$('#chunkster_message').html('Shutting server down...');
		$('#chunkster_progress').animate({width: '66%'}, 1000);
		}, 10000 );
		setTimeout( function() { 
		$('#chunkster_message').html('Running Chunkster...');
		$('#chunkster_progress').animate({width: '100%'}, 1000);
		}, 20000 );
	});

});
</script>