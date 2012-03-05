<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_for_layout?> | SpaceBukkit by XereoNet | Bukkit Web Administration</title>

<!-- CSS -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/import.css" /> 
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/overcast/jquery-ui-1.8.18.custom.css" /> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if lte IE 6]>

<meta HTTP-EQUIV="REFRESH" content="0; url=http://www.ie6countdown.com/">

<![endif]-->

<noscript><h1>Please enabled Javascript!</h1></noscript>


<!-- Load theme -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>themes/<?php echo $current_theme?>/css/theme.css" /> 
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/nyroModal.css" type="text/css" media="screen" />

<!-- Load Jquery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/script.js"></script> 
<script src="<?php echo $this->webroot; ?>js/selectivizr.min.js"></script> 

</head>

<body>
<div class="screen_overlay">
 <div></div>
</div>
<?php if((isset($spacebukkitbuildready)) && ($user_perm['is_super'] == 1)) {?>
<div class="top_message black slideDown">
<p><?php echo __('A new SpaceBukkit update is ready for you to download! Your version is'); ?> <strong><?php echo $spacebukkitbuildcurrent; ?></strong> <?php echo __('while the new version is'); ?> <strong><?php echo $spacebukkitbuildnew; ?></strong> &nbsp; &nbsp;  <a class="button icon arrowright" href="<?php echo $spacebukkitbuildfile; ?>"><?php echo __('Click here to get it'); ?></a></p>
</div>
<?php };?>

