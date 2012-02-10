<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', '%s requires a database connection', $class); ?>
</p>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Confirm you have created the file : %s.', APP_DIR . DS . 'Config' . DS . 'database.php'); ?>
</p>

<?php echo $this->element('exception_stack_trace'); ?>
