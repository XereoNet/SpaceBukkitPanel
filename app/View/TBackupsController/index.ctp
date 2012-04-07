<!-- Tabs -->
<nav id="smalltabs">
	<ul>
		<li class="current"><a href="#tab1"><?php echo __('Overview') ?></a></li>
		<li><a href="#tab2"><?php echo __('Worlds') ?></a></li>
    <li><a href="#tab3"><?php echo __('Plugins') ?></a></li>
    <li><a href="#tab4"><?php echo __('Server') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

<div class="tab" id="tab1">

  <section class="box">

    <header>
        <h2><?php echo __('Backups Overview') ?></h2> 
    </header>

    <section>

      <div class="col left">

        Timeline

      </div>

      <div class="col left">

        Stats

      </div>

    </section>

  </section>

  <div class="clear"></div>

</div>

<div class="tab" id="tab2">

  <section class="grid_view"> 

  <div class="col col_1_3 left">

    <section>
      <label for="CPU">
        CPU: 
      </label>

      <div>
        <?php echo $ServerSpecs['CPU']; ?><br>
      </div>
    </section>

    <section>
      <label for="Java">
        Java Version: 
      </label>

      <div>
        <?php echo $ServerSpecs['Java']; ?><br>
      </div>
    </section>

    <section>
      <label for="Bukkit">
        Bukkit Version: 
      </label>

      <div>
        <?php echo $ServerSpecs['Bukkit']; ?><br>
      </div>
    </section>

  </div>


  <div class="col col_1_3 left">

      <section>
        <label for="Architecture">
          Architecture: 
        </label>

        <div>
          <?php echo $ServerSpecs['arch']; ?><br>
        </div>
      </section>
        <section>
          <label for="OS">
            Operating System: 
          </label>

          <div>
            <?php echo $ServerSpecs['OS']; ?><br>
          </div>
        </section>

        <section>
          <label for="SB">
            SpaceBukkit Version: 
          </label>

          <div>
            <?php echo $ServerSpecs['SpaceBukkit']; ?><br>
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
        <?php echo $ServerSpecs['RAM']; ?><br>
      </div>
    </section>

    <section>
      <label for="Disk">
        Disk Space: 
      </label>

      <div>
        <?php echo $ServerSpecs['Disk']; ?><br>
      </div>
    </section>


        <section>
          <label for="Web">
            Webserver Version: 
          </label>

          <div>
            <?php echo $ServerSpecs['Web']; ?><br>
          </div>
        </section>
  </div>

  <div class="clear"></div>
       
       
</section>

  <div class="clear"></div>

</div>


<div class="tab" id="tab3">

  <div class="clear"></div>

</div>


<div class="tab" id="tab4">

  <div class="clear"></div>

</div>
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