
<!-- Load Bukget Stylesheet -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/bukget.css"/>
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/import.css"/>

<!-- Main Content Start -->
<div id="wrapper" class="bukget"> 
	
	<div class="bukget-header">
		<div class="col left">
			Logo
		</div>
		<div class="col right">
			Search
		</div>
	</div>
	<?php echo $content_for_layout ?>
		
</div>
<!-- End #wrapper --> 

<!-- Load Bukget Javascript files -->
<script src="<?php echo $this->webroot; ?>js/jquery.listnav.js"></script> 
<script src="<?php echo $this->webroot; ?>js/bukget.js"></script> 
