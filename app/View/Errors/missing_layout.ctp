<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'The layout file %s can not be found or does not exist.', '<em>' . $file . '</em>'); ?>
</p>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Confirm you have created the file: %s', '<em>' . $file . '</em>'); ?>
</p>
<?php echo $this->element('exception_stack_trace'); ?>
