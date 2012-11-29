<!-- Content -->
<section id="content" class="dashboard_content">

  <div class="col left">

    <div class="inner">

      <h1><?php echo $current_server_name; ?></h1>

      <p><?php echo $motd; ?></p>

    </div>

    <table class="dash-bigstats">
      <tbody>
        <tr class="dash-players-ticks">
          <td><?php echo $this->Html->image('dash-user.png')?><span id="players-count"> </span></td>
          <td><?php echo $this->Html->image('dash-ticks.png')?><span id="ticks-count"> </span></td>
        </tr>
        <tr>
          <td>Craftbukkit</td><td>   <?php echo $c_bukkit_version; ?><br>
               <?php
                echo $m_bukkit_version;
               ?></td>
        </tr>
        <tr>
          <td><?php echo __('Players'); ?></td>
          <td>


             <p class="cell_medium">
             <b class="cell_left"><?php echo $whitelist_count; ?> </b>
             <b class="cell_right greyed"><?php echo $ban_count; ?></b>
             </p>
<br>
             <p class="cell_medium">
             <b class="cell_left"><?php echo __('whitelist') ?></b>
             <b class="cell_right greyed"><?php echo __('banned') ?></b>
             </p>

          </td>
        </tr>
        <tr>
          <td><?php echo __('Plugins'); ?></td>
          <td>


             <p class="cell_medium">
             <b class="cell_left"><?php echo $plugin_count; ?> </b>
             <b class="cell_right greyed"><?php echo $dis_plugin_count; ?></b>
             </p>
<br>
             <p class="cell_medium">
             <b class="cell_left"><?php echo __('installed') ?></b>
             <b class="cell_right greyed"><?php echo __('disabled') ?></b>
             </p>

          </td>
        </tr>

        <tr>
          <td><?php echo __('SpaceBukkit'); ?></td><td><p><?php echo $connected_users; ?></span></p>
              <p class="cell_medium"><?php echo ' '.__('accounts linked to this server') ?></p></td>
        </tr>
      </tbody>
    </table>

  </div>


  <div class="col right" id="dabg">

    <div class="inner">

      <div class="dbox up" style="z-index: 15">

        <section>
        <div class="accordion" id="accordion2">
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                  <?php echo __('Statistics'); ?>
                </a>
              </div>
              <div id="collapseOne" class="accordion-body collapse in">
                <div class="accordion-inner">
                  <div>
                    <h3><?php echo __('RAM'); ?></h3>
                    <p class="ram_tot"><?php echo __('Total'); ?>: <span></span> <?php echo __('MB'); ?></p>
                    <p class="ram_used"><?php echo __('Used'); ?>: <span></span> <?php echo __('MB'); ?></p>
                    <p class="ram_free"><?php echo __('Free'); ?>: <span></span> <?php echo __('MB'); ?></p>
                    <div class="timer timer1">

                      <div class="percent"><?php echo __('Calculating'); ?>...</div>
                        <div class="slice">
                          <div class="pie"></div>
                        </div>
                      </div>

                  </div>
                  <div>
                    <h3><?php echo __('CPU'); ?></h3>
                    <p class="cpu_tot"><?php echo __('CPUs'); ?>: <span></span></p>
                    <p class="cpu_used"><?php echo __('Frequency') ?>: <span></span></p>
                    <p class="cpu_free"><span></span></p>
                    <div class="timer timer2">

                      <div class="percent"><?php echo __('Calculating'); ?>...</div>
                        <div class="slice">
                          <div class="pie"></div>
                        </div>

                    </div>
                  </div>
                  <div>
                    <h3><?php echo __('JAVA'); ?></h3>
                    <p class="java_tot"><?php echo __('Total'); ?>: <span></span> <?php echo __('MB'); ?></p>
                    <p class="java_used"><?php echo __('Used'); ?>: <span></span> <?php echo __('MB'); ?></p>
                    <p class="java_free"><?php echo __('Free'); ?>: <span></span> <?php echo __('MB'); ?></p>
                    <div class="timer timer3">

                      <div class="percent"><?php echo ('Calculating'); ?>...</div>
                        <div class="slice">
                          <div class="pie"></div>
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                  <?php echo __('Activity'); ?>
                </a>
              </div>
              <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner">

                  <div id="activity-list">
                    <ul>
                    <li><?php echo __('Fetching...'); ?></li>
                    </ul>
                </div>

                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                  <?php echo __('Admins online'); ?>
                </a>
              </div>
              <div id="collapseThree" class="accordion-body collapse">
                <div class="accordion-inner">


                <table class="dash-bigstats">
                  <tbody id="online-list">
                  </tbody>
                </table>

                </div>
              </div>
            </div>
          </div>
        </section>

      </div>

    </div>

  </div>


