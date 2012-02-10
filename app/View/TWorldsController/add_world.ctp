<nav id="mainnav" class="popup">
    <h3>Add new world</h3>
</nav>
<nav id="popuptabs">
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

<div class="users form">
<form id="ServerAddForm" method="post" action="./tworlds/addWorld">
  
    <section>
      <label for="name">
        <?php echo __('Name'); ?>
      </label>
    
      <div>
        <input id="name" name="name" type="text"/>
      </div>
    </section>

    <section>
      <label for="seed">
        <?php echo __('Seed'); ?>
      </label>
    
      <div>
        <input name="seed" id="seed" type="text"/>
      </div>
    </section>   

             <section>
              <label for="title">
                <?php echo __('Environment'); ?>
              </label>
            
              <div>
              
                <select name="type" id="type">

                  <option value="NORMAL" selected><?php echo __('Normal'); ?></option>
                  <option value="NETHER"><?php echo __('The nether'); ?></option>
                  <option value="END"><?php echo __('The end'); ?></option>

                </select>   
              </div>
            </section> 



<input type="submit" class="button primary submit" value="<?php echo __('Submit'); ?>">
</form>
</div>
<div class="clear"></div>
</section>
<!-- End #content --> 
