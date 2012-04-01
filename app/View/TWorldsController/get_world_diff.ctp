<nav id="mainnav" class="popup">
    <h3>Change difficulty</h3>
</nav>
<nav id="popuptabs">
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 
<?php if($diff == "PEACEFUL"){
	$img = "<img src=\"img/peaceful.png\"> <bold>".__('Peaceful')."</bold>";
}else if($diff == "EASY"){
	$img = "<img src=\"img/easy.png\"> <bold>".__('Easy')."</bold>";
}else if($diff == "NORMAL"){
	$img = "<img src=\"img/normal.png\"> <bold>".__('Normal')."</bold>";
}else if($diff == "HARD"){
	$img = "<img src=\"img/hard.png\"> <bold>".__('Hard')."</bold>";
}
?>
<div class="buttons"><center>
<h1><?php echo "World: ".$wrld; ?></h1><br><br><?php echo __('Your current difficulty is set to: ').$img;?><br><br><?php echo __('Click a difficulty to change to:'); ?><br><br>
<?php 
if ($diff != "PEACEFUL"){
	echo "<span class=\"button-group\"><a href=\"./tworlds/setWorldDiff/".$wrld."/0\" onclick=\"$.nmTop().close();\" class=\"button icon edit ajax_table1\">".__('Peaceful')."</a></span> ";
}else{echo " ";}
if($diff != "EASY"){
	echo "<span class=\"button-group\"><a href=\"./tworlds/setWorldDiff/".$wrld."/1\" onclick=\"$.nmTop().close();\" class=\"button icon edit ajax_table1\">".__('Easy')."</a></span>";
}else{echo " ";}
if($diff != "NORMAL"){
	echo "<span class=\"button-group\"><a href=\"./tworlds/setWorldDiff/".$wrld."/2\" onclick=\"$.nmTop().close();\" class=\"button icon edit ajax_table1\">".__('Normal')."</a></span>";	
}else{echo " ";}
if($diff != "HARD"){
	echo "<span class=\"button-group\"><a href=\"./tworlds/setWorldDiff/".$wrld."/3\" onclick=\"$.nmTop().close();\" class=\"button icon edit ajax_table1\">".__('Hard')."</a></span>";
}
?>
</center></div>
<div class="clear"></div>
</section>
<!-- End #content --> 
