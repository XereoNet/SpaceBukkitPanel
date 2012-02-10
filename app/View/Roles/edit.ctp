<?php echo $this->Form->create('Role');?>

<nav id="mainnav" class="popup">
    <h3>Edit role</h3>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 
<div class="error_box"></div>

<section>

    <section>
        <label for="rolename">
          <?php echo __('Role Name'); ?>
        </label>
      
        <div>
          <input type="text" id="rolename" name="rolename" value="<?php echo $cst['title']?>" />
        </div>
    </section>
<?php
foreach ($permissions["pages"] as $desc => $perm) {

    echo <<<END
<section>
      <label for="$desc">
      $desc
      </label>
      <div>
END;
echo '<input type="hidden" name="'.$desc.'" value="0">';
echo '<input name="'.$desc.'" type="checkbox" value="1"'.$cst[$desc];
    echo <<<END
      </div>
</section>
END;
}
?>
</section>


<div class="submit"><input type="submit" value="<?php echo __('Save role'); ?>" class="button"></div>
</form>

<div class="clear"></div>
</div>

<!-- End #content --> 
<script>
$('document').ready(function(){
    var validator = new FormValidator('RoleEditForm', [{
        name: 'rolename',
        display: 'Role name',    
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
