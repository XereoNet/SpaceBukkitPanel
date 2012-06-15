
<!-- Load Bukget Stylesheet -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/bukget.css"/>
<script>
$("document").ready(function() {

	/*

	*	Sliding lists

	*/

	defaultWidth		= 650; //pixels
	transition			= 500; //millisecond
	det    				= $('.bukget-area2');
	detheading			= $('.bukget-area2 div.bukget-heading');
	detcontent			= $('.bukget-area2 div.bukget-list');
	detsource1			= "./bukget2/getLatest";
	detsource2			= "./bukget2/getHeading/";
	detsource3			= "./bukget2/getDetails/";
	ajax_load 			= '<div class="preloader"><div><img src="./img/big_loader.gif" /></div></div>'; 

	//script for details etc.

	$('li.plugin').live("click", function() {
		
		$('li.plugin.selected').removeClass('selected');
		var link = $(this).find('h4').html();
		$(detheading).load(detsource2+link);
		$(detcontent).html(ajax_load).load(detsource3+link);
		$(this).addClass('selected');

	});

	$(".installer").live('click', (function(){

	  var source = $(this).attr("href");
	  var btn = $(this);


	  $(this).addClass("disable");
	  $.ajax({
	    url: source,
	    success: function(data) {
	        $(btn).removeClass("disable button favorite").addClass("nobutton approve").text("Installed! Reload or Restart to load it.");
	    }
	  });
	  return false;

	}));
	
});
</script> 

<!-- Main Content Start -->
<div id="wrapper" class="bukget"> 
	<div class="bukget-wrapper">
		<div class="bukget-header">
			<div class="col left">
				<h1>Bukget 2.0</h1>
			</div>
			<div class="col right">
				<form>
				<input id="se_all" name="se_all" type="text" style="display: block;" placeholder="Search plugins...">
				</form>
			</div>
		</div>

		<div class="bukget-content">
			<?php echo $content_for_layout ?>
		</div>
	</div>
</div>
<!-- End #wrapper --> 

<!-- Load Bukget Javascript files -->
