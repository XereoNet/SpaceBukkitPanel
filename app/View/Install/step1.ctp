<!-- Content -->
<section id="content"> 

<section class="box boxpad"> 
 
    <header>
        <div class="col left">
            <h2><?php echo __('Installing Spacebukkit') ?></h2> 
        </div>    
        <div class="col right" style="text-align: right">
            <h2>Step 2 of 5</h2>
        </div>
    </header>

    <section class="installation">

    <div class="col left col_1_3 ">
    <img src="http://it.gravatar.com/userimage/14500596/3ed9d114c731abc87cf4985212671b87.png?size=150" /><br />
    <p>Hey, my name is Antariano, I'm the lead developer of SpaceBukkit!</p>
    </div>
 
     <div class="col right col_2_3">

    <div class="triangle-border left">
    <h2>Environment Compatibility Check</h2><br />
    <p><?php echo $php_version; ?></p>
    <p><?php echo $configuration; ?></p>
    <p><?php echo $database; ?></p>
    <p><?php echo $php_fopen; ?></p>
    <p><?php echo $php_curl; ?></p>
    <p><?php echo $tmp_folder; ?></p>
    <p><?php echo $webroot_folder; ?></p>

    <p><?php echo $result; ?></p>
    </div>

    </div>

    <div class="clear"></div>

    </section> 
      
    <header>
       <a href="<?php echo $this->Html->url('/install/index', true); ?>" class="button icon arrowleft">Previous</a>
       <?php if ($result_bool == 1) { ?><a href="<?php echo $this->Html->url('/install/step2', true); ?>" class="button icon arrowright leftsubmit">Next</a><?php }?>
       <?php if ($result_bool == 0) { ?><a href="<?php echo $this->Html->url('/install/step2', true); ?>" class="button icon arrowright leftsubmit">I'm sure that everything works, your code is bugged!</a><?php }?>
    </header>                   
 </section>

<div class="clear"></div>
</section>
<!-- End #content --> 