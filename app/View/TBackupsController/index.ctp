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

      <section class="b-now">

          <h2>Previous Backups:</h2>

            <div class="darkwell">

              <section>
                <div class="b-what">World "home"</div>
                <div class="b-in">250MB</div>
                <div class="b-when">12th Feb 2012 21:00</div>
              </section>
              <section>
                <div class="b-what">Complete Server</div>
                <div class="b-in">789MB</div>
                <div class="b-when">12th Feb 2012 21:30</div>
              </section>
              <section>
                <div class="b-what">World "home_nether"</div>
                <div class="b-in">10MB</div>
                <div class="b-when">12th Feb 2012 22:00</div>
              </section>
              <section>
                <div class="b-what">World "home"</div>
                <div class="b-in">250MB</div>
                <div class="b-when">12th Feb 2012 21:00</div>
              </section>
              <section>
                <div class="b-what">Complete Server</div>
                <div class="b-in">789MB</div>
                <div class="b-when">12th Feb 2012 21:30</div>
              </section>
              <section>
                <div class="b-what">World "home_nether"</div>
                <div class="b-in">10MB</div>
                <div class="b-when">12th Feb 2012 22:00</div>
              </section>
              <section>
                <div class="b-what">World "home"</div>
                <div class="b-in">250MB</div>
                <div class="b-when">12th Feb 2012 21:00</div>
              </section>

            </div>
            <br><br>

        </section>

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
        <br>
      </div>
    </section>

    <section>
      <label for="Java">
        Java Version: 
      </label>

      <div>
        <br>
      </div>
    </section>

    <section>
      <label for="Bukkit">
        Bukkit Version: 
      </label>

      <div>
        <br>
      </div>
    </section>

  </div>


  <div class="col col_1_3 left">

      <section>
        <label for="Architecture">
          Architecture: 
        </label>

        <div>
          <br>
        </div>
      </section>
        <section>
          <label for="OS">
            Operating System: 
          </label>

          <div>
            <br>
          </div>
        </section>

        <section>
          <label for="SB">
            SpaceBukkit Version: 
          </label>

          <div>
            <br>
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
        <br>
      </div>
    </section>

    <section>
      <label for="Disk">
        Disk Space: 
      </label>

      <div>
        <br>
      </div>
    </section>


        <section>
          <label for="Web">
            Webserver Version: 
          </label>

          <div>
            <br>
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
  $.ajax({
    url: source,
    success: function(data) {
      data = '45%';
      if (data === 'false') {
        $("#runningPB").fadeOut();
        $("#runningTop").fadeOut();
      } else {
        $("#runningPB").fadeIn();
        $('#PBbar').animate({width: data}, 10);
        $('#PBbartop').animate({width: data}, 10);
        
      };
    }
  });
        return false;
};

$('document').ready(function() {
  $("#runningTop").fadeOut(0);
  refreshProgressb()
  refreshRunning()
  setInterval("refreshRunning()", 1000);
  setInterval("refreshProgressb()", 500);
  $('#yesTop').click(function(){
    $("#runningTop").fadeIn();
  });
  $('#noTop').click(function(){
    $("#runningTop").fadeOut(0);
  });
});

</script>