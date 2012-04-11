<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/timeline.css" />

<!-- Tabs -->
<nav id="smalltabs">
	<ul>
	<li class="current"><a href="#tab1"><?php echo __('Server Events') ?></a></li>
    <li><a href="#tab2"><?php echo __('Game Events') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content" style="min-height: 600px"> 

  <div class="tab" id="tab1">

		<div id="timeline">
			<!-- Timeline will generate additional markup here -->
		</div>

        <div class="clear"></div>

   </div>
   <!-- End tab1 -->

</section>
<!-- End #content --> 
<br>
<br>
<br>
<div class="clear"></div>

<script src="<?php echo $this->webroot; ?>js/timeline-min.js"></script> 

<script>

$(function(){
	
	var timeline = new VMM.Timeline();
	timeline.init("<?php echo $this->webroot; ?>data.json");

});

</script>

