<nav id="mainnav" class="popup">
    <h3><?php echo __('Edit Server'); ?></h3>
</nav>
<nav id="popuptabs">
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

<form id="ServerAddForm" name="ServerAddForm" method="post" action="./servers/edit/<?php echo $editserver["Server"]["id"]; ?>">
 <div class="error_box"></div>
    <section>
      <label for="title">
        <?php echo __('Title*'); ?>
      </label>
    
      <div>
        <input id="title" name="title" type="text" value="<?php echo $editserver["Server"]["title"]; ?>"/>
      </div>
    </section>
  
    <section>
      <label for="address">
        <?php echo __('Address*'); ?>
        <small>Port donesn't matter</small>
      </label>
    
      <div>
        <input type="text" id="address" name="address" value="<?php echo $editserver["Server"]["address"]; ?>"/>
      </div>
    </section>

    <section>
      <label for="port1">
        <?php echo __('Spacebukkit port*'); ?>
        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
      </label>
    
      <div>
        <input type="text" id="port1" name="port1" value="<?php echo $editserver["Server"]["port1"]; ?>"/>
      </div>
    </section>

    <section>
      <label for="port2">
        <?php echo __('SpacebukkitRTK port*'); ?>
        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
      </label>
    
      <div>
        <input type="text" id="port2" name="port2" value="<?php echo $editserver["Server"]["port2"]; ?>"/>
      </div>
    </section>
  
    <section>
      <label for="password">
        <?php echo __('Salt*'); ?>
        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
      </label>
    
      <div>
        <input name="password" id="password" type="password" value="<?php echo $editserver["Server"]["password"]; ?>"/>
      </div>
    </section>   

    <section>
      <label for="external_address">
        <?php echo __('Dynmap address'); ?>
        <small><?php echo __('Only change this if you have Dynmap installed on a seperate server! Include http://'); ?></small>
      </label>
    
      <div>
        <input name="external_address" id="external_address" type="text" value="<?php echo $editserver["Server"]["external_address"]; ?>"/>
      </div>
    </section> 
<input type="submit" class="button primary submit" value="<?php echo __('Submit'); ?>">
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
