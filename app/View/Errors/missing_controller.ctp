
<?php
$pluginDot = empty($plugin) ? null : $plugin . '.';
?>
<h2></h2>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', '%s could not be found.', '<em>' . $pluginDot . $class . '</em>'); ?>
</p>

<p class="notice">
	Make sure you are accessing the correct address. If the error continues, use one of the links below to get help
</p>

<?php echo $this->element('exception_stack_trace'); ?>
