<!-- Content -->
<section id="content"> 

<section class="box boxpad"> 
 
    <header>
        <div class="col left">
            <h2><?php echo __('Installing Spacebukkit') ?></h2> 
        </div>    
        <div class="col right" style="text-align: right">
            <h2>Step 4 of 5</h2>
        </div>
    </header>

    <section class="installation">

    <div class="col left col_1_3 ">
    <img src="<?php echo $this->Html->url('/img/neatdev.png', true); ?>" /><br />    
    <p>Hi I'm NeatMonster, I'm a very neat coder.</p><!-- Oh, I've tidied up a fair bit of your code ;) -->
    <?php 
    if (isset($result)) {
      echo '<p class="failed">Your settings are invalid, the following errors occoured:</p>';
      echo '<div class="code">'.$result.'</div>';

    }
?>
<div class="error_box"></div>

    </div>

    <div class="col right col_2_3">

    <div class="triangle-border left">
    <h2>Add Server</h2>
    <p>Now let's add a SpaceBukkit-ready server to this panel! Make sure that the server's online, first.</p>
    <form action='<?php echo $this->Html->url('/install/step3', true); ?>' id='server' method='post'>
<div class="error_box"></div>
    <section>
      <label for="title">
        Title
      </label>
    
      <div>
        <input id="title" name="title" type="text" placeholder="My Cool Server"/>
      </div>
    </section>
  
    <section>
      <label for="address">
        Address
        <small>Port doesn't matter</small>
      </label>
    
      <div>
        <input type="text" id="address" name="address" placeholder="example.minecraft.com" />
      </div>
    </section>

    <section>
      <label for="port1">
        Spacebukkit port
        <small>This can be changed in the config.yml of your server</small>
      </label>
    
      <div>
        <input type="text" id="port1" name="port1" placeholder="Usually 2011" />
      </div>
    </section>

    <section>
      <label for="port1">
        SpacebukkitRTK port
      </label>
    
      <div>
        <input type="text" id="port2" name="port2" placeholder="Usually 2012" />
      </div>
    </section>
  
    <section>
      <label for="password">
        Salt
        <small>This can be changed in the config.yml of your server</small>
      </label>
    
      <div>
        <input placeholder="Salty Pretzels!" name="password" id="password" type="password" />
      </div>
    </section>   
    <section>
      <label for="default_role">
        Default Role
        <small>All new users will have this role on this server</small>
      </label>

        <select name="default_role" id="default_role">
        <?php

        
        foreach ($roles as $role) {

        
        echo '<option value="'.$role["Role"]['id'].'">'.$role["Role"]['title'].'</option>';
        
        }

        ?>
        </select>   

    </section>      
<br />
    </div>

    </div>

    <div class="clear"></div>

    </section> 
      
    <header>
       <a href='<?php echo $this->Html->url('/install/step2', true); ?>' class='button icon arrowleft'>Previous</a>
       <input type='submit' id='submit' value='Next' tabindex='5' class='button leftsubmit' />
        
    </form>
    </header>                   
 </section>

<div class="clear"></div>
</section>
<!-- End #content --> 
<script>
$('document').ready(function(){
    var validator = new FormValidator('server', [{
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
    });
</script>