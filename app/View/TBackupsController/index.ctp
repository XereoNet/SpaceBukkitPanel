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
		<li class="current"><a href="#tab1" id="noTop"><?php echo __('Overview') ?></a></li>
		<li><a href="#tab2" id="yesTop"><?php echo __('Worlds') ?></a></li>
    <li><a href="#tab3" id="yesTop"><?php echo __('Plugins') ?></a></li>
    <li><a href="#tab4" id="yesTop"><?php echo __('Server') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

  <div class="b-now" id="runningTop" style="width: 50%; margin-left: auto; margin-right: auto;">
    <div class="darkwell">
        <div class="progress-new progress-striped active" style="margin: 7px;">
          <div class="bar" id="PBbartop" style="width: 0%"></div>
        </div>
    </div>
  </div>
<br>
<div class="tab" id="tab1">

  <section class="b-home">

    <div class="col left">

      <div>

        <section class="b-now">

          <h2>Running now:</h2>


            <div class="darkwell">

              <section>
                <div id="runningNow">

                Fetching...

              </div>
              <div class="clear"></div>

                <br><br>
                <div id="runningPB" class="progress-new progress-striped active"><div class="bar" id="PBbar" style="width: 0%"></div></div>

              </section>

            </div>

        </section>

        <section class="b-now">

          <h2>Backup Stats:</h2>


            <div class="darkwell" id="tab1Stats">
              <section>
                <div>
                  Fetching...
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

          <h2>Next Backups:</h2>

            <div class="darkwell" id="tab1Next">
              <section>
                <div>
                  Fetching...
                </div>
              </section>
            </div>

        </section>

      <section class="b-now">

          <h2>Previous Backups:</h2>

            <div class="darkwell" id="tab1Prev">
              <section>
                <div>
                  Fetching...
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

          <h2>Backup Worlds:</h2>


            <div class="darkwell">

              <?php echo $backupWorlds; ?>

            </div>

        </section>

      </div>

    </div>

    <div class="col right">

      <div>

        <section class="b-now">

          <h2>Next Backups:</h2>


            <div class="darkwell" id="tab2Next">

              <section>
                <div>
                  Fetching...
                </div>
              </section>

            </div>

      <section class="b-now">

          <h2>Previous Backups:</h2>

          <div class="darkwell" id="tab2Prev">

            <section>
              <div>
                Fetching...
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

          <h2>Backup Plugins:</h2>


            <div class="darkwell">

              <?php echo $backupPlugins; ?>

            </div>

        </section>

      </div>

    </div>

    <div class="col right">

      <div>

        <section class="b-now">

          <h2>Next Backups:</h2>


            <div class="darkwell" id="tab3Next">

              <section>
                <div>
                  Fetching...
                </div>
              </section>

            </div>

      <section class="b-now">

          <h2>Previous Backups:</h2>

            <div class="darkwell" id="tab3Prev">

              <section>
                <div>
                  Fetching...
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

          <h2>Backup Server:</h2>

            <div class="darkwell">
              <section>
                <a href="./tbackups/backup" class="button icon like backup">Backup Complete Server</a>
              </section>
            </div>

        </section>

      </div>

    </div>

    <div class="col right">

      <div>

        <section class="b-now">

          <h2>Next Backups:</h2>


            <div class="darkwell" id="tab4Next">

              <section>
                <div>
                  Fetching...
                </div>
              </section>

            </div>

      <section class="b-now">

          <h2>Previous Backups:</h2>

            <div class="darkwell" id="tab4Prev">

              <section>
                <div>
                  Fetching...
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
var pa = 3;
var pw = 3;
var pp = 3;
var ps = 3;

var na = 3;
var nw = 3;
var np = 3;
var ns = 3;

//global functions
function isRunning() {
  var source = './tbackups/isRunning';
  $.ajax({
    url: source,
    success: function(data) {
      running = data;
    }
  });
        return false;
}

