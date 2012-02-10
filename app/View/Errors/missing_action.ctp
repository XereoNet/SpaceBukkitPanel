
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'The action %1$s is not defined in controller %2$s', '<em>' . $action . '</em>', '<em>' . $controller . '</em>'); ?>
</p>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Create %1$s%2$s in file: %3$s.', '<em>' . $controller . '::</em>', '<em>' . $action . '()</em>', APP_DIR . DS . 'Controller' . DS . $controller . '.php'); ?>
</p>
<pre>
&lt;?php
class <?php echo $controller;?> extends AppController {

<strong>
	public function <?php echo $action;?>() {

	}
</strong>
}
</pre>

<?php echo $this->element('exception_stack_trace'); ?>