<?php if(isset($antmessage)) {?>
<div class="top_message <?php echo $antmessagetype; ?> slideDown">
<p><?php echo $antmessage; ?></p>
</div>
<?php };?>

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
							<p>Server running since</p>
							<pre id="server-uptime">122 h 12m</pre>

							<div class="console-controls splitter">
								<ul>
									<li class="segment-1 selected-1"><a href="#" rel="all">Everything</a></li>
									<li class="segment-0"><a href="#" rel="info">Info</a></li>
									<li class="segment-0"><a href="#" rel="warning">Warning</a></li>
									<li class="segment-2"><a href="#" rel="severe">Severe</a></li>
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

				<a href="#" class="sidebar-button chat-button" rel="nofollow">chat</a>
				<div id="sidebar-chat-wrap" class="sidebar-wrap">
					<div id="sidebar-chat">

						<div class="console-meta">
							<h4>Chat</h4>
						    <p>(Latest on top)</p>							
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
				<div class="col left col_1_3">
				<h1 id="logo">SpaceBukkit</h1>
				</div>
				<!-- Upper Bar -->
				<div id="upperbar" class="col right">
					<div id="serverbox">
						<span class="dropdown_servers tip"><p><a href="#"><?php echo $current_server_name; ?></a></p></span>
						<div class="tooltip white server_add_to_list" style="max-width: 190px">
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
						<a href="./global/stop" id="stop" class="bounce tip showOverlay" rel="Stopping server..."></a> 
							<div class="tooltip"><?php echo __('Stop server'); ?></div>											
						<a href="./global/reload" id="reload" class="bounce tip showOverlay reload" rel="Reloading server..."></a> 
							<div class="tooltip"><?php echo __('Reload server'); ?></div>
						<a href="./global/restart" id="restart" class="bounce tip showOverlay restart" rel="Restarting server..."></a> 
							<div class="tooltip"><?php echo __('Restart server'); ?></div>
						<a href="./global/frestart" id="frestart" class="bounce tip showOverlay frestart" rel="Force-Restarting server..."></a> 
							<div class="tooltip"><?php echo __('Force-Restart server'); ?></div>													
					</div>
					<div id="userbuttons">
						
						<span><a href="#" class="account tip"><?php echo __('Welcome aboard'); ?>, <?php echo $username; ?> </a></span>
						<div class="tooltip white">
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

			<!-- Navigation -->
			<nav id="mainnav">
				<ul> 
					<?php if (perm('pages', 'dash', $user_perm)): ?>
			        <li class="<?php if ($this->name == "DashController") { echo "current" ; }  ?> bounce fadein"> 

			        	<a href="<?php echo $this->Html->url('/dash', true); ?>"> <span class="icon dashboard"></span><?php echo __(' Dashboard') ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'users', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TPlayersController") { echo "current" ; }  ?> bounce fadein"> 
			        	<a href="<?php echo $this->Html->url('/tplayers', true); ?>"> <span class="icon users"></span><?php echo __(' Players ') ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'plugins', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TPluginsController") { echo "current" ; }  ?> bounce fadein"> 
			        	<a href="<?php echo $this->Html->url('/tplugins', true); ?>"> <span class="icon plugins"></span><?php echo __(' Plugins ') ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'worlds', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TWorldsController") { echo "current" ; }  ?> bounce fadein"> 
			        	<a href="<?php echo $this->Html->url('/tworlds', true); ?>"> <span class="icon world"></span><?php echo __(' Worlds ') ?></a> 
			        </li>
			        <?php endif; ?>
					<?php if (perm('pages', 'servers', $user_perm)): ?>
			        <li class="<?php if ($this->name == "TServersController") { echo "current" ; }  ?> bounce fadein"> 
			        	<a href="<?php echo $this->Html->url('/tservers', true); ?>"> <span class="icon server"></span><?php echo __(' Server ') ?></a> 
			        </li>
			        <?php endif; ?>
			        <?php if ($is_super == 1) { ?>
			        <li class="<?php if ($this->name == "Tsettings") { echo "current" ; }  ?> bounce fadein floatright"> 
			        	<a href="<?php echo $this->Html->url('/tsettings', true); ?>"> <span class="icon settings"></span><?php echo __(' Settings ') ?></a> 
			        </li>
			        <?php } ?>
				</ul>
			</nav>
			<!-- End Navigation --> 
			
			<?php echo $content_for_layout ?>
			<div class="pushfooter"></div>

			</div>
			<!-- End #wrapper --> 

			<div id="footer">

				<div class="col left">

				<?php echo __('SpaceBukkit version'); ?> <?php echo $spacebukkitbuildcurrent; ?> <?php echo __('proudly presented by the SpaceBukkit Team :)'); ?>

				</div>

				<div class="col right">

				<ul>
					<li><a href="http://spacebukkit.xereo.net" alt="SpaceBukkit Home"><?php echo __('Home'); ?></a></li>
					<li><a href="http://spacebukkit.xereo.net/wiki" alt="SpaceBukkit Home"><?php echo __('Wiki'); ?></a></li>
					<li><a href="http://spacebukkit.xereo.net/forum" alt="SpaceBukkit Home"><?php echo __('Forums'); ?></a></li>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="display: inline-block; position: relative; top: 10px;">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="ZW8KTNTJLRGGY">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
					</form>

				</ul>

				</div>

			</div>
			<!-- End #footer --> 

		</div>
		<!-- End #container --> 

	<!-- Import JS -->

	<script src="<?php echo $this->webroot; ?>js/jquery-ui-1.8.18.custom.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/ttw-simple-notifications-min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/excanvas.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.uniform.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.validate.min.js"></script> 
	<script src="http://tab-slide-out.googlecode.com/files/jquery.tabSlideOut.v1.3.js"></script>
	<script src="<?php echo $this->webroot; ?>js/jquery.livesearch.js"></script>
	<script src="<?php echo $this->webroot; ?>js/jquery.visualize.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.datatables.js"></script>
	<script src="<?php echo $this->webroot; ?>js/reload_dtb.js"></script>
	<script src="<?php echo $this->webroot; ?>js/ajax.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.placeholder.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.tools.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.nyroModal.custom.js"></script>
	<script src="<?php echo $this->webroot; ?>js/jquery.listnav.js"></script>
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
	doAndRefresh('#server-uptime', './global/getUpTime', 3000);
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

  doAndRefreshChat('.chat_list', './dash/get_chat_players', 10000);
  doAndRefreshChat('.chat_chat', './dash/get_chat_new', 1000);

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
