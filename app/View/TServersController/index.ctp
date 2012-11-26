<!-- Tabs -->
<nav id="smalltabs">
        <ul>
                <li class="current"><a href="#tab1"><?php echo __('Server Overview'); ?></a></li>
                <li><a href="#tab2"><?php echo __('Server .jar'); ?></a></li>
                <li><a href="#tab3"><?php echo __('Server properties') ?></a></li>
                <li><a href="#tab4"><?php echo __('Bukkit properties') ?></a></li>
                <li><a href="#tab5"><?php echo __('Schedules') ?></a></li>
                <li><a href="#tab6"><?php echo __('server.log') ?></a></li>
        </ul>
</nav>
<!-- End Tabs -->
<!-- Content -->

<section id="content">

<div class="tab" id="tab1">

<section class="grid_view" id="serveroverview">
<div class="col col_1_3 left">

    <section>
      <label for="CPU">
        CPU:
      </label>

      <div>
        Loading...<br>
      </div>
    </section>

    <section>
      <label for="Java">
        Java Version:
      </label>

      <div>
        Loading...<br>
      </div>
    </section>

    <section>
      <label for="Bukkit">
        Bukkit Version:
      </label>

      <div>
        Loading...<br>
      </div>
    </section>

  </div>


  <div class="col col_1_3 left">

      <section>
        <label for="Architecture">
          Architecture:
        </label>

        <div>
          Loading...<br>
        </div>
      </section>
        <section>
          <label for="OS">
            Operating System:
          </label>

          <div>
            Loading...<br>
          </div>
        </section>

        <section>
          <label for="SB">
            SpaceBukkit Version:
          </label>

          <div>
            Loading...<br>
          </div>
       <div class="clear"></div>
          </section>
  </div>


  <div class="col col_1_3 left">

    <section>
      <label for="Memory">
        Memory:
      </label>

      <div>
        Loading...<br>
      </div>
    </section>

    <section>
      <label for="Disk">
        Disk Space:
      </label>

      <div>
        Loading...<br>
      </div>
    </section>


        <section>
          <label for="Web">
            Webserver Version:
          </label>

          <div>
            Loading...<br>
          </div>
        </section>
  </div>

  <div class="clear"></div>
</section>
<div class="clear"></div>

</div>

<div class="tab" id="tab2">
<section class="box boxpad nofilter nosearch">

        <header>
            <h2><?php echo __('Server .jar') ?></h2>
            <select id="jarchooser">
              <option value="cb">CraftBukkit</option>
              <!-- <option value="sg">Spigot</option> -->
            </select>
        </header>

       <section>

       <h3 style="text-align: center">You are running CraftBukkit version <?php echo $cversion; ?></h3>

       <p class="description">
       <?php echo __('Hover over an RB to see it\'s details. Click on an RB to install it for this server. Installing another CraftBukkit build will stop the server during the process!') ?>
       </p>

       <div id="rb_chooser">
        <div class="rb_builds">

          Loading...

        </div>
               <div class="timeline_start"></div>
               <div class="timeline"></div>
               <div class="timeline_end"></div>

       </div>


       <div class="clear"></div><br>

        <table class="datatable jartable notitle" id="jartable">
          <thead>
            <tr>
              <th>Build</th>
              <th>Version</th>
              <th>Type</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>

          </tbody>

        </table>

         <div class="clear"></div>

             <br /><br />
       <p class="description">
       <?php echo __('Alternatively you can specify a custom build here:') ?>
       </p>

      <form id="rb_chooser" class="bwl1" method="post" action="./tservers/install_cb">

      <fieldset>

      <input id="cb" name="cb" type="text" placeholder="<?php echo __('e.g. 1000') ?>"/>
      <input type="submit" class="button big primary submit confirmCB" value="<?php echo __('Download & Install this Build') ?>">
        </fieldset>

      </form>


       </section>

</section>
<div class="clear"></div>

</div>

