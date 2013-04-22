<!-- Content -->

Deactivated for now since it's not functional, we are working on a fix!

<!-- <section id="content">
<div class="error_box"></div>

        <form id="schedform" class="scheduler" method="post" action="./tbackups/schedule">
      <div class="error_box"></div>

      <section>

        <label for="name">Backup title</label>
        <div>
          <input id="name" name="name" type="text" placeholder="Backup title">
          <p class="help-block">Give your backup a unique name</p>
        </div>

      </section>

      <section>

        <label for="name">Type</label>
        <div>

          <select name="type" id="type">

              <option value="server">Complete Server</option>
              <option value="plugins">All plugins</option>
              <option value="world">A world</option>

          </select>
        </div>

      </section>

      <section>

        <label for="name">Time type</label>
        <div>

           <select name="timeType" id="timeType">

            <option value="0" selected="selected">Time type</option>
            <option value="EVERYXHOURS">Every X Hours</option>
            <option value="EVERYXMINUTES">Every X Minutes</option>
            <option value="ONCEPERDAYAT">Once per day at</option>
            <option value="XMINUTESPASTEVERYHOUR">At X minutes after every hour</option>

          </select>

          <p class="help-block">What kind of time type do you want?</p>
        </div>

      </section>

      <section>

        <label id="timeargslabel" for="timeArgs1" style="display: none">Time arguments</label>

          <div id="time1_container" style="display: none; margin: 0">

            <select name="timeArgs1" id="timeArgs1">

            <option value="null">Choose...</option>

          </select>

          </div>

        <div id="time2_container" style="display: none; margin: 0">
          :
          <select name="timeArgs2" id="timeArgs2">

          </select>

        </div>

      </section>

        <input type="submit" class="button primary submit big leftsubmit" value="<?php echo __('Add this schedule') ?>">

    <div class="clear"></div>

  </form>

</div>

<script>

/* schedules */

   $('#argcont').hide();

   var rel = $("#type option:selected").attr('rel');

   if (rel == "needsargs")
      {
        $('#argcont').fadeIn();
      }
    else if ((rel != "false") || (rel != "nee"))
      {
        $('#arguments').val(rel);
      }

  //listen for change of select box
  $('#type').live("change", function() {

      $('#argcont').hide();

      $('#arguments').val('');

      var rel = $("#type option:selected").attr('rel');

       if (rel == "needsargs")
      {
        $('#argcont').show();
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
      $('#timeargslabel').css('display', 'none');
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
            $('#timeargslabel').css('display', 'inline');

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
            $('#timeargslabel').css('display', 'inline');

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
            $('#timeargslabel').css('display', 'inline');

              })
          $.getJSON(url4, function(y){

                var options = '<option value="null" selected="selected">Choose....</option>';

                for (var i = 0; i < y.length; i++) {
                  options += '<option value="' + y[i].optionValue + '">' + y[i].optionDisplay + '</option>';
                }


                $("#timeArgs2").html(options);
                $('#uniform-timeArgs2 span').html('Choose...');
                $("#time2_container").css('display', 'inline');
            $('#timeargslabel').css('display', 'inline');

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
            $('#timeargslabel').css('display', 'inline');

              })
        }

  });



  $("#schedform").submit(function(event) {

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

            setTimeout(function() {$.nmTop().close();}, 300);
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

</script> -->