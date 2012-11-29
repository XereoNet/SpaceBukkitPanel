<nav id="mainnav" class="popup">
    <h3>Configure <?php echo $plugin_name;?></h3>
</nav>
<!-- Tabs -->
<nav id="popuptabs">
    <ul>
    <?php

    $i = 1;

    foreach ($files as $file) {

        echo '<li';
        if ($i == 1) { echo ' class="current"';}
        echo '><a href="#tab3'.$i.'">'.$file.'</a></li>';
        $i++;

        }
    ?>
    </ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content" width="800px">
<?php


  $i = 1;

  foreach ($contents as $content) {

  echo <<<END
  <div class="tab2" id="tab3$i">

  <form id="configure" method="post" action="./tplugins/SaveConfig">

<textarea id="codemirror$i" cols="100" rows="300" width="700px" style="height: 500px;" name="config_content" class="codemirror">$content[content]</textarea>
  <br />
  <input type="hidden" id="plugin" name="plugin" value="$plugin_name">
  <input type="hidden" id="file" name="file" value="$content[file]">
  <input type="submit" name="save" class="button primary submit" value="Save">
  <input type="submit" name="reload" class="button primary submit" value="Save & Reload Server">
  <input type="submit" name="restart" class="button primary submit" value="Save & Restart Server">

  </form>
  <div class="clear"></div>
  </div>


END;
$i++;
 }


?>

<div class="clear"></div>
</section>
