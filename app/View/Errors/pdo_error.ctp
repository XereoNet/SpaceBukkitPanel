<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo h($error->getMessage()); ?>
</p>
<?php if (!empty($error->queryString)) : ?>
	<p class="notice">
		<strong><?php echo __d('cake_dev', 'SQL Query'); ?>: </strong>
		<?php echo  $error->queryString; ?>
	</p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
		<strong><?php echo __d('cake_dev', 'SQL Query Params'); ?>: </strong>
		<?php echo  Debugger::dump($error->params); ?>
<?php endif; ?>
<?php echo $this->element('exception_stack_trace'); ?>
