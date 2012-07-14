<!-- Content -->
<section id="content" class="installer"> 

<section class="box boxpad"> 
 
    <header>
        <div class="col left">
            <h2>SpaceBukkit Installer</h2>
        </div>
    </header>

    <section class="installation">

    <div class="col left install-left">

        <div class="install-inner">

            <span>

                <h2>Step 4</h2>

                <h3>Server</h3>

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

                <div id="inst_activity"></div>

            </span>

        </div>

    </div>


    <div class="col right install-right">

        <div class="install-inner">

            <div class="install-block">

                <h2>Connecting a Server</h2>

                <div>

                    <p> Welcome to the final, last step of installation. </p>
                    <p> It is finally time to connect this panel to a server! </p>
                    <p> You can, of course, add more servers later on, if you want. For now, let's just add one. </p>
                    <p class="fail"> Remember: to add a server it has to be running! </p>

                </div>

                <h2>Information needed</h2>

                <div>

                <form action='<?php echo $this->Html->url('/install/step4', true); ?>' id='serverform' method='post' class="installform" >

                    <div class="error_box"></div>

                    <section>

                      <label for="title">
                        
                        Name

                      </label>
                    
                      <div>

                        <input id="name" name="name" type="text" />
                        <p class="help-block">Give your server a name. </p>

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Address

                      </label>
                    
                      <div>

                        <input id="address" name="address" type="text" />
                        <p class="help-block">The address of your server (without ports). If Panel and server are on the same machine, use localhost. </p>

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Salt

                      </label>
                    
                      <div>

                        <input id="salt" name="salt" type="text" />
                        <p class="help-block">The Salt is a randomly generated password that secures the connection between server and panel.</p>
                        <p class="help-block">It is located in SpaceModule/configuration.yml (NOT plugins/SpaceModule)</p>

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Ports

                      </label>
                    
                      <div>

                        <input id="port1" name="port1" type="text" style="width: 100px" />
                        <input id="port2" name="port2" type="text" style="width: 100px" />
                        <p class="help-block">SpaceBukkit needs two ports to connect to your server. By default it's 2011 and 2012.</p>
                        <p class="help-block">You can change those in the SpaceBukkit configuration, located in SpaceModule/configuration.yml (NOT plugins/SpaceModule)</p>

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Default Role

                      </label>
                    
                      <div>

                        <select>

                          <?php 

                          foreach ($roles as $k => $r) {

                            echo '<option value="'.$r['Role']['id'].'">'.$r['Role']['title'].'</option>';

                          }

                          ?>

                        </select>
                        <p class="help-block">Roles are like permission groups. You can define what a user in a role can or can't do on the panel.</p>
                        <p class="help-block">Here you can set what role a user gets by default on this server.</p>

                      </div>

                    </section>                    
                </form>

                </div>

            </div>

        </div>

    </div>

    <div class="clear"></div>

    </section> 
      
    <header>
       <a href="<?php echo $this->Html->url('/install/step3', true); ?>" class="button icon arrowleft">Previous</a>        
       <a href="<?php echo $this->Html->url('/install/step5', true); ?>" class="button icon arrowright leftsubmit" id="submit" >Next</a>
    </header>   

 </section>


 <script>

  $('document').ready(function () {

        /* AJAX SUBMIT FORMS, AND LISTEN FOR RESPONSE */

      // this is the id of the submit button
      $("#submit").click(function() {

          var form  = $('#serverform');
          var url   = form.attr('action'); // the script where you handle the form input.
          var act   = $('#inst_activity');

          //show processing on the left

          act.html("");

          act.spin()

          //submit

          $.ajax({
                 type: "POST",
                 url: url,
                 data: form.serialize(), // serializes the form's elements.
                 success: function(d)
                 
                 {
                    
                    //if data is correct (response: true) redirect

                    if (d == "true")
                    {

                      window.location.replace("<?php echo $this->Html->url('/install/step5', true); ?>");

                    }
                    else
                    {

                    //if data is false, show error on the left

                    act.spin()

                    act.html(d);

                    }

                 }

               });

          return false; // avoid to execute the actual submit of the form.

      });

  });

 </script>