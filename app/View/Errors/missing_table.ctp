
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Database table %1$s for model %2$s was not found.', '<em>' . $table . '</em>',  '<em>' . $class . '</em>'); ?>
</p>

<?php echo $this->element('exception_stack_trace'); ?>