</section>

<!-- End #content -->

<script>

    jQuery.extend({
      random: function(X) {
          return Math.floor(X * (Math.random() % 1));
      },
      randomBetween: function(MinV, MaxV) {
        return MinV + jQuery.random(MaxV - MinV + 1);
      }
    });

    var timer;
    var timerCurrent;
    var timerFinish;
    var timerSeconds;

    function drawTimer(container, percent){
      var deg = 360/100*percent;
      var slice = container + ' .slice';
      var con = container + ' .slice .pie';
      var per = container + ' .percent';

      $(container).html('<div class="percent"></div><div class="slice"'+(percent > 50?' class="gt50"':'')+'><div class="pie"></div>'+(percent > 50?'<div class="pie fill"></div>':'')+'</div>');
      var deg = 360/100*percent;
      var slice = container + ' .slice';
      var con = container + ' .slice .pie';
      var per = container + ' .percent';
      $(con).css({
        '-moz-transform':'rotate('+deg+'deg)',
        '-webkit-transform':'rotate('+deg+'deg)',
        '-o-transform':'rotate('+deg+'deg)',
        'transform':'rotate('+deg+'deg)'
      });
      $(per).html(Math.round(percent)+'%');

      if (percent <= 19) {
        $(con).css({'border-color': '#1284f6'})
      }
      else if (percent > 20 && percent <= 39)
      {
        $(con).css({'border-color': '#2d6bc6'})
      }
      else if (percent >= 40 && percent <= 49)
      {
        $(con).css({'border-color': '#3563b6'})
      }
      else if (percent >= 50 && percent <= 59)
      {
        $(con).css({'border-color': '#514985'})
      }
      else if (percent >= 60 && percent <= 69)
      {
        $(con).css({'border-color': '#5d3e6f'})
      }
      else if (percent >= 70 && percent <= 79)
      {
        $(con).css({'border-color': '#7d2036'})
      }
      else if (percent >= 80 && percent <= 100)
      {
        $(con).css({'border-color': '#900d13'})
      }
      if (percent > 50)
      {
        $(slice).css({'clip': 'rect(0px,1em,1em,0em)'});
      }
    }

  function graphs() {
    $.getJSON('./dash/graphs', function(data) {
      //Ram
      $('.ram_tot span').html(data.ram.tot);
      $('.ram_free span').html(data.ram.free);
      $('.ram_used span').html(data.ram.used);
      drawTimer('.timer1', data.ram.perc);

      //cpu
      $('.cpu_tot span').html(data.cpu.tot);
      $('.cpu_used span').html(data.cpu.used);
      drawTimer('.timer2', data.cpu.perc);

      //java
      $('.java_tot span').html(data.java.tot);
      $('.java_free span').html(data.java.free);
      $('.java_used span').html(data.java.used);
      drawTimer('.timer3', data.java.perc);
    });
  };

  function serverInfo() {
    $.getJSON('./dash/serverInfo', function(data) {
      $('#players-count').html(data.players);
      $('#ticks-count').html(data.ticks);
    });
  };

  function panelInfo() {
    $.getJSON('./dash/panelInfo', function(data) {
      $('#activity-list ul').html(data.serverlog);
      $('#online-list').html(data.admins);
    });
  };

  function dabg() {

    conf = '<?php echo $this->Session->read("Sbvars.17"); ?>';
    switch(conf) {
      case "g":
      break;
      case "i":

      var num = $.randomBetween(0, 11);

      var img = 'url(./img/wallpaper/'+num+'.jpg) no-repeat top left';

      $('#dabg').css("background", img);

      break;
      case "d":
      $('#dabg').prepend('<iframe src="<?php echo $dynmapurl; ?>" style="width: 100%; height: 500px; position: absolute; z-index: 10"></iframe>');
      break;
    }

  };

$(document).ready(function(){

  dabg();

  graphs();
  serverInfo();
  panelInfo();

  $('#clearlog').live('click', function(){
    var href = $(this).attr('href');
    $.ajax({
      url: href,
      success: function(data) {
        panelInfo();
      }
    });

    return false;
  });

  $('input[type=button]#percent').click(function(e){
    e.preventDefault();
    drawTimer('.timer1', $('input[type=text]#percent').val());
  });

  setInterval("serverInfo()", '<?php echo $this->Session->read("Sbvars.4"); ?>');
  setInterval("graphs()", '<?php echo $this->Session->read("Sbvars.5"); ?>');
  setInterval("panelInfo()", '<?php echo $this->Session->read("Sbvars.6"); ?>');

});

</script>