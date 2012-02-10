<!-- Content -->
<section id="content"> 

<section class="box boxpad"> 
 
    <header>
        <h2><?php echo __('Updating Spacebukkit') ?></h2> 
    <div class="col right">
    <a href="#" class="button icon arrowright" style="top: -25px"><?php echo __('Cancel and go back') ?></a>
    </div>
    </header>

    <section>

	<p><?php echo __('SpaceBukkit is ready to be updated from version "') ?><?php echo $current; ?><?php echo __('" to version "') ?><?php echo $latest; ?><?php echo __('". Click the update button when you\'re ready!') ?><br/><br/></p>

	<a href="./update/update" class="button icon fork"><?php echo __('Update Now!') ?></a><br /><br />

		<div class="code">
		<strong><?php echo __('Changelog') ?></strong>
		<?php echo $changelog; ?>
		</div>

    </section> 
                        
 </section>


	<div class="clear"></div>
</section>
<!-- End #content --> 