<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_for_layout?> | SpaceBukkit by XereoNet | Bukkit Web Administration</title>


<?php echo $this->element('css'); ?>

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if lte IE 6]>

<meta HTTP-EQUIV="REFRESH" content="0; url=http://www.ie6countdown.com/">

<![endif]-->

<noscript><h1>Please enabled Javascript!</h1></noscript>

<!-- Load Jquery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/script.js"></script> 
<script src="<?php echo $this->webroot; ?>js/selectivizr.min.js"></script> 

</head>

<body>

<div class="screen_overlay">
	<div class="overlay-text">
	</div>
	<p>
	</p>
</div>

</div>

	<div id="header">
		<div id="container"> 
		
			<div id="sidebar-widget" class="widget-reset" style="display: none; ">
			<?php if (perm('global', 'console', $user_perm)): ?>

				<a href="#" class="sidebar-button console-button" rel="nofollow">console</a>
				<div id="sidebar-console-wrap" class="sidebar-wrap">
					<div id="sidebar-console">

						<div class="console-meta">
							<h4>Console</h4>
						    <p>(Latest on top)</p>

							<form id="runcommand" class="runcommand" method="post" action="./global/runcommand">
						        <input class="commandarea" id="command" name="command" type="text" placeholder="<?php echo __('Enter Command'); ?>"/>
						    	<input type="submit" class="button primary submit hidden" value="<?php echo __('Submit'); ?>">
						    </form>

							<section>
							<p><?php echo __('Server running since'); ?></p>
							<pre id="server-uptime"></pre>

							<div class="console-controls splitter">
								<ul>
									<li class="segment-1 selected-1"><a href="#" rel="all"><?php echo __('Everything'); ?></a></li>
									<li class="segment-0"><a href="#" rel="info"><?php echo __('Info'); ?></a></li>
									<li class="segment-0"><a href="#" rel="warning"><?php echo __('Warning'); ?></a></li>
									<li class="segment-2"><a href="#" rel="severe"><?php echo __('Severe'); ?></a></li>
								</ul>
							</div>

							</section>
						</div>

						<div id="console-list" rel="all">
							<ul>
							</ul>
						</div>

					</div>
					<span class="switcher-arrow"></span>
				</div>

<?php endif; ?>
<?php if (perm('global', 'chat', $user_perm)): ?>

				<a href="#" class="sidebar-button chat-button" rel="nofollow"><?php echo __('chat'); ?></a>
				<div id="sidebar-chat-wrap" class="sidebar-wrap">
					<div id="sidebar-chat">

						<div class="console-meta">

							<h4><?php echo __('Chat'); ?></h4>
						    <p>(<?php echo __('Latest on top'); ?>)</p>							
					        <form id="saysomething" class="saysomething" method="post" action="./dash/saysomething">
						        <input id="say" name="say" type="text" class="chatarea" />
						        <input type="submit" class="button primary hidden submit" value="<?php echo __('Say it') ?>">
					        </form>			
					        				
						</div>
												
						<section class="chat">
						    <div class="col left chatleft">
						      <div class="chatwindow">
						        <table class="zebra-striped chat_table">
						          <tbody class="chat_chat">                      
						          </tbody>
						        </table>
						      </div>

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
					<span class="switcher-arrow"></span>
				</div>				
