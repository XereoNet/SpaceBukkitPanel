<nav id="mainnav" class="popup">
    <h3>Change time</h3>
</nav>
<nav id="popuptabs">
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

<div class="buttons"><center><br><br><?php echo __('Notice: If you\'re running MultiVerse, please update to the latest dev version ;)'); ?><br><br>
<h1><?php echo "World: ".$wrld; ?></h1><br><?php echo __("Your current time is: ").$time; ?><br><br><?php echo __('Set time to:'); ?><br><br>
<span class="button-group">
<a href="./tworlds/setTime/<?php echo $wrld; ?>/0700" class="button icon clock ajax_table1" onclick="$.nmTop().close();"><?php echo __('Sunrise'); ?></a>
<a href="./tworlds/setTime/<?php echo $wrld; ?>/1200" class="button icon clock ajax_table1" onclick="$.nmTop().close();"><?php echo __('Noon'); ?></a>
<a href="./tworlds/setTime/<?php echo $wrld; ?>/2100" class="button icon clock ajax_table1" onclick="$.nmTop().close();"><?php echo __('Sunset'); ?></a>
<a href="./tworlds/setTime/<?php echo $wrld; ?>/0200" class="button icon clock ajax_table1" onclick="$.nmTop().close();"><?php echo __('Midnight'); ?></a>
</span>
<br><br><?php echo __('Or specify your own time:'); ?> <br><br>
<form id="setTimeForm" class="bw11" method="post" action="./tworlds/setTime">
	<input style="display: none" id="wrld" name="wrld" value="<?php echo $wrld; ?>"></input>
    <input width="25" id="time" name="time" type="text" placeholder="12:05"/>
    <input type="submit" class="button big primary submit bw11" onclick="$.nmTop().close();" value="<?php echo __('Set'); ?>">
</form>
</center></div>
<div class="clear"></div>
</section>
<!-- End #content --> 
<script>
$('document').ready(function() {

  $(".bw11").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $(this),
        lwrld = $form.find( 'input[name="wrld"]' ).val(),
        ltime = $form.find( 'input[name="time"]').val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post(url, {wrld: lwrld, time: ltime},
      function( data ) {
         notifications.show({msg:data, icon:'img/win.png'});
         adtb.fnReloadAjax("./tworlds/getWorlds")
      }
    );
  });
});

</script>
