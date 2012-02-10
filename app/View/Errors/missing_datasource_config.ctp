
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'The datasource configuration %1$s was not found in database.php.', '<em>' . $config . '</em>'); ?>
</p>


<?php echo $this->element('exception_stack_trace'); ?>
