<!-- Navigation -->
<nav id="mainnav">
  <ul> 
        <?php if (($user_perm['pages'] & $glob_perm['pages']['dash']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./dash"> <span class="icon dashboard"></span><?php echo __(' Dashboard') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['users']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="current bounce fadein"> <a href="./tplayers"> <span class="icon users"></span><?php echo __(' Players ') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['plugins']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./tplugins"> <span class="icon plugins"></span><?php echo __(' Plugins ') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['worlds']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./tworlds"> <span class="icon world"></span><?php echo __(' Worlds ') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['server']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./tservers"> <span class="icon server"></span><?php echo __(' Server ') ?></a> </li>
        <?php } ?>
        <?php if ($is_super == 1) { ?>
        <li class="bounce fadein floatright"> <a href="./tsettings"> <span class="icon settings"></span><?php echo __(' Settings ') ?></a> </li>
        <?php } ?>
  </ul>
</nav>
<!-- End Navigation --> 

<!-- Tabs -->
<nav id="smalltabs">
	<ul>
		<li class="current"><a href="#tab1"><?php echo __('Online') ?></a></li>
		<li><a href="#tab2"><?php echo __('Whitelist') ?></a></li>
		<li><a href="#tab3"><?php echo __('Blacklist') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

<div class="tab" id="tab1">

  <div class="table_container">

    <header>

      <h2><?php echo __('Online Players') ?></h2>
      <a href="#" id="update_players" class="button icon reload floatright" style="right: 250px"><?php echo __('Refresh') ?></a>

    </header>
    
    <table class="datatable adtb">
      <thead> 
        <tr> 
          <th width="40px"><?php echo __('Avatar')?></th>
          <th><?php echo __('Status') ?></th> 
          <th><?php echo __('Username') ?></th> 
          <th><?php echo __('Gamemode') ?></th> 
          <th><?php echo __('Operator') ?></th> 
          <th width="400px"><?php echo __('Actions') ?></th> 
        </tr> 
      </thead> 

      <tbody>
      </tbody> 

    </table> 

  </div>

    <div class="clear"></div>

</div>

<div class="tab" id="tab2">

<div class="col left">

  <div class="table_container">

    <header>

      <h2><?php echo __('Whitelisted Players') ?></h2>

    </header>
    
    <table class="datatable adtb2"> 
      <thead> 
        <tr> 
          <th><?php echo __('Avatar') ?></th> 
          <th><?php echo __('Username') ?></th> 
          <th><?php echo __('Actions') ?></th> 
        </tr> 
      </thead> 
      <tbody> 
      </tbody> 
    </table> 
    <br />

    </div>

    <div class="clear"></div>

  </div>

<div class="col right">

  <section class="box"> 
   
    <header>
        <h2><?php echo __('Add User') ?></h2> 
    </header>
    
    <section>
    <form id="whitelist_add" class="bwl1" method="post" action="./tplayers/whitelist_add">

    <fieldset>
     
    <label for="title">
    <?php echo __('Name') ?>
    </label>

    <div>
    <input id="name" name="name" type="text" />
    <input type="submit" class="button big primary submit" value="<?php echo __('Add') ?>">

    </div>
      </fieldset>

    </form>


  </section> 
  
</div><!-- End col right -->

</div>

<div class="tab" id="tab3">

<div class="col left">

  <div class="table_container">

    <header>

      <h2><?php echo __('Blacklisted Players') ?></h2>

    </header>

  <table class="datatable adtb3"> 
    <thead> 
      <tr> 
        <th><?php echo __('Avatar') ?></th> 
        <th><?php echo __('Username') ?></th> 
        <th><?php echo __('Actions') ?></th> 
      </tr> 
    </thead> 
    <tbody> 
      <tr> 
        <td><img src="img/creeper.jpg" /></td> 
        <td><?php echo __('Creeper') ?></td> 
        <td> 
          <span class="button-group"> 
            <a href="#" class="button icon arrowdown danger"><?php echo __('Remove') ?></a>            
          </span> 
        </td> 
      </tr> 
      <tr> 
        <td><img src="img/creeper.jpg" /></td> 
        <td><?php echo __('User') ?></td> 
        <td> 
          <span class="button-group"> 
            <a href="#" class="button icon arrowdown danger"><?php echo __('Remove') ?></a>            
          </span> 
        </td> 
      </tr> 
      </tbody> 
  </table> 

  </div>

  <div class="clear"></div>

</div>

<div class="col right">

  <section class="box"> 
   
    <header>
        <h2><?php echo __('Add User') ?></h2> 
    </header>
    
    <section>
    <form id="ban" class="bwl2" method="post" action="./tplayers/blacklist_add">

    <fieldset>
     
    <label for="title">
    <?php echo __('Name') ?>
    </label>

    <div>
    <input id="name" name="name" type="text" />
    <input type="submit" class="button big primary submit" value="<?php echo __('Add') ?>">

    </div>
    </form>
    </fieldset>


  </section> 
</div><!-- End col right -->

</div>

<div class="clear"></div>
</section>
<!-- End #content --> 
<script>
$('document').ready(function() {

  Table1 = $('.adtb').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tplayers/getPlayers'

  } );
  Table2 = $('.adtb2').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tplayers/getWhitelist'

  } );  
  Table3 = $('.adtb3').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tplayers/getBlacklist'

  } );

  var refreshId = setInterval(function() {
    $.get('./tplayers/shouldIgetPlayers', function(data) {
    if(data == '1') {
      Table1.fnReloadAjax("./tplayers/getPlayers")
    } 
    });
}, '8000');

  $('#update_players').click(function() {
    Table1.fnReloadAjax("./tplayers/getPlayers")
  });

  $(".bwl1").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $(this),
        term = $form.find( 'input[name="name"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post(url, {name: term},
      function( data ) {
         notifications.show({msg:data, icon:'img/win.png'});
         Table2.fnReloadAjax("./tplayers/getWhitelist")
      }
    );
  });

  $(".bwl2").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $(this),
        term = $form.find( 'input[name="name"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post(url, {name: term},
      function( data ) {
         notifications.show({msg:data, icon:'img/win.png'});
         Table3.fnReloadAjax("./tplayers/getBlacklist")
      }
    );
  });

$(".ajax_table2").live('click', (function(){

  var source = $(this).attr("href");
  
$.ajax({
  url: source,
  success: function(data) {
      notifications.show({msg:data, icon:'img/win.png'});
      Table2.fnReloadAjax("./tplayers/getWhitelist")

  }
});
      return false;

}));

$(".ajax_table3").live('click', (function(){

  var source = $(this).attr("href");
  
$.ajax({
  url: source,
  success: function(data) {
      notifications.show({msg:data, icon:'img/win.png'});
      Table3.fnReloadAjax("./tplayers/getBlacklist")

  }
});
      return false;

}));

$(".ajax_table1").live('click', (function(){

var source = $(this).attr("href");
  
$.ajax({
  url: source,
  success: function(data) {
      notifications.show({msg:data, icon:'img/win.png'});
      Table1.fnReloadAjax("./tplayers/getPlayers")

  }
});
      return false;

}));

});

</script>