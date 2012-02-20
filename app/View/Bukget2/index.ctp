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

					$id[$cat] = str_replace(" ", "_", $cat);
						
						echo '<li><a href="#'.$id[$cat].'" class="has-child unloaded" rel="'.$id[$cat].'">'.$cat.'</a></li>';

					}

?>
				</ul>
			</div>
<?php
foreach ($cats as $cat) {

echo <<<END
	<div id="$id[$cat]" class="additional-block">
				<div class="bukget-heading">
					<h3>
					$cat
					</h3>
				</div>
				<ul class="menu" id="$id[$cat]_menu">
					
				</ul>
			</div>

END;

}

?>	
		</div>
	</div>
</div>

<div class="col right col_1_3 bukget-area2">

	<div class="bukget-heading">
		<h3>
		Last Updated
		</h3>
	</div>

	<ul class="bukget-list">
		<li>
		<b>Plugin 1</b>
		<p>Date modified</p>
		</li>
		<li>
		<b>Plugin 2</b>
		<p>Date modified</p>
		</li>
		<li>
		<b>Plugin 3</b>
		<p>Date modified</p>
		</li>
		<li>
		<b>Plugin 4</b>
		<p>Date modified</p>
		</li>				
	</ul>

</div>