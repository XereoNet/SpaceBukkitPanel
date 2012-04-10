<style>

  .b-home {
    color: white; 
    border: 1px solid #333;
    border-top: 1px solid #444;
    background: #2D2D2D;
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzJkMmQyZCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMyMTIxMjEiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top, #2D2D2D 0%, #212121 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#2D2D2D), color-stop(100%,#212121));
    background: -webkit-linear-gradient(top, #2D2D2D 0%,#212121 100%);
    background: -o-linear-gradient(top, #2D2D2D 0%,#212121 100%);
    background: -ms-linear-gradient(top, #2D2D2D 0%,#212121 100%);
    background: linear-gradient(top, #2D2D2D 0%,#212121 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2d2d2d', endColorstr='#212121',GradientType=0 );
  }

  .b-home h2 {
    font-size: 25px;
    margin: 14px 0;
    text-shadow: 0 1px 0 #555;
    color: #EEE;
  }

  .b-home > section {
    padding: 0;
  }

  .b-home div.left {

  }
  .b-home div.right {

  }

  .b-home > div > div {
    margin: 10px;
  }


  /* "DARK WELL" style */

  .darkwell {
    border: 1px solid #111;
    border-radius: 6px;
    background: #191919;
    background: -moz-linear-gradient( top, #191919 0%, #111 100% );
    background: -webkit-linear-gradient( top, #191919 0%, #111 100% );
    background: -o-linear-gradient( top, #191919 0%, #111 100% );
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.2), 0 1px 0 #676767;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
  }
  .darkwell h3 {
    font-size: 19px;
    text-shadow: 0 1px 0 #000;
    color: #EEE;
  }
  .darkwell .b-what {
    font-size: 15px;
    line-height: 25px;
    font-weight: normal;
    color: #aaa;
    display: inline;
  }
  .darkwell .b-in {
    font-size: 12px;
    line-height: 25px;
    font-weight: normal;
    color: #676767;
    display: inline;
  }
  .darkwell .b-when {
    font-size: 15px;
    line-height: 25px;
    font-weight: normal;
    color: #aaa;
    display: inline;
    float: right;
  }
  .darkwell > section {
    border-top: 1px solid rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    padding-top: 4px;
    padding: 15px;
  }

</style>

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

  <section class="b-home">

    <div class="col left">

      <div>

        <section class="b-now">

          <h2>Running now:</h2>


            <div class="darkwell">

              <section>

                <h3>Backup of world "home_the_end"</h3>

                <div class="b-what">Started 20 minutes ago</div>
                <div class="b-in">(12th Feb 2012 20:40)</div>
                <div class="b-when">Currently 20 MB</div>
                <div class="clear"></div>

                <br><br>

                <div class="progress-new progress-striped active">
                  <div class="bar" style="width: 40%"></div>
                </div>

              </section>

            </div>

        </section>

        <section class="b-now">

          <h2>Next Backups:</h2>

            <div class="darkwell">

              <section>
                <div class="b-what">World "home"</div>
                <div class="b-in">in 20 minutes...</div>
                <div class="b-when">12th Feb 2012 21:00</div>
              </section>
              <section>
                <div class="b-what">Complete Server</div>
                <div class="b-in">in 50 minutes...</div>
                <div class="b-when">12th Feb 2012 21:30</div>
              </section>
              <section>
                <div class="b-what">World "home_nether"</div>
                <div class="b-in">in 1 hour...</div>
                <div class="b-when">12th Feb 2012 22:00</div>
              </section>

            </div>

        </section>

      </div>

    </div>

    <div class="col right">

      <div>Stats</div>

    </div>

    <div class="clear"></div>

  </section>


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