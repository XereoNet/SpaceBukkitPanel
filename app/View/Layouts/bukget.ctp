
<!-- Load Bukget Stylesheet -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/bukget.css"/>

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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/bukget.js"></script> 
