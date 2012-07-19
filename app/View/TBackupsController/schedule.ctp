<nav id="mainnav" class="popup">
    <h3>Schedule backup</h3>
</nav>
<nav id="popuptabs">
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 
    <section>

      <div class="error_box"></div>
        <form id="scheduler" class="scheduler" method="post" action="./tbackups/schedule">

      <div class="col left">

      <input id="name" name="name" type="text" style="display: block;" placeholder="Schedule title">

      <br>

      <select name="type" id="type">

      <option value="server">Server</option>
      <option value="plugins">Plugins</option>
      <option value="world">World</option>

      </select> 

      <br><br>

      <select name="sworlds" id="sworlds">
        <?php 
          foreach ($worlds as $world) {
            echo '<option value="'.$world.'">'.$world.'</option>';
          }
        ?>
      </select>

      </div>

      <div class="col right">

       <select name="timeType" id="timeType">

        <option value="0" selected="selected">Time type</option>
        <option value="EVERYXHOURS">Every X Hours</option>
        <option value="EVERYXMINUTES">Every X Minutes</option>
        <option value="ONCEPERDAYAT">Once per day at</option>
        <option value="XMINUTESPASTEVERYHOUR">At X minutes after every hour</option>

      </select>   

      <br><br>

      <div id="time1_container" style="display: none;">

      <select name="timeArgs1" id="timeArgs1">

        <option value="null">Choose...</option>

      </select>  

      </div>

      <br><br>


      <div id="time2_container" style="display: none;">
      :
      <select name="timeArgs2" id="timeArgs2">

      </select>  

      </div>

      </div>

      <div class="clear"></div>
      <br>
      <input type="submit" class="button primary submit big leftsubmit" style="" value="<?php echo __('Add this schedule') ?>">
         

     </form>

    </section> 
               
 </section>

<div class="clear"></div>
</section>
<!-- End #content --> 
<script type="text/javascript">
  /* schedules */
$('document').ready(function() {
   $('#sworlds').hide();        

   var value = $("#type option:selected").attr('value');

   if (value === "world")
      {
        $('#sworlds').fadeIn();
      }

  //listen for change of select box
  $('#type').live("change", function() {
      
      $('#sworlds').hide();

      var value = $("#type option:selected").attr('value');

       if (value === "world")
      {
        $('#sworlds').show();
      }

  });

  var lworld;

  $('#sworlds').live("change", function() {
       lworld = $("#sworlds option:selected").attr('value');
  });

  $(".scheduler").live("submit", function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $(this),
        lname = $form.find( 'input[name="name"]' ).val(),
        ltype = $form.find( 'select[name="type"]' ).val(),
        ltimetype = $form.find( 'select[name="timeType"]' ).val(),
        ltimeargs1 = $form.find( 'select[name="timeArgs1"]' ).val(),
        ltimeargs2 = $form.find( 'select[name="timeArgs2"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post(url, {name: lname, type: ltype, world: lworld, timetype: ltimetype, timeargs1: ltimeargs1, timeargs2: ltimeargs2},
      function( data ) {
        
      }
    );
    
    $.nmTop().close();
    
    return false;

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
});
</script>