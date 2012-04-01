<!-- Tabs -->
<nav id="smalltabs">
	<ul>
		<li class="current"><a href="#tab1"><?php echo __('Groups') ?></a></li>
		<li><a href="#tab2"><?php echo __('Players') ?></a></li>
		<li><a href="#tab3"><?php echo __('Settings') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

<div class="tab nosearch" id="tab1">

    <section class="box boxpad"> 
     
        <header>
            <h2><?php echo __('Group Permissions') ?></h2> 
        </header>

        <section>


  <small class="bukget_information"><?php echo __('From here you can add permissions per group/per plugin.') ?></small>
  <div class="clear"></div>
  <div class="col left col_1_3" style="padding: 30px 60px 0 0; width: 300px; min-height: 500px;background: url(./img/fancy_nav_right.png) no-repeat 95% 50%">

     <table class="datatable dtb1 notitle" id="groups_groups" style="cursor: pointer"> 
      <thead> 
        <tr> 
          <th><?php echo __('Group ') ?>
          <a href="./Tpermissions/addGroup" class="fancy" style="float: right; margin-right: 5px"><?php echo __('Add new group') ?></a>
          </th>
        </tr> 
      </thead> 
   
      <tbody>
      </tbody> 

      </table>

  </div>
  <div class="col left col_1_3" style="padding: 30px 60px 0 0; width: 300px; min-height: 500px;background: url(./img/fancy_nav_right.png) no-repeat 95% 50%">
      <p class="column_desc" id="c1desc"><?php echo __('Select a group first!') ?></p>
     <table class="datatable dtb2 notitle" id="groups_plugin" style="cursor: pointer; display: none; width: 300px"> 
      <thead> 
        <tr> 
          <th>
            <?php echo __('Plugin ') ?>
            
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

  <div class="col left col_1_3" style="padding: 30px 0 0 30px; width: 250px; font-size: 16px;">

    <div id="groups_perm" style="display: none;">
    </div>

    <div id="groups_sav_perm" style="display: none;"><?php echo __('Saving....') ?></div>

  </div>
    <div class="clear"></div>
   
   </section>

   </section>

  <div class="clear"></div>

</div>

<div class="tab" id="tab2">

  <div class="clear"></div>

</div>

<div class="tab" id="tab3">

  <div class="clear"></div>

</div>

<div class="clear"></div>
</section>


<!-- End #content --> 
<script type="text/javascript" src="./js/tristate.js"></script>
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
    $("#groups_groups tbody").click(function(event) {
      $(Table1.fnSettings().aoData).each(function (){
        $(this.nTr).removeClass('row_selected');
      });
      $(event.target.parentNode).addClass('row_selected');

      group = $(".row_selected span").text();

      var plugins = './tpermissions/getPlugins/'; 

      $('.dtb2').fadeIn(700);
      $('#c1desc').text("").hide();
      $('#groups_perm').fadeOut(700);

      Table2 = $('.dtb2').dataTable( {
      "bDestroy": true,   
      "bProcessing": true,
      "sAjaxSource": plugins
      });

    });

    $("#groups_plugin tbody").click(function(event) {
      $(Table2.fnSettings().aoData).each(function (){
        $(this.nTr).removeClass('row2_selected');
      });
      $(event.target.parentNode).addClass('row2_selected');

      var group = $(".row_selected span").text();

      var plugin = $(".row2_selected span").text();

      var perms = './tpermissions/getGaPPerms/'+group+'/'+plugin; 

      $('#groups_perm').html(ajax_load).load(perms, function() {
        supernifty_tristate.init();
        $(".tip").tooltip({
          position: "bottom center",
          effect: "fade",
          relative: "true"
        }, function() { console.log('tip');});
      }).show().uniform();
    });

    
      
  //initiate Tables
  Table1 = $('.dtb1').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tpermissions/getgroups'
  });

  function update_tristate(id) {
          var group = $(".row_selected span").text();

      var perm = $(this).attr('id');

      var newState = $(this).children('input[type="hidden"]').val();

      var url = './tpermissions/saveGaPPerm/' + group + '/' + perm + '/' + newState;

      $.ajax({url: url, complete: function(data){
        console.log(data.responseText);
        if (data.responseText === 'true'){
          supernifty_tristate.update(id);
        }
      }});
  }

     
   //listen for change of select box
  $('#roleSelect').live("change", function() {
    $('#groups_sav_perm').text("Saving...").fadeIn();
          
      /* get some values from elements on the page: */
      var $form = $("#role_select"),
          server_id = $form.find( 'input[name="server_id"]' ).val(),
          user_id = $form.find( 'input[name="user_id"]' ).val(),
          role_id = $form.find( 'select[name="role_id"]' ).val(),
          url = $form.attr( 'action' );

      /* Send the data using post and put the results in a div */
      $.post(url, {server_id: server_id, user_id: user_id, role_id: role_id},
        function( data ) {
          $('#groups_sav_perm').text(data).delay(2000).fadeOut();
          }
      );

  });

});

</script>