<?php endif; ?>

			</div>

			<!-- Logo -->
			<div class="hheight"> 

				<!-- Logo -->
				<h1 id="logo">SpaceBukkit</h1>
				<!-- Upper Bar -->
				<div id="upperbar" class="col right">
					<div id="serverbox">
						<span class="dropdown_servers tip"><p><a href="#"><?php echo $current_server_name; ?></a></p></span>
						<div class="tooltip server_add_to_list" style="max-width: 190px">
							<ul>
									<?php 

					//get all servers and display them nicely :)

					if ($is_super == 1) {

					//if superuser
					
					foreach ($all_servers as $list) {

						$title = $list['Server']['title'];
						$id = $list['Server']['id'];

								echo <<<END
									<li><a href="./global/setserver/$id">$title</a></li>
END;
					}
										
					} else {

					//if not superuser
					
					foreach ($user_data['AllowedServers'] as $sid => $list) {

						$title = $list['Server']['title'];
						$id = $list['Server']['id'];

								echo <<<END
									<li><a href="./global/setserver/$id">$title</a></li>
END;
					}
 }


								?>	
							</ul>
						</div>

					</div>
					
					<!-- Start/Stop, Reload, Message, Logout -->

					<div id="serverbuttons"> 

						<?php if (perm('global', 'stopStartServer', $user_perm)): ?>
						<a href="./global/stop" id="stop" class="bounce tip showOverlay" rel="<?php echo __('Stopping server'); ?>..."></a> 
							<div class="tooltip"><?php echo __('Stop server'); ?></div>		
						<?php endif; ?>

						<?php if (perm('global', 'reloadServer', $user_perm)): ?>						
						<a href="./global/reload" id="reload" class="bounce tip showOverlay reload" rel="<?php echo __('Reloading server'); ?>..."></a> 
							<div class="tooltip"><?php echo __('Reload server'); ?></div>
						<?php endif; ?>
						<?php if (perm('global', 'restartServer', $user_perm)): ?>						

						<a href="./global/restart" id="restart" class="bounce tip showOverlay restart" rel="<?php echo __('Restarting server'); ?>..."></a> 
							<div class="tooltip"><?php echo __('Restart server'); ?></div>
						<?php endif; ?>
						<?php if (perm('global', 'forceRestartServer', $user_perm)): ?>						

						<a href="./global/frestart" id="frestart" class="bounce tip showOverlay frestart" rel="<?php echo __('Force-Restarting server'); ?>..."></a> 

							<div class="tooltip"><?php echo __('Force-Restart server'); ?></div>													
						<?php endif; ?>
							
					</div>
					<div id="userbuttons">
						
						<span><a href="#" class="account tip"><?php echo $username; ?> </a></span>
						<div class="tooltip">
							<ul>
								<li><a href="./users/edit/<?php echo $current_user_id; ?>" class="fancy"><?php echo __('Account Settings'); ?></a></li>
								<li><a href="./users/theme" class="fancy"><?php echo __('SpaceBukkit Theme'); ?></a></li>
								<li><a href="./users/logout"><?php echo __('Logout'); ?></a></li>
							</ul>
						</div>
											
					</div>
				</div>
			</div>


			<!-- Main Content Start -->
			<div id="wrapper"> 

			<?php if((isset($spacebukkitbuildready)) && ($user_perm['is_super'] == 1)) {?>
			<div class="top-message slideDown">
			<p><?php echo __('A new SpaceBukkit version has been released! Your version is').' '; ?> <strong><?php echo $spacebukkitbuildcurrent; ?></strong> <?php echo __('while the new version is'); ?> <strong><?php echo $spacebukkitbuildnew.__(' Click the button on the right to start the upgrade.'); ?></strong>
				<a class="top-message-button" href="<?php echo $spacebukkitbuildfile; ?>"></a></p>
			</div>
			<?php };?>

			<?php if(isset($antmessage)) {?>
			<div class="top-message <?php echo $antmessagetype; ?> slideDown">
			<p><?php echo $antmessage; ?></p>
			</div>
			<?php };?>

			<!-- Navigation -->
			<nav id="mainnav">
				<ul> 
					<?php if (perm('pages', 'dash', $user_perm)): ?>
			        <li class="<?php if ($this->name == "DashController") { echo "current" ; }  ?> fadein"> 

			        	<a href="<?php echo $this->Html->url('/dash', true); ?>"> <span class="icon dashboard"></span><?php echo ' '.__('Dashboard').' ' ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'users', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TPlayersController") { echo "current" ; }  ?> fadein"> 
			        	<a href="<?php echo $this->Html->url('/tplayers', true); ?>"> <span class="icon users"></span><?php echo ' '.__('Players').' ' ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'plugins', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TPluginsController") { echo "current" ; }  ?> fadein"> 
			        	<a href="<?php echo $this->Html->url('/tplugins', true); ?>"> <span class="icon plugins"></span><?php echo ' '.__('Plugins').' ' ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'worlds', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TWorldsController") { echo "current" ; }  ?> fadein"> 
			        	<a href="<?php echo $this->Html->url('/tworlds', true); ?>"> <span class="icon world"></span><?php echo ' '.__('Worlds').' ' ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'servers', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TServersController") { echo "current" ; }  ?> fadein"> 
			        	<a href="<?php echo $this->Html->url('/tservers', true); ?>"> <span class="icon server"></span><?php echo ' '.__('Server').' ' ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'backups', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TBackupsController") { echo "current" ; }  ?> fadein"> 
			        	<a href="<?php echo $this->Html->url('/tbackups', true); ?>"> <span class="icon backups"></span><?php echo ' '.__('Backups').' ' ?></a> 
			        </li>
			        <?php endif; ?>
			        <?php if ($is_super == 1) { ?>
			        <li class="<?php if ($this->name == "Tsettings") { echo "current" ; }  ?> fadein floatright"> 
			        	<a href="<?php echo $this->Html->url('/tsettings', true); ?>"> <span class="icon settings"></span><?php echo ' '.__('Settings').' ' ?></a> 
			        </li>
			        <?php } ?>
				</ul>
			</nav>
			<!-- End Navigation --> 
			
			<?php echo $content_for_layout ?>
			<div class="pushfooter"></div>

			</div>
			<!-- End #wrapper --> 

			<?php echo $this->element('footer'); ?>

		</div>
		<!-- End #container --> 

	<!-- Import JS -->
	<?php echo $this->element('js'); ?>
	
	<!--[if IE 6]>
		<script type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.nyroModal-ie6.min.js"></script>
	<![endif]-->
	<script>
	var notifications = $('body').ttwSimpleNotifications({
    position:'bottom right',
    autoHide:true,
    autoHideDelay:7000,
	});


