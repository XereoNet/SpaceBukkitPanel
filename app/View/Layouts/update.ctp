<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_for_layout?> | SpaceBukkit by XereoNet | Bukkit Web Administration</title>

<!-- CSS -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/import.css" /> 

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Load theme -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>themes/<?php echo $current_theme?>/css/theme.css" /> 

<!-- Load Jquery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<?php echo $this->Html->css('cake.generic'); ?>
</head>

<body>

	<div id="header">
		<div id="container" class="login"> 
			
			<!-- Logo -->
			<div class="hheight"> 

				<!-- Logo -->
				<div class="col left col_1_3">
				<h1 id="logo">SpaceBukkit</h1>
				</div>
				
			</div>
			<!-- Main Content Start -->
			<div id="wrapper" class="update_bukkit"> 
			
			<?php echo $content_for_layout ?>
				
			</div>
			<!-- End #wrapper --> 
			
		</div>
		<!-- End #container --> 

	<!-- Import JS -->
	<script src="<?php echo $this->webroot; ?>js/compiled.js"></script> 
	<script src="http://tab-slide-out.googlecode.com/files/jquery.tabSlideOut.v1.3.js"></script>

	<script>
	var notifications = $('body').ttwSimpleNotifications({
    position:'bottom right',
    autoHide:true,
    autoHideDelay:7000,
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
	  });

$(document).ready(function() {

  doAndRefresh('#console','./global/getConsole', 5000);
  doAndRefresh('#serverlist','./global/getServers', 5000);

    
});
</script>
<?php 
$gototab = $this->Session->flash("tab");
if ($gototab > "1") {
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

	</body>
</html>
