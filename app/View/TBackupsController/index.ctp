
<!-- Tabs -->
<nav id="smalltabs">
	<ul>
		<li class="current"><a href="#tab1" id="noTop"><?php echo __('Overview') ?></a></li>
		<li><a href="#tab2" id="yesTop"><?php echo __('Worlds') ?></a></li>
    <li><a href="#tab3" id="yesTop"><?php echo __('Plugins') ?></a></li>
    <li><a href="#tab4" id="yesTop"><?php echo __('Server') ?></a></li>
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

          <h2><?php echo __('Running now:') ?></h2>


            <div class="darkwell">

              <section>
                <div id="runningNow">

                <?php echo __('Fetching...') ?>

              </div>
              <div class="clear"></div>

                <br><br>
                <div id="runningPB" class="progress-new progress-striped active"><div class="bar" id="PBbar" style="width: 0%"></div></div>
              </section>
            </div>

        </section>

        <section class="b-now" id="finishedDisp" style="display: none;">

          <h2><?php echo __('Finished operations:') ?></h2>


            <div class="darkwell" id="Finished">
              <section>
                <div>
                  Fetching...
                </div>
              </section>
            </div>
            <div class="clear"></div>

        </section>

        <section class="b-now">

          <h2><?php echo __('Backup Stats:') ?></h2>


            <div class="darkwell" id="tab1Stats">
              <section>
                <div>
                  <?php echo __('Fetching...') ?>
                </div>
                <div class="clear"></div>
              </section>
            </div>
        </section>

      </div>

    </div>

    <div class="col right">

      <div>

        <section class="b-now">

          <h2><?php echo __('Next Backups:') ?></h2>

            <div class="darkwell" id="tab1Next">
              <section>
                <div>
                  <?php echo __('Fetching...') ?>
                </div>
              </section>
            </div>

        </section>

      <section class="b-now">

          <h2><?php echo __('Previous Backups:') ?></h2>

            <div class="darkwell" id="tab1Prev">
              <section>
                <div>
                  <?php echo __('Fetching...') ?>
                </div>
              </section>
            </div>
            <br><br>

        </section>

      </div>

    </div>

    <div class="clear"></div>

  </section>

</div>

<div class="tab" id="tab2">

  <section class="b-home">

    <div class="col left">

      <div>

        <section class="b-now">

          <h2><?php echo __('Backup Worlds:') ?></h2>


            <div class="darkwell">

              <?php echo $backupWorlds; ?>

            </div>

        </section>

      </div>

    </div>

    <div class="col right">

      <div>

        <section class="b-now">

          <h2><?php echo __('Next Backups:') ?></h2>


            <div class="darkwell" id="tab2Next">

              <section>
                <div>
                  <?php echo __('Fetching...') ?>
                </div>
              </section>

            </div>

      <section class="b-now">

          <h2><?php echo __('Previous Backups:') ?></h2>

          <div class="darkwell" id="tab2Prev">

            <section>
              <div>
                <?php echo __('Fetching...') ?>
              </div>
            </section>

          </div>

        </section>

      </div>

    </div>

    <div class="clear"></div>

  </section>

</div>


<div class="tab" id="tab3">

  <section class="b-home">

    <div class="col left">

      <div>

        <section class="b-now">

          <h2><?php echo __('Backup Plugins:') ?></h2>


            <div class="darkwell">

              <?php echo $backupPlugins; ?>

            </div>

        </section>

      </div>

    </div>

    <div class="col right">

      <div>

        <section class="b-now">

          <h2><?php echo __('Next Backups:') ?></h2>


            <div class="darkwell" id="tab3Next">

              <section>
                <div>
                  <?php echo __('Fetching...') ?>
                </div>
              </section>

            </div>

      <section class="b-now">

          <h2><?php echo __('Previous Backups:') ?></h2>

            <div class="darkwell" id="tab3Prev">

              <section>
                <div>
                  <?php echo __('Fetching...') ?>
                </div>
              </section>

            </div>

        </section>

      </div>

    </div>

    <div class="clear"></div>

  </section>

</div>