$(document).ready(function() {


	var console_wrapper = $('#console-list');

	function loadConsole() {

		if ($('.console-button').hasClass('active')) {

		var console_param = $(console_wrapper).attr("rel");
		var console_url = './global/getConsole/'+console_param;	 
			
		$.ajax({

			  url: console_url,
			  cache: false,
			  success: function(data){
			  	if (console_wrapper.hasClass("console-loading"))
			  	{
			  		$(this).removeClass("console-loading");

						setTimeout(function() {
						    loadConsole()
						  }, 1000);

			  	}
			  	else
			  	{
			  		$(console_wrapper).html(data);

						setTimeout(function() {
						    loadConsole()
						  }, 1000);
			  	}

			  }});

		}
		else 
		{
		setTimeout(function() {
		    loadConsole()
		  }, 1000);
		}
	} 


	loadConsole();
	doAndRefresh('#server-uptime', './global/getUpTime', '<?php echo $this->Session->read("Sbvars.0"); ?>');
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
        
      }
    );
    $(".chatarea").val('');

  });

  /* attach a submit handler to the form */
  $(".runcommand").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $(this),
        term = $form.find( 'input[name="command"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post(url, {command: term},
      function( data ) {
      	message = data;
        notifications.show({msg:data, icon:'img/win.png'});
      }
    );
		$('.commandarea').val('');

  }); 

  doAndRefreshChat('.chat_chat', './dash/get_chat_new', '<?php echo $this->Session->read("Sbvars.2"); ?>');

  doAndRefreshChat('.chat_list', './dash/get_chat_players', '<?php echo $this->Session->read("Sbvars.2"); ?>');

});

</script>
<?php 
if ($gototab > 1) {
?>
<script>
$(document).ready(function() {

$(function () {

$('nav#smalltabs ul li:nth-child(<?php echo $gototab ?>) a').trigger('click');

});

});
</script>

<?php 
}
?>       
<?php 
if (isset($doodle)) {
?>
<script>
$(document).ready(function() {
var doodle = "url(<?php echo $doodle; ?>)";
$("#logo").css("background-image", doodle);  

});
</script>

<?php 
}
?>

	</body>
</html>
