<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php echo __d('cake', '500 - An Internal Error Has Occurred.'); ?>
</p>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
?>
