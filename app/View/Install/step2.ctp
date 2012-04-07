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

                    <h2>MySQL - Information needed</h2>

                    <form action='<?php echo $this->Html->url('/install/step3', true); ?>' id='server' method='post' class="installform" >

                    <div class="error_box"></div>

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

                        <input id="password" name="password" type="text"/>
                        <p class="help-block">This is the password associated with your username for MySQL.</p>

                      </div>

                    </section>                                                               
                    </form>

                </div>

                <div style="display: none" id="sqlite_forms">

                    <h2>SQLite</h2>

                    <p>Nothing more is required for SQLite to work. Click next when you want to continue! </p>

                </div>

            </div>

        </div>

    </div>

    <div class="clear"></div>

    </section> 
      
    <header>
       <a href="<?php echo $this->Html->url('/install', true); ?>" class="button icon arrowleft">Previous</a>        
       <a href="<?php echo $this->Html->url('/install/step3', true); ?>" class="button icon arrowright leftsubmit">Next</a>
    </header>   

 </section>

 <script>

    $('document').ready(function () {

        var select          = $('#database_type');
        var mysql_forms     = $('#mysql_forms');
        var sqlite_forms    = $('#sqlite_forms');

        select.change(function() {

            if ($(this).val() == 1 ) 
            {
                
                sqlite_forms.hide();
                mysql_forms.fadeIn();

            }

            if ($(this).val() == 2 ) 
            {
                                
                mysql_forms.hide();
                sqlite_forms.fadeIn();
            }

        });

    });

 </script>