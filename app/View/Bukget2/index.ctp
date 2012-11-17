<div class="col left col_2_3 bukget-area">
	<div class="binder">
		<div class="slider">
			<div id="first" class="additional-block">
				<div class="bukget-heading">
					<h3>
					Categories
					</h3>
				</div>
				<ul class="menu">
<?php

					$id = array();

					foreach ($cats as $cat) {

					$id[$cat] = str_replace(" ", "%20", $cat);

						echo '<li><a href="./bukget2/cat/'.$id[$cat].'" class="fancy has-child unloaded" rel="'.$id[$cat].'">'.$cat.'</a></li>';

					}

?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="col right col_1_3 bukget-area2">

	<div class="bukget-heading">
		<h3>
		<?php echo __('Last Updated'); ?>
		</h3>
	</div>
	<div class="bukget-list">

	<ul>
		<?php
		    foreach ($latest as $change)
      {

echo <<<END
    <li>
    <b>$change[plugin]</b>
    <p>$change[version]</p>
    </li>
END;
      }
		?>
	</ul>
	</div>
</div>