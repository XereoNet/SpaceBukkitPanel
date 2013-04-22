<nav id="mainnav" class="popup">
  <div class="col left">
    <h3>Configure <?php echo $plugin_name;?></h3>
  </div>
  <div class="col right">
    <a href="#" id="savecfg" class="button primary submit" >Save</a>
    <a href="#" id="reloadcfg" class="button primary submit" >Save & Reload Server</a>
    <a href="#" id="restartcfg" class="button primary submit" >Save & Restart Server</a>
  </div>

</nav>

<!-- Content -->
<section id="content" style="width: 960px; height: 600px; overflow: hidden; padding: 0">

  <div class="col col_1_3 left" style="max-height: 600px; height: 600px; overflow: auto">

    <div id="tree">

    </div>

  </div>

  <div class="col col_2_3 right" style="height: 100%; width: 68%; background: #555">

    <div id="editor">Choose a file on the left!</div>

  </div>

  <div class="clear"></div>

</section>
<style>
     #editor {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>

<script type="text/javascript">
$(document).ready(function() {

  var editor = ace.edit("editor");
  changed = false;
  selected = "";

  editor.setTheme("ace/theme/monokai");
  editor.getSession().setMode("ace/mode/yaml");
  editor.on('change', function(e) {
    changed = true;
  })

  $('li[data-type="file"]').live('click', function(event) {
    if(selected == "") {
      selected = $(this).children("a");
    }
    if(changed && !confirm('You have not saved the changes to this file. You will loose your changes if switch to another file now!')) {
      $('a.jstree-clicked').removeClass('jstree-clicked');
      selected.addClass('jstree-clicked');
      return false;
    } else {
      selected = $(this).children("a");
      $.ajax({
        url: './tplugins/loadFile/'+$(this).data('path'),
        success: function(data) {

          editor.getSession().setValue(data);
          changed = false;

        }
      });

    }
    return false;

  })

  $("#tree")

  //load the tree

  .jstree({

    "core" : { "initially_open" : [ "root" ] },

    "json_data" : {
      "ajax" : {
        "url" : "./tplugins/loadTree/",
        "data" : function (n) {
          return { path : n.attr ? n.attr("data-path") : '.@@plugins@@<?php echo $plugin_name; ?>' };
        }
      }
    },

    "plugins" : [ "themes", "json_data", "ui" ],

    "themes" : {
      "theme" : "classic",
      "dots" : true,
      "icons" : true
    }

  })

  $('#savecfg').click(function() {

    $.ajax({
      type: 'POST',
      url: "./tplugins/SaveConfig",
      data: {
        path : $('a.jstree-clicked').parent('li').data('path'),
        config_content : editor.getSession().getValue(),
        method: false
      },
      success: function(data) {
        notifications.show({msg:"Saved!", icon:'img/win.png'});
      }
    });

  });
  $('#reloadcfg').click(function() {
    $.ajax({
      type: 'POST',
      url: "./tplugins/SaveConfig",
      data: {
        path : $('a.jstree-clicked').parent('li').data('path'),
        config_content : editor.getSession().getValue(),
        method: "reload"
      },
      success: function(data) {
        notifications.show({msg:"Saved!", icon:'img/win.png'});
      }
    });

  });
  $('#restartcfg').click(function() {
    $.ajax({
      type: 'POST',
      url: "./tplugins/SaveConfig",
      data: {
        path : $('a.jstree-clicked').parent('li').data('path'),
        config_content : editor.getSession().getValue(),
        method: "restart"
      },
      success: function(data) {
        notifications.show({msg:"Saved!", icon:'img/win.png'});
      }
    });

  });

});
</script>
