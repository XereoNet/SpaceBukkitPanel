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

                <h2>Step 2</h2>

                <h3>Database</h3>

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

                <h2>Database</h2>

                <div>

                    <p> Now we'll need to connect to a database. A database is required by SpaceBukkit to store it's data. Currently, we support MySQL and SQLite. </p>
                    <p> To make a MySQL database, you'll need to set it up first. </p>
                    <p> For a SQLite database no setup is required. </p><br>

                    <p>
                      
                        <select name="database_type" id="database_type">

                          <option value="0">Choose a database type...</option>
                          <option value="1">MySQL</option>
                          <option value="2">SQLite</option>

                        </select>   

                    </p>

                </div>

                <div style="display: none" id="mysql_forms">
                  <br>
                <?php
                    if (extension_loaded('pdo_mysql')):
                        echo '<span class="alert alert-success">';
                            echo __('The "pdo_mysql" extension is loaded in your php.ini!');
                        echo '</span>';
                    else:
                        echo '<span class="alert alert-error">';
                            echo __('The "pdo_mysql" extension is NOT loaded in your php.ini! Make sure to load it before continuing!');
                        echo '</span>';
                    endif;
                ?>

                    <h2>MySQL - Information needed</h2>

                    <form action='<?php echo $this->Html->url('/install/step2', true); ?>' id='db_form' method='post' class="installform" >

                    <div class="error_box"></div>

                    <input type="hidden" name="type" value="mysql">

                    <section>

                      <label for="title">
                        
                        Hostname

                      </label>
                    
                      <div>

                        <input id="hostname" name="hostname" type="text" />
                        <p class="help-block">This is usually localhost.</p>

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Database

                      </label>
                    
                      <div>

                        <input id="database" name="database" type="text" />
                        <p class="help-block">This is how you called the database on which you want to install SpaceBukkit.</p>

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Username

                      </label>
                    
                      <div>

                        <input id="username" name="username" type="text" />
                        <p class="help-block">This can be the defaul MySQL username "root" or a username you created / was provided by your hoster. </p>

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Password

                      </label>
                    
                      <div>

                        <input id="password" name="password" type="password"/>
                        <p class="help-block">This is the password associated with your username for MySQL.</p>

                      </div>

                    </section>                                                               
                    </form>

                </div>

                <div style="display: none" id="sqlite_forms">

                    <h2>SQLite</h2>

                    <p>Nothing more is required for SQLite to work. Click next when you want to continue! </p>

                    <form action='<?php echo $this->Html->url('/install/step2', true); ?>' id='db_form2' method='post' class="installform" >
                    <input type="hidden" name="type" value="mysql">                                                       
                    </form>

                </div>

            </div>

        </div>

    </div>

    <div class="clear"></div>

    </section> 
      
    <header>
       <a href="<?php echo $this->Html->url('/install', true); ?>" class="button icon arrowleft">Previous</a>        
       <a href="<?php echo $this->Html->url('/install/step3', true); ?>" class="button icon arrowright leftsubmit" style="display: none" id="submit">Next</a>
    </header>   

 </section>

 <script>

    $('document').ready(function () {

        var select          = $('#database_type');
        var mysql_forms     = $('#mysql_forms');
        var sqlite_forms    = $('#sqlite_forms');
        var action          = $('#submit');

        select.change(function() {

            action.removeClass("mysql");
            action.hide();

            if ($(this).val() == 1 ) 
            {
                
                sqlite_forms.hide();
                mysql_forms.fadeIn();
                action.addClass("mysql");
                action.fadeIn();

            }

            if ($(this).val() == 2 ) 
            {
                                
                mysql_forms.hide();
                sqlite_forms.fadeIn();
                action.addClass("sqlite");
                action.fadeIn();

            }

        });

        /* AJAX SUBMIT FORMS, AND LISTEN FOR RESPONSE */

        // this is the id of the submit button
        $("#submit").click(function() {

          if ($(this).hasClass('mysql')) {

            var form  = $('#db_form');
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

                        window.location.replace("<?php echo $this->Html->url('/install/step3', true); ?>");

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

          } else if ($(this).hasClass('sqlite')) {
            var form  = $('#db_form');
            var url   = form.attr('action'); // the script where you handle the form input.
            var act   = $('#inst_activity');

            //show processing on the left

            act.html("");

            act.spin()

            //submit

            $.ajax({
              url: url,
              success: function(d)
              {
                if (d == "true")
                {
                  window.location.replace("<?php echo $this->Html->url('/install/step3', true); ?>");
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
          }
        });

    });

 </script>