<div class="tab" id="tab3">
<section class="box boxpad" style="position: relative">
    <header>
        <h2><?php echo __('Server properties') ?></h2>

    </header>

    <section>
        <form id="saveconfig" method="post" action="./tservers/saveConfig">
        <form id="ServerAddForm" method="post" action="./tservers/saveConfig">
        <div class="col left">

            <section>
              <label for="title">
                <?php echo __('Server Name') ?>
              </label>

              <div>
                <input id="server-name" name="server-name" type="text" value="<?php echo $server_name ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Server ID') ?>
              </label>

              <div>
                <input id="server-id" name="server-id" type="text" value="<?php echo $server_id ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Level Name') ?>
              </label>

              <div>
                <input id="level-name" name="level-name" type="text" value="<?php echo $level_name ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Level Seed') ?>
              </label>

              <div>
                <input id="level-seed" name="level-seed" type="text" value="<?php echo $level_seed ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('MOTD') ?>
              </label>

              <div>
                <input id="motd" name="motd" type="text" value="<?php echo $motd ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Server port') ?>
              </label>

              <div>
                <input id="server-port" name="server-port" type="text" value="<?php echo $server_port ;?>"/>
              </div>
            </section>

             <section>
              <label for="title">
               <?php echo __(' Server IP') ?>
              </label>

              <div>
                <input id="server-ip" name="server-ip" type="text" value="<?php echo $server_ip ;?>"/>
              </div>
            </section>

             <section>
              <label for="title">
               <?php echo __('Maximum Players') ?>
              </label>

              <div>
                <input id="max-players" name="max-players" type="text" value="<?php echo $max_players ;?>"/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('View Distance') ?>
              </label>

              <div>
                <input id="view-distance" name="view-distance" type="text" value="<?php echo $view_distance ;?>"/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Level type') ?>
              </label>

              <div>
                <input id="level-type" name="level-type" type="text" value="<?php echo $level_type ;?>"/>
              </div>
            </section>
            </div>



            <div class="col right">


            <section>
              <label for="title">
                <?php echo __('Max build height') ?>
              </label>

              <div>

                <select name="max-build-height" id="max-build-height">

                  <?php
                      for ($i=1; $i <= 256; $i++) {
                        if ($max_build_height == $i) {
                          echo '<option value="'.$i.'" selected>'.$i.'</option>';
                        } else {
                          echo '<option value="'.$i.'">'.$i.'</option>';
                        }

                      }
                  ?>


                </select>
              </div>
            </section>

             <section>
              <label for="title">
                <?php echo __('Difficulty') ?>
              </label>

              <div>

                <select name="difficulty" id="difficulty">

                  <option value="0"<?php if ($difficulty == "0") {echo " selected";}?>><?php echo __('Peaceful') ?></option>
                  <option value="1"<?php if ($difficulty == "1") {echo " selected";}?>><?php echo __('Easy') ?></option>
                  <option value="2"<?php if ($difficulty == "2") {echo " selected";}?>><?php echo __('Normal') ?></option>
                  <option value="3"<?php if ($difficulty == "3") {echo " selected";}?>><?php echo __('Hard') ?></option>

                </select>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Gamemode') ?>
              </label>

              <div>
               <select name="gamemode" id="gamemode">

                  <option value="0"<?php if ($gamemode == "0") {echo " selected";}?>><?php echo __('Survival') ?></option>
                  <option value="1"<?php if ($gamemode == "1") {echo " selected";}?>><?php echo __('Creative') ?></option>

                </select>
             </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Whitelist') ?>
              </label>

              <div>
                <input id="white-list" name="white-list" type="checkbox" value="true"  <?php if ($white_list == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Online Mode') ?>
              </label>

              <div>
                <input id="online-mode" name="online-mode" type="checkbox" value="true" <?php if ($online_mode == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Allow Flight') ?>
              </label>

              <div>
                <input id="allow-flight" name="allow-flight" type="checkbox" value="true"   <?php if ($allow_flight == "true") {echo " checked";}?>/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Allow Nether') ?>
              </label>

              <div>
                <input id="allow-nether" name="allow-nether" type="checkbox" value="true"   <?php if ($allow_nether == "true") {echo " checked";}?>/>
              </div>
            </section>

             <section>
              <label for="title">
                <?php echo __('Spawn Animals') ?>
              </label>

              <div>
                <input id="spawn-animals" name="spawn-animals" type="checkbox" value="true"   <?php if ($spawn_animals == "true") {echo " checked";}?>/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Spawn NPC\'s') ?>
              </label>

              <div>
                <input id="spawn-npcs" name="spawn-npcs" type="checkbox" value="true"   <?php if ($spawn_npcs == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('PVP') ?>
              </label>

              <div>
                <input id="pvp" name="pvp" type="checkbox" value="true"   <?php if ($pvp == "true") {echo " checked";}?>/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Hardcore') ?>
              </label>

              <div>
                <input id="hardcore" name="hardcore" type="checkbox" value="true"   <?php if ($hardcore == "true") {echo " checked";}?>/>
              </div>
            </section>

             <section>
              <label for="title">
                <?php echo __('Spawn Monsters') ?>
              </label>

              <div>
                <input id="spawn-monsters" name="spawn-monsters" type="checkbox" value="true"   <?php if ($spawn_monsters == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Enable Rcon') ?>
              </label>

              <div>
                <input id="enable-rcon" name="enable-rcon" type="checkbox" value="true" <?php if ($enable_rcon == "true") {echo " checked";}?>/>
              </div>
            </section>
             <section>
              <label for="title">
                <?php echo __('Enable Query') ?>
              </label>

              <div>
                <input id="enable-query" name="enable-query" type="checkbox" value="true" <?php if ($enable_query == "true") {echo " checked";}?>/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Enable Snooper') ?>
              </label>

              <div>
                <input id="snooper-enabled" name="snooper-enabled" type="checkbox" value="true" <?php if ($snooper_enabled == "true") {echo " checked";}?>/>
              </div>
            </section>

<input type="submit" value="Save" style="position: absolute; top: 13px; right: 10px;" name="save" class="button primary submit leftsubmit showOverlay" rel="Saving server.properties..." id="saveprop">
        </div>
        </form>

        <div class="clear"></div>

    </section>

 </section>

</div>       <!-- End col right -->
<div class="clear"></div>

<div class="tab" id="tab4">
<section class="box boxpad" style="position: relative">
    <header>
        <h2><?php echo __('Bukkit Properties') ?></h2>

    </header>

    <section>
        <form id="savebukkitconfig" method="post" action="./tservers/saveBukkitConfig">
        <form id="ServerBukkitAddForm" method="post" action="./tservers/saveBukkitConfig">
          <div class="col left">

            <section>
              <label for="title">
                <?php echo __('Spawn radius') ?>
              </label>

              <div>
                <input id="spawn-radius" name="spawn-radius" type="text" value="<?php echo $bukkit['spawn-radius'] ;?>"/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Update folder') ?>
              </label>

              <div>
                <input id="update-folder" name="update-folder" type="text" value="<?php echo $bukkit['update-folder'] ;?>"/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Permissions file') ?>
              </label>

              <div>
                <input id="permissions-file" name="permissions-file" type="text" value="<?php echo $bukkit['permissions-file'] ;?>"/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Connection throttle') ?>
              </label>

              <div>
                <input id="connection-throttle" name="connection-throttle" type="text" value="<?php echo $bukkit['connection-throttle'] ;?>"/>
              </div>
            </section>

          </div>



          <div class="col right">
            <section>
              <label for="title">
                <?php echo __('Ticks per animal spawns') ?>
              </label>

              <div>
                <input id="animal-spawns" name="animal-spawns" type="text" value="<?php echo $bukkit['animal-spawns'] ;?>"/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Ticks per monster spawns') ?>
              </label>

              <div>
                <input id="monster-spawns" name="monster-spawns" type="text" value="<?php echo $bukkit['monster-spawns'] ;?>"/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Allow The End') ?>
              </label>

              <div>
                <input id="allow-end" name="allow-end" type="checkbox" value="true" <?php if ($bukkit['allow-end'] == "true") {echo " checked";}?>/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Warn on overload') ?>
              </label>

              <div>
                <input id="warn-on-overload" name="warn-on-overload" type="checkbox" value="true" <?php if ($bukkit['warn-on-overload'] == "true") {echo " checked";}?>/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Use exact login location') ?>
              </label>

              <div>
                <input id="use-exact-login-location" name="use-exact-login-location" type="checkbox" value="true" <?php if ($bukkit['use-exact-login-location'] == "true") {echo " checked";}?>/>
              </div>
            </section>
            <section>
              <label for="title">
                <?php echo __('Plugin profiling') ?>
              </label>

              <div>
                <input id="plugin-profiling" name="plugin-profiling" type="checkbox" value="true" <?php if ($bukkit['plugin-profiling'] == "true") {echo " checked";}?>/>
              </div>
            </section>

            <input type="submit" value="Save" style="position: absolute; top: 13px; right: 10px;" name="save" class="button primary submit leftsubmit showOverlay" rel="Saving bukkit.yml..." id="savebuk">
          </div>
        </form>

        <div class="clear"></div>

    </section>

 </section>

</div>       <!-- End col right -->
<div class="clear"></div>

<div class="tab" id="tab5">

  <div class="table_container">

    <header>

      <h2><?php echo __('Schedules') ?></h2>

      <a href="./schedules/add" class="button icon fancy add">Add Schedule</a>

    </header>
    <table class="datatable dtb1 notitle" id="schedules_table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Command</th>
        <th>Arguments</th>
        <th>Time type</th>
        <th>Time</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>

    </tbody>

    </table>
  </div>
<div class="clear"></div>

</div>

<div class="tab" id="tab6">


  <section class="box boxpad">

        <header>
            <h2><?php echo __('server.log') ?></h2>
            <span class="button-group pull-right">
              <a href="./tservers/rollserverlog" id="rollLog" class="button icon reload ajax">Rollover server.log</a>
              <a href="./tservers/dlserverlog" id="downloadlog" class="button icon arrowdown ajax">Download server.log</a>
              <a href="./tservers/delserverlog" id="delLog" class="button icon remove danger ajax">Delete server.log</a>
              <a href="#" id="reloadlog" class="button icon reload">Reload</a>
            </span>
        </header>

        <section>

          <p class="code" style="font-size: 15px; color: #333; overflow: auto; max-height: 400px; max-width: 100%;" id="serverlog">

          </p>

        </section>

  </section>

<div class="clear"></div>

</div>

</section>
<!-- End #content -->
<script>
$('document').ready(function() {


  //load server overview

  var url = "<?php echo $this->Html->url(array('controller' => 'tservers', 'action' => 'getServerOverview' )); ?>";
  $.ajax({
    url: url,
    success: function(data) {
      $('#serveroverview').html(data);
    }
  });

  Table1 = $('.dtb1').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './schedules/getTasks'
  });

  jartable = $('.jartable').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tservers/getBuilds/'
  });
  $('#rb_chooser .rb_builds').load('./tservers/getRBS/');

  $('#jarchooser').change(function (event) {
    var val = $(this).val();
    jartable.fnReloadAjax('./tservers/getBuilds/'+val);
    $('#rb_chooser .rb_builds').html('loading...').load('./tservers/getRBS/'+val);

  });


  /* server.log */
  loadServerlog();
  var serverlog     = $('#serverlog');

  function loadServerlog() {

    var serverurl     = "<?php echo $this->Html->url(array('controller' => 'tservers', 'action' => 'getServerlog' )); ?>";

    $('#serverlog').load(serverurl);

  }


  $('#reloadlog').click(function() {

      loadServerlog();
      return false;

  });

  $('#downloadlog').click(function() {
      var source = $(this).attr("href");
      window.open(source, 'Download');
      return false;

  });

  /* schedules */

   $('#arguments').hide();

   var rel = $("#type option:selected").attr('rel');

   if (rel == "needsargs")
      {
        $('#arguments').fadeIn();
      }
    else if ((rel != "false") || (rel != "nee"))
      {
        $('#arguments').val(rel);
      }

  //listen for change of select box
  $('#type').live("change", function() {

      $('#arguments').hide();

      $('#arguments').val('');

      var rel = $("#type option:selected").attr('rel');

       if (rel == "needsargs")
      {
        $('#arguments').show();
      }
      else if ((rel != "false") || (rel != "needsargs"))
      {
        $('#arguments').val(rel);
      }

  });

  //listen for change of select box
  $('#timeType').live("change", function() {

      $("#time1_container").css('display', 'none');
      $("#time2_container").css('display', 'none');
      $('#uniform-timeArgs1 span').html('');
      $('#uniform-timeArgs2 span').html('');

      var value = $(this).val();
      var url1 = "./schedules/getTimes/1";
      var url2 = "./schedules/getTimes/2";
      var url3 = "./schedules/getTimes/3";
      var url4 = "./schedules/getTimes/4";

      if (value=="EVERYXHOURS")
        {
          $.getJSON(url1, function(j){

                var options = '<option value="null" selected="selected">Choose....</option>';

                for (var i = 0; i < j.length; i++) {
                  options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
                }

                $("#timeArgs1").html(options);
                $('#uniform-timeArgs1 span').html('Choose...');
                $("#time1_container").css('display', 'inline');

              })
        }

      if (value=="EVERYXMINUTES")
        {
          $.getJSON(url2, function(k){

                var options = '<option value="null" selected="selected">Choose....</option>';

                for (var i = 0; i < k.length; i++) {
                  options += '<option value="' + k[i].optionValue + '">' + k[i].optionDisplay + '</option>';
                }

                $("#timeArgs1").html(options);
                $('#uniform-timeArgs1 span').html('Choose...');
                $("#time1_container").css('display', 'inline');

              })
        }

      if (value=="ONCEPERDAYAT")
        {
          $.getJSON(url3, function(x){

                var options = '<option value="null" selected="selected">Choose....</option>';

                for (var i = 0; i < x.length; i++) {
                  options += '<option value="' + x[i].optionValue + '">' + x[i].optionDisplay + '</option>';
                }

                $("#timeArgs1").html(options);
                $('#uniform-timeArgs1 span').html('Choose...');
                $("#time1_container").css('display', 'inline');

              })
          $.getJSON(url4, function(y){

                var options = '<option value="null" selected="selected">Choose....</option>';

                for (var i = 0; i < y.length; i++) {
                  options += '<option value="' + y[i].optionValue + '">' + y[i].optionDisplay + '</option>';
                }


                $("#timeArgs2").html(options);
                $('#uniform-timeArgs2 span').html('Choose...');
                $("#time2_container").css('display', 'inline');

              })
        }

      if (value=="XMINUTESPASTEVERYHOUR")
        {
          $.getJSON(url2, function(z){

                var options = '<option value="null" selected="selected">Choose....</option>';

                for (var i = 0; i < z.length; i++) {
                  options += '<option value="' + z[i].optionValue + '">' + z[i].optionDisplay + '</option>';
                }

                $("#timeArgs1").html(options);
                $('#uniform-timeArgs1 span').html('Choose...');
                $("#time1_container").css('display', 'inline');

              })
        }

  });


  $(".confirmCB").click(function(event) {
    var r=confirm("Are you sure you want to install this CraftBukkit version?");
    if (r==true)
      {
        showOverlay('Installing the new Craftbukkit build, please wait!');
      }
    else
      {
      event.preventDefault();
      }
  });


  $("#scheduler").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault();

    /* get some values from elements on the page: */
    var $form = $(this),
        type = $form.find( 'select[name="type"]' ).val(),
        timeType = $form.find( 'select[name="timeType"]' ).val(),
        timeArgs1 = $form.find( 'select[name="timeArgs1"]' ).val(),
        timeArgs2 = $form.find( 'select[name="timeArgs2"]' ).val(),
        args = $form.find( 'input[name="arguments"]' ).val(),
        name = $form.find( 'input[name="name"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post(url, {name: name, arguments: args, timeArgs2: timeArgs2, timeArgs1: timeArgs1, timeType: timeType, type: type},
      function( data ) {

          if (data=="yes")
          {

            notifications.show({msg:"Schedule added", icon:'img/win.png'});

          }

          else
          {

            notifications.show({msg:"Failed adding schedule, check your data", icon:'img/fail.png'});

          }

         Table1.fnReloadAjax("./schedules/getTasks")
      }
    );
  });

  $(".ajax_table1").live('click', (function(){

var source = $(this).attr("href");

$.ajax({
  url: source,
  success: function(data) {
      notifications.show({msg:data, icon:'img/win.png'});
      Table1.fnReloadAjax("./schedules/getTasks")

  }
});
      return false;

}));

  $('.ajax').live('click', function() {
    var href = $(this).attr('href');
    $.ajax({
      url: href,
      success: function(data) {
      }
    });
    return false;
  });

});

</script>