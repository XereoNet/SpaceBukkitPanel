<nav id="mainnav" class="popup">
    <h3><?php echo __('Add new Server'); ?></h3>
</nav>

<!-- Content -->
<section id="content"> 

<form id="ServerAddForm" name="ServerAddForm" method="post" action="./servers/add">
<div class="error_box"></div>
    <section>
      <label for="title">
        <?php echo __('Title'); ?>
      </label>
    
      <div>
        <input id="title" name="title" type="text" placeholder="<?php echo __('My Cool Server'); ?>"/>
      </div>
    </section>
  
    <section>
      <label for="address">
        <?php echo __('Address'); ?>
        <small><?php echo __('Port doesn\'t matter'); ?></small>
      </label>
    
      <div>
        <input type="text" id="address" name="address" placeholder="example.minecraft.com" />
      </div>
    </section>

    <section>
      <label for="port1">
        <?php echo __('Spacebukkit port'); ?>
        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
      </label>
    
      <div>
        <input type="text" id="port1" name="port1" placeholder="<?php echo __('Usually 2011'); ?>" />
      </div>
    </section>

    <section>
      <label for="port2">
        <?php echo __('SpacebukkitRTK port'); ?>
        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
      </label>
    
      <div>
        <input type="text" id="port2" name="port2" placeholder="<?php echo __('Usually 2012'); ?>" />
      </div>
    </section>
  
    <section>
      <label for="password">
        <?php echo __('Salt'); ?>
        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
      </label>
    
      <div>
        <input placeholder="<?php echo __('Salty Pretzels!'); ?>" name="password" id="password" type="password" />
      </div>
    </section>   
    <section>
      <label for="default_role">
        <?php echo __('Default Role'); ?>
        <small><?php echo __('All new users will have this role on this server'); ?></small>
      </label>

        <select name="default_role" id="default_role">
        <?php

        
        foreach ($roles as $role) {

        
        echo '<option value="'.$role["Role"]['id'].'">'.$role["Role"]['title'].'</option>';
        
        }

        ?>
        </select>   

    </section> 
    <section>
      <label for="external_address">
        <?php echo __('Dynmap address'); ?>
        <small><?php echo __('Only add this if you have Dynmap installed on a seperate server! Include http://'); ?></small>
      </label>
    
      <div>
        <input name="external_address" id="external_address" type="text" value=""/>
      </div>
    </section>      
<input type="submit" class="button primary submit leftsubmit" value="<?php echo __('Create Server'); ?>">
</form>
<div class="clear"></div>
</section>
<!-- End #content --> 
<script>
var validator = new FormValidator('ServerAddForm', [{
    name: 'title',
    display: 'Title',    
    rules: 'required|min_length[6]'
}, {
    name: 'address',
    display: 'Address',    
    rules: 'required'
}, {
    name: 'port1',
    display: 'SpaceBukkit Port',    
    rules: 'required|numeric'
}, {
    name: 'port2',
    display: 'SpaceBukkit RTK',    
    rules: 'required|numeric'
}, {
    name: 'password',
    display: 'Salt',    
    rules: 'required'
}], function(errors, event) {    
        var SELECTOR_ERRORS = $('.error_box');     
        
        if (errors.length > 0) {        
          SELECTOR_ERRORS.empty();        
          SELECTOR_ERRORS.append(errors.join('<br />'));
          SELECTOR_ERRORS.fadeIn(200);   
          event.preventDefault();    
          } else {        
          SELECTOR_ERRORS.css({ display: 'none' });       
          }        
    });
</script>
