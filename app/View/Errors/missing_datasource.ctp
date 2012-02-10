<?php
$pluginDot = empty($plugin) ? null : $plugin . '.';
?>

<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Datasource class %s could not be found.', '<em>' . $pluginDot . $class . '</em>'); ?>
</p>


<?php echo $this->element('exception_stack_trace'); ?>