<div class="tab" id="tab4">

  <section class="b-home">

    <div class="col left">

      <div>

        <section class="b-now">

          <h2><?php echo __('Backup Server:') ?></h2>

            <div class="darkwell">
              <section>
                <a href="./tbackups/backup/Server/*" class="button icon like backup">Backup Complete Server</a>
              </section>
            </div>

        </section>

      </div>

    </div>

    <div class="col right">

      <div>

        <section class="b-now">

          <h2><?php echo __('Next Backups:') ?></h2>


            <div class="darkwell" id="tab4Next">

              <section>
                <div>
                  <?php echo __('Fetching...') ?>
                </div>
              </section>

            </div>

      <section class="b-now">

          <h2><?php echo __('Previous Backups:') ?></h2>

            <div class="darkwell" id="tab4Prev">

              <section>
                <div>
                  <?php echo __('Fetching...') ?>
                </div>
              </section>
            </div>

        </section>

      </div>

    </div>

    <div class="clear"></div>

  </section>

</div>
</section>


<!-- End #content --> 
<script type="text/javascript" src="./js/tristate.js"></script>
<script>

var running = 'false';

//prev/next backup parse amounts
var pa = 7;
var pw = 7;
var pp = 7;
var ps = 7;

var na = 7;
var nw = 7;
var np = 7;
var ns = 7;

//global functions
function getRunning() {
    $.ajax({
      url: './tbackups/getRunning',
      success: function(data) {
        var info = $.parseJSON(data);
        if (info.running === 'no' || info.running === 'done') {
          $("#runningPB").fadeOut(0);
          $('#PBbar').animate({width: '0%'}, 10);
        } else {
          $("#runningPB").fadeIn();
          $('#PBbar').animate({width: info.pb}, 10);
        }
        $("div#runningNow").html(info.data);
      }
    });
};

function getFinished() {
    $.ajax({
      url: './tbackups/getFinished',
      success: function(data) {
        if (data == '') {
          $("#finishedDisp").fadeOut();
        } else {
          $("div#Finished").html(data);
          $("#finishedDisp").fadeIn();
        }
      }
    });
};

function getBackups() {
  $.ajax({
      url: './tbackups/getBackups/'+pa+','+pw+','+pp+','+ps,
      success: function(data) {
        var info = $.parseJSON(data);
        $("div#tab1Stats").html(info.info);

        $("div#tab1Prev").html(info.prev.a);
        $("div#tab2Prev").html(info.prev.w);
        $("div#tab3Prev").html(info.prev.p);
        $("div#tab4Prev").html(info.prev.s);

        $("div#tab1Next").html(info.next);
        $("div#tab2Next").html(info.next);
        $("div#tab3Next").html(info.next);
        $("div#tab4Next").html(info.next);
      }
    });
};

$('document').ready(function() {

  getRunning();
  getBackups();

  //set update intervals
  setInterval("getRunning()", '<?php echo $this->Session->read("Sbvars.8"); ?>');
  setInterval("getFinished()", '<?php echo $this->Session->read("Sbvars.8"); ?>');
  setInterval("getBackups()", '<?php echo $this->Session->read("Sbvars.9"); ?>');

  //more buttons checks
  $('#updatepa').live('click', function(){
    pa = pa+3;
    getBackups();
  });
  $('#updatepw').live('click', function(){
    pw = pw+3;
    getBackups();
  });
  $('#updatepp').live('click', function(){
    pp = pp+3;
    getBackups();
  });
  $('#updateps').live('click', function(){
    ps = ps+3;
    getBackups();
  });
  $('#updatena').live('click', function(){
    na = na+3;
    getBackups();
  });
  $('#updatenw').live('click', function(){
    nw = nw+3;
    getBackups();
  });
  $('#updatenp').live('click', function(){
    np = np+3;
    getBackups();
  });
  $('#updatens').live('click', function(){
    ns = ns+3;
    getBackups();
  });

  $('.backup').live('click', function(){
    var alertmsg = confirm("Do you want to stop the server while creating the backup?");
    $('#noTop').click();
    var href = $(this).attr('href') + '/' + alertmsg;
    $.ajax({
      url: href,
      success: function(data) {
        getRunning();
      }
    });
    return false;
  });

  $('.restore').live('click', function () {
    if (confirm("The server will be stopped while restoring the backup!")) {
      var alertmsg = confirm("Do you want delete the folder before restoring?");
      $('#noTop').click();
      var href = $(this).attr('href') + '/' + alertmsg;
      $.ajax({
        url: href,
        success: function(data) {
          getRunning();
        }
      });
    } else {
      alert('The restore was canceled by the user!');
    }
    return false;
  });
});

</script>