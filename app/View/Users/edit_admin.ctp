<nav id="mainnav" class="popup">
    <h3>Edit <?php echo $username; ?>'s settings</h3>
</nav>
<nav id="popuptabs">
</nav>
<!-- End Tabs -->
<!-- Content -->
<section id="content">
<div class="error_box"></div>

<div class="users form">
<form id="UserEditForm" method="post" action="./users/edit_admin/<?php echo $edituser["User"]["id"]; ?>">

    <section>
      <label for="username">
        Username
      </label>

      <div>
        <input id="username" name="username" type="text" value="<?php echo $edituser["User"]["username"]; ?>"/>
      </div>
    </section>

    <section>
      <label for="password">
        Password
      </label>

      <div>
        <input name="password" id="password" type="password" />
      </div>
    </section>

    <section>
      <label for="theme">
        Default theme
      </label>

        <div>
            <select name="theme" id="theme">
            <?php

            foreach ($themes as $theme) {

            $check = "";

            if ($theme["name"] == $edituser["User"]["theme"]) { $check = 'selected'; }


            echo '<option value="'.$theme['name'].'" '.$check.'>'.$theme['name'].'</option>';

            }

            ?>
            </select>
      </div>
    </section>

    <section>
      <label for="fserver">
        Favourite Server
      </label>
    <?php

    //debug($edituser["ServersUsers"]);

    ?>
        <div><select name="favourite_server" id="favourite_server">

            <?php

            if ($edituser["User"]["is_super"] == 1){

                foreach ($all_servers as $server) {

                  $check = "";

                  if ($server["Server"]["id"] == $edituser["User"]["favourite_server"]) { $check = 'selected'; }

                  $output = '<option value="'.$server["Server"]['id'].'"'.$check.'>'.$server["Server"]['title'].'</option>';

                  echo $output;

                }

            } else {

                foreach ($all_servers as $server) {

                    $check = "";

                    if ($server["Server"]["id"] == $edituser["User"]["favourite_server"]) { $check = 'selected'; }

                    foreach ($edituser["ServersUsers"] as $su) {

                      if ($su["server_id"] == $server["Server"]['id']) {

                        $output = '<option value="'.$server["Server"]['id'].'"'.$check.'>'.$server["Server"]['title'].'</option>';
                        break;

                      } else {

                        $output = '';

                      }

                    }

                    echo $output;

                }

            }





            ?>
            </select>
      </div>
    </section>
    <section>
      <label for="language">
        Default language
      </label>

        <div>
            <select name="language" id="language">

            <?php

            foreach ($languages as $name => $language) {

            $check = "";

            if ($language == $edituser["User"]["langauge"]) { $check = 'selected'; }

            echo '<option value="'.$language.'" '.$check.'>'.$name.'</option>';

            }

            ?>

            </select>
        </div>
    </section>
        <?php if ($is_super == 1) { ?>
     <section>
      <label for="title">
        <?php echo __('SuperUser') ?>
      </label>

      <div>
<input type="hidden" name="is_super" value="0" id="is_super_" />
<input type="checkbox" name="is_super" value="1" id="is_super" <?php if ($edituser["User"]["is_super"] == "1") {echo " checked";}?>/>
 </div>
    </section>
     <?php } ?>



<input type="submit" class="button primary submit" value="Submit">
</form>
</div>
<div class="clear"></div>
</section>
<!-- End #content -->
<script>
$('document').ready(function(){
    var validator = new FormValidator('UserEditForm', [{
        name: 'username',
        display: 'Username',
        rules: 'required'
    },{
        name: 'theme',
        display: 'Theme',
        rules: 'required'
    }, {
        name: 'language',
        display: 'Language',
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