<?php echo $this->Form->create('Role');?>

<nav id="mainnav" class="popup">
    <h3>Edit role</h3>
</nav>
<nav id="popuptabs">
    <ul>
      <li class="current"><a href="#tab100">General</a></li>
            <?php

      foreach ($permissions["pages"] as $desc => $perm) 
      {

      echo '<li><a href="#'.$desc.'">'.$desc.'</a></li>';

      }

?>
    </ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 
<div class="error_box"></div>
<div class="tab2" id="tab100">
  <section>

      <section>
          <label for="rolename">
            <?php echo __('Role Name'); ?>
          </label>
        
          <div>
            <input type="text" id="rolename" name="rolename" value="<?php echo $cst['title']?>" />
          </div>
      </section>
      <p>The following checkboxes allow you to configure "access" to pages and tools. If these are checked, users with this role can "see" the pages. Check the respective permissions on the next pages to allow them to "do" things.</p>
      <?php

      foreach ($permissions["pages"] as $desc => $perm) 
      {

    echo <<<END
      <section>
        <label for="$desc">
        $desc
        </label>
        <div>
END;
      echo '<input type="hidden" name="'.$desc.'" value="0">';
      echo '<input name="'.$desc.'" type="checkbox" value="1" '.$cst[$desc].'>';
      echo <<<END
        </div>
        </section>
END;
      }

?>
      </section>

  </div>
      <?php

      foreach ($permissions["pages"] as $desc => $perm) 
      {

      echo '<div class="tab2" id="'.$desc.'">';
      
        foreach ($permissions[$desc] as $desc => $perm) 
        {

echo <<<END
      <section>
        <label for="$desc">
        $desc
        </label>
        <div>
END;
      echo '<input type="hidden" name="'.$desc.'" value="0">';
      echo '<input name="'.$desc.'" type="checkbox" value="1" '.$cst[$desc].'>';
      echo <<<END
        </div>
        </section>
END;

        }
      
      echo '</div>';

      }

?>

<div class="submit" style="position: absolute; bot: 10px; right: 10px"><input type="submit" value="<?php echo __('Save role'); ?>" class="button"></div>
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
