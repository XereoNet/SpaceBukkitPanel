<?php
$pluginDot = empty($plugin) ? null : $plugin . '.';
?>
<h2><?php echo __d('cake_dev', 'Missing Behavior'); ?></h2>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', '%s could not be found.', '<em>' . $pluginDot . $class . '</em>'); ?>
</p>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Create the class %s below in file: %s', '<em>' . $class . '</em>', (empty($plugin) ? APP_DIR . DS : CakePlugin::path($plugin)) . 'Model' . DS . 'Behavior' . DS . $class . '.php'); ?>
</p>
<pre>
&lt;?php
class <?php echo $class; ?> extends ModelBehavior {

}
</pre>

<?php echo $this->element('exception_stack_trace'); ?>
