<div class="col left col_2_3 bukget-area">
	<div class="binder">
		<div class="slider">

			<div id="<?php echo $string; ?>" class="additional-block">
				<div class="bukget-heading">
					<a href="./bukget2" class="fancy bu-ba-bu"> <?php echo $this->Html->image('prev.png')?> </a>
					<h3>
					Search results for: <?php echo $string; ?>
					</h3>
				</div>
				<ul class="menu" id="<?php echo $string; ?>_menu">
					<?php echo $output; ?>
				</ul>
			</div>

		</div>
	</div>
</div>

<div class="col right col_1_3 bukget-area2 secure">

	<div class="bukget-heading">
		<h3>
			Click for details
		</h3>
	</div>
	<div class="bukget-list">

	<ul>
	
	</ul>
	</div>
</div>