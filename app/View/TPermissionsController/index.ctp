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
  <div class="col left col_1_3" style="padding: 30px 60px 0 0; width: 400px; min-height: 500px;background: url(./img/fancy_nav_right.png) no-repeat 95% 50%">

     <table class="datatable groups-groups notitle" id="groups_groups" style="cursor: pointer"> 
      <thead> 
        <tr> 
          <th><?php echo __('World') ?></th>
          <th><?php echo __('Group') ?></th>
          <th width="140px"><?php echo __('Actions') ?>
            <a href="./Tpermissions/addGroup" class="fancy" style="float: right; margin-right: 5px"><?php echo __('Add'); ?></a>
          </th>
        </tr> 
      </thead> 
   
      <tbody>
      </tbody> 

      </table>

  </div>
  <div class="col left col_1_3" style="padding: 30px 60px 0 0; width: 300px; min-height: 500px;background: url(./img/fancy_nav_right.png) no-repeat 95% 50%">
      <p class="column_desc" id="c1desc"><?php echo __('Select a group first!') ?></p>
     <table class="datatable groups-plugins notitle" id="groups_plugin" style="cursor: pointer; display: none; width: 300px"> 
      <thead> 
        <tr> 
          <th>
            <?php echo __('Plugin') ?>
            
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
      $(TableGG.fnSettings().aoData).each(function (){
        $(this.nTr).removeClass('row_selected');
      });
      $(event.target.parentNode).addClass('row_selected');

      group = $(".row_selected td")[0].textContent;

      var plugins = './tpermissions/getPlugins/'; 

      $('.groups-plugins').fadeIn(700);
      $('#c1desc').text("").hide();
      $('#groups_perm').fadeOut(700);

      TableGP = $('.groups-plugins').dataTable( {
      "bDestroy": true,   
      "bProcessing": true,
      "sAjaxSource": plugins
      });

    });

    $("#groups_plugin tbody").click(function(event) {
      $(TableGP.fnSettings().aoData).each(function (){
        $(this.nTr).removeClass('row2_selected');
      });
      $(event.target.parentNode).addClass('row2_selected');

      var world = $(".row_selected td")[0].textContent;

      var group = $(".row_selected td")[1].textContent;

      var plugin = $(".row2_selected td").textContent;

      var perms = './tpermissions/getGaPPerms/'+world+'/'+group+'/'+plugin; 

      $('#groups_perm').html(ajax_load).load(perms, function() {
        supernifty_tristate.init();
        $(".tip").tooltip({
          position: "bottom center",
          effect: "fade",
          relative: "true"
        }, function() { console.log('tip');});
      }).show().uniform();
    });

$('#newperm').live('keyup', function(e) {

    if ( e.keyCode === 13 ) { // 13 is enter key

        var world = $(".row_selected td")[0].textContent;

        var group = $(".row_selected td")[1].textContent;

        var plugin = $(".row2_selected td").textContent;

        var perm = this.value;


    }
});
    
      
  //initiate Tables
  TableGG = $('.groups-groups').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tpermissions/getgroups'
  });
});

</script>