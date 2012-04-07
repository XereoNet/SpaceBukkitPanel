<!-- Content -->
<section id="content" class="dashboard_content"> 

  <div class="col left">

    <div class="inner">
      
      <h1><?php echo $current_server_name; ?></h1>

      <pre><?php echo $motd; ?></pre>
    
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
          <td>Players</td><td> <p><?php echo $whitelist_count; ?>  | <span class="greyed"><?php echo $ban_count; ?> </span></p>
               <p class="cell_medium">
               <b class="cell_left"><?php echo __('whitelist') ?></b>  
               <b class="cell_right greyed"><?php echo __('banned') ?></b>
               </p>
          </td>
        </tr>
        <tr>
          <td>Plugins</td><td>          
              <p><?php echo $plugin_count; ?> | <span class="greyed"><?php echo $dis_plugin_count; ?> </span></p>
              <p class="cell_medium">
                <b class="cell_left"><?php echo __('installed') ?></b>  
                <b class="cell_right greyed"><?php echo __('disabled') ?></b>
              </p></td>
        </tr>                
        <tr>
          <td>Staff</td><td><p><?php echo $connected_users; ?></span></p>
              <p class="cell_medium"><?php echo __(' linked to this server') ?></p></td>
        </tr>
      </tbody>
    </table>

  </div>


  <div class="col right">

    <div class="inner">
      
      <div class="dbox up">

        <section>
        <div class="accordion" id="accordion2">
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                  Statistics
                </a>
              </div>
              <div id="collapseOne" class="accordion-body collapse in">
                <div class="accordion-inner">
                  <div>
                    <h3>RAM</h3>
                    <p class="ram_tot">Total: <span>3</span> MB</p>
                    <p class="ram_used">Used: <span>2</span> MB</p>
                    <p class="ram_free">Free: <span>1</span> MB</p>
                    <div class="timer timer1">

                      <div class="percent">Calculating...</div>
                        <div class="slice">
                          <div class="pie"></div>
                        </div>
                      </div>

                  </div>
                  <div>
                    <h3>CPU</h3>
                    <p class="cpu_tot">CPUs: <span>3</span></p>
                    <p class="cpu_used">Frequency: <span>2</span></p>
                    <p class="cpu_free"><span></span></p>
                    <div class="timer timer2">

                      <div class="percent">Calculating...</div>
                        <div class="slice">
                          <div class="pie"></div>
                        </div>

                    </div>
                  </div>
                  <div>
                    <h3>JAVA</h3>
                    <p class="jav_tot">Total: <span></span> MB</p>
                    <p class="jav_used">Used: <span></span> MB</p>
                    <p class="jav_free">Free: <span></span> MB</p>
                    <div class="timer timer3">

                      <div class="percent">Calculating...</div>
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
                  Activity
                </a>
              </div>
              <div id="collapseTwo" class="accordion-body collapse">
                <div class="accordion-inner">

                  <div id="activity-list">
                    <ul>                
                    </ul>
                </div>

                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                  Admins online
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

    var timer;
    var timerCurrent;
    var timerFinish;
    var timerSeconds;

    function drawTimer(container, percent){
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
 
  function graphs(graph,source,interval,type) {

    var c1    = $(graph);
    var t  = '.'+type;
    var tot   = $(t + '_tot span' );
    var free  = $(t + '_free span');
    var used  = $(t + '_used span');

    $.getJSON(source, function(data) {

      tot.html(data.tot);
      free.html(data.free);
      used.html(data.used);
      drawTimer(graph, data.perc);

    });
 
  };

$(document).ready(function(){

  $('input[type=button]#percent').click(function(e){
    e.preventDefault();
    drawTimer('.timer1', $('input[type=text]#percent').val());
  });


  setInterval("graphs('.timer1', './dash/calculate_ram', 3000, 'ram')", 3000);
  setInterval("graphs('.timer2', './dash/calculate_cpu', 3000, 'cpu')", 3000);
  setInterval("graphs('.timer3', './dash/calculate_java', 3000, 'jav')", 3000);

  doAndRefresh('#activity-list ul', './dash/get_log', 30000);
  doAndRefresh('#online-list', './dash/get_admins', 30000);
  doAndRefresh('#players-count', './dash/calculate_players', 30000);
  doAndRefresh('#ticks-count', './dash/calculate_ticks', 30000);

});

</script> 