function refreshRunning() {
    var source = './tbackups/getRunning';
    $.ajax({
      url: source,
      success: function(data) {
        $("div#runningNow").html(data);
      }
    });
  return false;
};

function refreshProgressb() {
  var source = './tbackups/getPB';
  if(running === 'true') {
    $.ajax({
      url: source,
      success: function(data) {
          $("#runningPB").fadeIn();
          $('#PBbar').animate({width: data}, 10);
          $('#PBbartop').animate({width: data}, 10);
      }
    });
  } else {
    $("#runningPB").fadeOut(0);
    $("#runningTop").fadeOut(0);
  }
  return false;
};

function refreshPrevBackups() {
  $.ajax({
      url: './tbackups/getPrevBackups/a/'+pa,
      success: function(data) {
        $("div#tab1Prev").html(data);
      }
    });
  $.ajax({
      url: './tbackups/getPrevBackups/w/'+pw,
      success: function(data) {
        $("div#tab2Prev").html(data);
      }
    });
  $.ajax({
      url: './tbackups/getPrevBackups/p/'+pp,
      success: function(data) {
        $("div#tab3Prev").html(data);
      }
    });
  $.ajax({
      url: './tbackups/getPrevBackups/s/'+ps,
      success: function(data) {
        $("div#tab4Prev").html(data);
      }
    });
}

function refreshNextBackups() {
  $.ajax({
      url: './tbackups/getNextBackups/a/'+na,
      success: function(data) {
        $("div#tab1Next").html(data);
      }
    });
  $.ajax({
      url: './tbackups/getNextBackups/w/'+nw,
      success: function(data) {
        $("div#tab2Next").html(data);
      }
    });
  $.ajax({
      url: './tbackups/getNextBackups/p/'+np,
      success: function(data) {
        $("div#tab3Next").html(data);
      }
    });
  $.ajax({
      url: './tbackups/getNextBackups/s/'+ns,
      success: function(data) {
        $("div#tab4Next").html(data);
      }
    });
}

function refreshStats() {
  $.ajax({
      url: './tbackups/getBackupStats',
      success: function(data) {
        $("div#tab1Stats").html(data);
      }
    });
}

$('document').ready(function() {

  $("#runningTop").fadeOut(0);
  //init all boxes
  //refreshProgressb();
  refreshRunning();
  refreshNextBackups();
  refreshPrevBackups();
  refreshStats();

  //set update intervals
  setInterval("isRunning()", 1000);
  setInterval("refreshRunning()", 2000);
  setInterval("refreshProgressb()", 500);
  setInterval("refreshNextBackups()", 10000);
  setInterval("refreshPrevBackups()", 10000);
  setInterval("refreshStats()", 10000);

  //check for clicks on stuff
  $('#yesTop').click(function(){
    if(running === 'true'){
      $("#runningTop").fadeIn();
    }
  });

  $('#noTop').click(function(){
    $("#runningTop").fadeOut(0);
  });

  //more buttons checks
  $('#updatepa').live('click', function(){
    pa = pa+3;
    refreshPrevBackups();
  });
  $('#updatepw').live('click', function(){
    pw = pw+3;
    refreshPrevBackups();
  });
  $('#updatepp').live('click', function(){
    pp = pp+3;
    refreshPrevBackups();
  });
  $('#updateps').live('click', function(){
    ps = ps+3;
    refreshPrevBackups();
  });
  $('#updatena').live('click', function(){
    na = na+3;
    refreshNextBackups();
  });
  $('#updatenw').live('click', function(){
    nw = nw+3;
    refreshNextBackups();
  });
  $('#updatenp').live('click', function(){
    np = np+3;
    refreshNextBackups();
  });
  $('#updatens').live('click', function(){
    ns = ns+3;
    refreshNextBackups();
  });

  $('.backup').live('click', function(){
    $('#noTop').click();
    var href = $(this).attr('href');
    $.ajax({
      url: href,
      success: function(data) {
        isRunning();
        refreshRunning();
        refreshProgressb();
      }
    });

    return false;
  });
});

</script>