<?php echo $this->Form->create('Role');?>

<nav id="mainnav" class="popup">
    <h3>Add new role</h3>
</nav>
<nav id="popuptabs">
    <ul>
        <li class="current"><a href="#tab31">Global</a></li>
        <li><a href="#tab32">DashBoard</a></li>
        <li><a href="#tab33">Users</a></li>
        <li><a href="#tab34">Plugins</a></li>
        <li><a href="#tab35">Worlds</a></li>
        <li><a href="#tab36">File Manager</a></li>
        <li><a href="#tab37">Server</a></li>
        <li><a href="#tab38">SpaceBukkit</a></li>
    </ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

<div class="tab2" id="tab31">

<section class="box boxpad"> 

<section>

<section>
  <section>
      <label for="rolename">
        Role Name
      </label>
    
      <div>
        <input type="text" id="rolename" name="rolename" />
      </div>
    </section>
  <section>
      <label for="server">
        Server
      </label>

      <div>
        <select name="server" id="server">
        <?php
        foreach ($servers as $name) {
          echo '<option value="'.$name["Server"]["id"].'">'.$name["Server"]["title"].'</option>';  

        }
        ?>
        </select>      
    </div>
    </section>

</section> 

</section>

</section> 

</div>

<div class="tab2" id="tab32">

<section class="box boxpad"> 

<section>
<?php

foreach ($permissions["dash"] as $desc => $perm) {

    echo <<<END
<section>
      <label for="title">
      $desc
      </label>
      <div>
END;
echo $this->Form->checkbox($desc); 
    echo <<<END
      </div>
</section>
END;
}
?>
</section> 

</section>

</div>

<div class="tab2" id="tab33">

<section class="box boxpad"> 

<section>
<?php

foreach ($permissions["users"] as $desc => $perm) {

    echo <<<END
<section>
      <label for="title">
      $desc
      </label>
      <div>
END;
echo $this->Form->checkbox($desc); 
    echo <<<END
      </div>
</section>
END;
}
?>
</section> 

</section>

</div>

<div class="tab2" id="tab34">

<section class="box boxpad"> 

<section>
<?php

foreach ($permissions["plugins"] as $desc => $perm) {

    echo <<<END
<section>
      <label for="title">
      $desc
      </label>
      <div>
END;
echo $this->Form->checkbox($desc); 
    echo <<<END
      </div>
</section>
END;
}
?>
</section> 

</section>

</div>

<div class="tab2" id="tab35">

<section class="box boxpad"> 

<section>
<?php

foreach ($permissions["worlds"] as $desc => $perm) {

    echo <<<END
<section>
      <label for="title">
      $desc
      </label>
      <div>
END;
echo $this->Form->checkbox($desc); 
    echo <<<END
      </div>
</section>
END;
}
?>
</section> 

</section>

</div>

<div class="tab2" id="tab36">

</div>

<div class="tab2" id="tab37">
<section class="box boxpad"> 

<section>
<?php

foreach ($permissions["servers"] as $desc => $perm) {

    echo <<<END
<section>
      <label for="title">
      $desc
      </label>
      <div>
END;
echo $this->Form->checkbox($desc); 
    echo <<<END
      </div>
</section>
END;
foreach ($permissions["global"] as $desc => $perm) {

    echo <<<END
<section>
      <label for="title">
      $desc
      </label>
      <div>
END;
echo $this->Form->checkbox($desc); 
    echo <<<END
      </div>
</section>
END;
}
}
?>
</section> 

</section>
</div>

<div class="tab2" id="tab38">
<section class="box boxpad"> 

<section>
<?php

foreach ($permissions["settings"] as $desc => $perm) {

    echo <<<END
<section>
      <label for="title">
      $desc
      </label>
      <div>
END;
echo $this->Form->checkbox($desc); 
    echo <<<END
      </div>
</section>
END;
}
?>
</section> 

</section>
</div>
<section class="box boxpad"> 
<header>
When you are finished with ALL permissions, click on "create role" :P
</header>
<section>
<?php echo $this->Form->end(__('Create role'));?>
</section> 

</section>
<div class="clear"></div>
</section>
<!-- End #content --> 