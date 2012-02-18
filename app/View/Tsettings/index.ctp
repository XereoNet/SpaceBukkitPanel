<!-- Navigation -->
<nav id="mainnav">
  <ul> 
        <?php if (($user_perm['pages'] & $glob_perm['pages']['dash']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./dash"> <span class="icon dashboard"></span><?php echo __(' Dashboard') ?></a> </li>
        <?php } ?>
        <?php if (($user_perm['pages'] & $glob_perm['pages']['users']) || ($user_perm['is_super'] == 1)) { ?>
        <li class="bounce fadein"> <a href="./tplayers"> <span class="icon users"></span><?php echo __(' Players ') ?></a> </li>
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
        <li class="current bounce fadein floatright"> <a href="./tsettings"> <span class="icon settings"></span><?php echo __(' Settings ') ?></a> </li>
        <?php } ?>
  </ul>
</nav>
<!-- End Navigation --> 

<!-- Tabs -->
<nav id="smalltabs">
	<ul>
		<li class="current"><a href="#tab1"><?php echo __('Users') ?></a></li>
    <li><a href="#tab2"><?php echo __('Servers') ?></a></li>
    <li><a href="#tab3"><?php echo __('Roles') ?></a></li>
    <li><a href="#tab4"><?php echo __('Themes') ?></a></li>
		<li><a href="#tab5"><?php echo __('SpaceBukkit\'s Settings') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

  <div class="tab nosearch" id="tab1">

    <section class="box boxpad"> 
     
        <header>
            <h2><?php echo __('Users, Servers, Roles') ?></h2> 
        </header>

        <section>


  <small class="bukget_information"><?php echo __('From here you can assign users to servers and a role for each user, on each server. To start, select a user. Then, start adding him to a server, and assing a role to that server.') ?></small>
  <div class="clear"></div>
  <div class="col left col_1_3" style="padding: 30px 60px 0 0; width: 300px; min-height: 500px;background: url(./img/fancy_nav_right.png) no-repeat 95% 50%">

     <table class="datatable dtb1 notitle" id="settings_users" style="cursor: pointer"> 
      <thead> 
        <tr> 
          <th><?php echo __('Name ') ?>
          <a href="./Users/add" class="fancy" style="float: right; margin-right: 5px"><?php echo __('Add new user') ?></a>
          </th>
        </tr> 
      </thead> 
   
      <tbody>
      </tbody> 

      </table>

  </div>
  <div class="col left col_1_3" style="padding: 30px 60px 0 0; width: 300px; min-height: 500px;background: url(./img/fancy_nav_right.png) no-repeat 95% 50%">
      <p class="column_desc" id="c1desc"><?php echo __('Select a user first!') ?></p>
     <table class="datatable dtb2 notitle" id="settings_server" style="cursor: pointer; display: none; width: 300px"> 
      <thead> 
        <tr> 
          <th>
            <?php echo __('Name ') ?>
            <a href="#" class="tip" style="float: right; margin-right: 5px"><?php echo __('Add to a server') ?></a>
            <div class="tooltip white server_add_to_list">
              <ul id="server_ad_to_list">
                <?php echo __('loading') ?>
              </ul>
            </div>            
          </th> 
        </tr> 
      </thead> 
   
      <tbody>
      </tbody> 
      </table>

  </div>

  <div class="col left col_1_3" style="padding: 150px 0 0 30px; width: 100px; font-size: 23px;">

    <div id="settings_role" style="display: none;">
    </div>
    <div id="saving_role" style="display: none;"><?php echo __('Saving....') ?></div>

  </div>
    <div class="clear"></div>
   
   </section>

   </section>

  </div>
  <!-- End tab1 -->

  <div class="tab" id="tab2">

  <div class="table_container">

    <header>

      <h2><?php echo __('Servers') ?></h2>
      <a href="./servers/add"  class="button icon fancy add"><?php echo __('Add Server') ?></a>

    </header>

   <table class="datatable dtb4"> 
      <thead> 
        <tr> 
          <th><?php echo __('Name') ?></th> 
          <th><?php echo __('Action') ?></th> 
        </tr> 
      </thead> 
      <tbody>
      </tbody> 
    </table> 

    </div>

  <div class="clear"></div>

  </div><!-- End tab2 -->

  <div class="tab" id="tab3">

      <p class="bukget_information"><?php echo __('If you delete a role, every user with that role on a server will acquire the "fallback" role.') ?></p>
     <div class="table_container">

    <header>

      <h2><?php echo __('Roles') ?></h2>

    <a href="./roles/add"  class="button icon fancy add"><?php echo __('Add Role') ?></a>

    </header>

   <table class="datatable dtb3"> 
      <thead> 
        <tr> 
          <th><?php echo __('Name') ?></th> 
          <th><?php echo __('Action') ?></th> 
          <th><?php echo __('Default') ?></th> 
        </tr> 
      </thead> 
      <tbody>
      </tbody> 
    </table> 
    </div>
  <div class="clear"></div>

  </div><!-- End tab3 -->  

  <div class="tab" id="tab4">
<div class="clear"></div>
<br><br>
  <div class="table_container">

    <header>

      <h2><?php echo __('Themes') ?></h2>

    </header>
   <table class="datatable dtb"> 
      <thead> 
        <tr> 
          <th><?php echo __('Thumbnail') ?></th> 
          <th><?php echo __('Theme') ?></th> 
          <th><?php echo __('Version') ?></th> 
          <th><?php echo __('Author') ?></th> 
          <th><?php echo __('Description') ?></th> 
          <th><?php echo __('Link') ?></th> 
          <th><?php echo __('Action') ?></th> 
        </tr> 
      </thead> 
      <tbody> 
  	<?php include 'findthemes.php'; ?>
      </tbody> 
    </table> 

   </div>
  <div class="clear"></div>

  </div><!-- End tab4 -->

  <div class="tab" id="tab5">

    <div class="col left col_2_3">

        <section class="box boxpad"> 
         
          <header>
                <h2><?php echo __('SpaceBukkit Database Settings') ?></h2> 
          </header>
            
          <section>
            <form id="ServerAddForm" method="post" action="./tsettings/update_config">
  
              <section>
                <label for="host">
                  <?php echo __('Host*') ?>
                </label>
              
                <div>
                  <input id="host" name="host" type="text" value="<?php echo $configurations->config['host']; ?>"/>
                </div>
              </section>
            
              <section>
                <label for="login">
                  <?php echo __('Login*') ?>
                </label>
              
                <div>
                  <input type="text" id="login" name="login" value="<?php echo $configurations->config['login']; ?>"/>
                </div>
              </section>

              <section>
                <label for="password">
                  <?php echo __('Password*') ?>
                </label>
              
                <div>
                  <input type="password" id="password" name="password" value="<?php echo $configurations->config['password']; ?>"/>
                </div>
              </section>

              <section>
                <label for="database">
                  <?php echo __('Database*') ?>
                </label>
              
                <div>
                  <input type="text" id="database" name="database" value="<?php echo $configurations->config['database']; ?>"/>
                </div>
              </section>
            
             
          <input type="submit" class="button primary submit" value="<?php echo __('Submit') ?>">
          </form>

          </section> 
                                
        </section>

        <div class="clear"></div>

        <br>
    </div>

    <div class="col right col_1_3">

        <div class="colorbox green boxpad">
            <h3><?php echo __('Configuring Spacebukkit') ?></h3> 
            <p> 
                <?php echo __('Here you can reconfigure your database settings.') ?></a>
            </p> 
        </div> 

        <div class="clear"></div>
        <br />
    </div>
   
  <div class="clear"></div>

  </div>
  <!-- End tab5 -->


</section>
<!-- End #content --> 

<script>

/* Get the rows which are currently selected */
function fnGetSelected( oTableLocal )
{
  var aReturn = new Array();
  var aTrs = oTableLocal.fnGetNodes();
  
  for ( var i=0 ; i<aTrs.length ; i++ )
  {
    if ( $(aTrs[i]).hasClass('row_selected') )
    {
      aReturn.push( aTrs[i] );
    }
  }
  return aReturn;
}

$('document').ready(function() {

  var user;

  /* Add a click handler to the rows - this could be used as a callback */
    $("#settings_users tbody").click(function(event) {
      $(Table1.fnSettings().aoData).each(function (){
        $(this.nTr).removeClass('row_selected');
      });
      $(event.target.parentNode).addClass('row_selected');

      user = $(".row_selected span").text();

      var server = './tsettings/getServer/'+user; 
      var noserver = './tsettings/getNoServer/'+user;

      $('.dtb2').fadeIn(700);
      $('#c1desc').text("").hide();
      $('#settings_role').fadeOut(700);

      $('#server_ad_to_list').html(ajax_load).load(noserver);

      Table2 = $('.dtb2').dataTable( {
      "bDestroy": true,   
      "bProcessing": true,
      "sAjaxSource": server
      });

    });

    $("#settings_server tbody").click(function(event) {
      $(Table2.fnSettings().aoData).each(function (){
        $(this.nTr).removeClass('row2_selected');
      });
      $(event.target.parentNode).addClass('row2_selected');

      var usr = $(".row2_selected span").attr("title");

      var role = './tsettings/getRole/'+usr; 

      $('#settings_role').html(ajax_load).load(role).show().uniform();

    });
      
  //initiate Tables
  Table1 = $('.dtb1').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tsettings/getUsers'
  });
      
  Table3 = $('.dtb3').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tsettings/getRoles'
  });
      
  Table4 = $('.dtb4').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tsettings/getServers'
  });
     
   //listen for change of select box
  $('#roleSelect').live("change", function() {
    $('#saving_role').text("Saving...").fadeIn();
          
      /* get some values from elements on the page: */
      var $form = $("#role_select"),
          server_id = $form.find( 'input[name="server_id"]' ).val(),
          user_id = $form.find( 'input[name="user_id"]' ).val(),
          role_id = $form.find( 'select[name="role_id"]' ).val(),
          url = $form.attr( 'action' );

      /* Send the data using post and put the results in a div */
      $.post(url, {server_id: server_id, user_id: user_id, role_id: role_id},
        function( data ) {
          $('#saving_role').text(data).delay(2000).fadeOut();
          }
      );

  });

});
</script>