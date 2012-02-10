<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'The view for %1$s%2$s was not found.', '<em>' . Inflector::camelize($this->request->controller) . 'Controller::</em>', '<em>' . $this->request->action . '()</em>'); ?>
</p>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Confirm you have created the file: %s', $file); ?>
</p>
<?php echo $this->element('exception_stack_trace'); ?>
