<!-- Content -->
<section id="content"> 

<section class="box boxpad"> 
 
    <header>
        <h2><?php echo __('Updating Spacebukkit') ?></h2> 
    <div class="pull-right">
    <a href="./dash" class="button icon arrowright"><?php echo __('Cancel and go back') ?></a>
    </div>
    </header>

    <section>

	<p><?php echo __('SpaceBukkit is ready to be updated from version "') ?><?php echo $current; ?><?php echo __('" to version "') ?><?php echo $latest; ?><?php echo __('". Click the update button when you\'re ready!') ?><br/><br/></p>

    <?php if ($owner[0] == true) {
        echo '<div class="colorbox green">Your SpaceBukkit folder has the correct rights set to it. Click the button to upgrade SpaceBukkit: <br><br><a href="./update/update" class="button icon fork">'.__('Update Now!').'</a><br></div>';
    } else {
        echo '<div class="colorbox red">Your SpaceBukkit folder doesn\'t have the correct rights set to it. This could break the upgrade process.<br>If you want to fix this issue please run this command as root, or ask your administrator to do this for you:<div style="background: #EEE; color: black;" class="code">'.$owner[1].'</div><br><a href="./update" class="button icon reload">'.__('Refresh').'</a><br></div>';
    }
    ?>
	

		<div class="code">
		<strong><?php echo __('Changelog') ?></strong>
		<?php echo $changelog; ?>
		</div>

    </section> 
                        
 </section>


	<div class="clear"></div>
</section>
<!-- End #content --> 