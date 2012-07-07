
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
	search 				= $('.bukget-search-container');
	detsource1			= "./bukget2/getLatest";
	detsource2			= "./bukget2/getHeading/";
	detsource3			= "./bukget2/getDetails/";
	ajax_load 			= '<div class="preloader"><div><img src="./img/big_loader.gif" /></div></div>'; 

	//script for details etc.

	$('li.plugin').live("click", function() {
		
		detheading			= $('.bukget-area2.secure div.bukget-heading');
		detcontent			= $('.bukget-area2.secure div.bukget-list');

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

	$('#se_all > form').submit(function(event) {

		event.preventDefault();
 		var arg = $('#se_all input').val();
		search.spin().load("./bukget2/search/"+arg);

	});
	
});
</script> 

<!-- Main Content Start -->
<div id="wrapper" class="bukget"> 
	<div class="bukget-wrapper">
		<div class="bukget-header">
			<div class="col left">
				<h1>Bukget 2.0</h1>
			</div>
			<div class="col right" id="se_all">
				<form action="#">
					<input type="text" name="string" placeholder="Search for plugin...">
				</form>
			</div>
		</div>

		<div class="bukget-search-container">

		</div>

		<div class="bukget-content">
			<?php echo $content_for_layout ?>
		</div>
	</div>
</div>
<!-- End #wrapper --> 

<!-- Load Bukget Javascript files -->
