<!-- Content -->
<section id="content"> 

<section class="box boxpad"> 
 
    <header>
        <h2><?php echo __('Updating Spacebukkit') ?></h2> 
    <div class="pull-right">
    <a href="./dash" id="back" class="button icon arrowright"><?php echo __('Cancel and go back') ?></a>
    </div>
    </header>

    <section id="updateInfo">

	<p><?php echo __('SpaceBukkit is ready to be updated from version "') ?><?php echo $current; ?><?php echo __('" to version "') ?><?php echo $latest; ?><?php echo __('". Click the update button when you\'re ready!') ?><br/><br/></p>

    <?php if ($owner[0] == true) {
        echo '<div class="colorbox green">Your SpaceBukkit folder has the correct rights set to it. Click the button to upgrade SpaceBukkit: <br><br><a href="#" id="update" class="button icon fork">'.__('Update Now!').'</a><br></div>';
    } else {
        echo '<div class="colorbox red">Your SpaceBukkit folder doesn\'t have the correct rights set to it. This could break the upgrade process.<br>If you want to fix this issue please run this command as root, or ask your administrator to do this for you:<div style="background: #EEE; color: black;" class="code">'.$owner[1].'</div><br><a href="./update" class="button icon reload">'.__('Refresh').'</a><br></div>';
    }
    ?>
	

		<div class="code">
		<strong><?php echo __('Changelog') ?></strong>
		<?php echo $changelog; ?>
		</div>

    </section> 

    <section id="pb" style="display: none;">
        <div>
            <h3 id="message">Nothing is going on right now :3</h3>
        </div>
        <div class="clear"></div>
        <br><br>
        <div id="progress" class="progress-new progress-striped active"><div class="bar" id="PBbar" style="width: 0%"></div></div>
    </section>
                        
 </section>


	<div class="clear"></div>
</section>
<script type="text/javascript">
function check() {
        $.getJSON('./update/getStatus', function (data){
            $("#message").text(data.msg);
            $('#PBbar').animate({width: data.pb+'%'}, 10);
        });
}
$(document).ready(function(){
    $("#update").live('click', function() {
        $("#pb").fadeIn(100);
        $("#back").fadeOut(100);
        $("#updateInfo").fadeOut(100);
        var rq = $.ajax({
            url: './update/update',
            success: function (){
                window.location.replace('./dash');
            }
        });
        return rq;
    });
    
    setInterval("check()", 1000);
});

</script>
<!-- End #content --> 