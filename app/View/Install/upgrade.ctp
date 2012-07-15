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

                <h2>Upgrade</h2>

                <h3>This page will guide you to upgrade your 1.1 database to 1.2</h3>

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

                <div id="inst_activity"></div>
                <p>               

                </p>

            </span>

        </div>

    </div>

    <div class="col right install-right">

        <div class="install-inner">

            <div class="install-block">

                
                <div id="upgrade_selector">
                    <h2>Do you want to upgrade from a 1.1 database?</h2>
                    <p>Click yes if you had SpaceBukkit 1.1 installed before and you want to keep your servers, users and settings.</p>
                    <a href="#" rel="yes" class="button icon approve">Yes!</a>
                    <a href="<?php echo $this->Html->url('/install/step2', true); ?>" rel="no" class="button icon remove">No!</a>
                </div>

                <div id="upgrade_form_mysql" style="display: none;">
                    <h2>Please enter your MySQL database information:</h2>
                    <form action='<?php echo $this->Html->url('/install/getOldMysql', true); ?>' id='old_mysql_form' method='post' class="installform" >

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
                        <p class="help-block">This is how you called the database where you're 1.1 installation resides.</p>

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
                    <div style="text-align: center;"><a href="#" id="button_fetch_mysql" rel="fetch" class="button icon fork">Fetch data!</a> </div>
                </div>

                <div id="old_data" style="display: none;">
                    <h2>This will be imported to your new database:</h2>
                    <div class="col left">
                        <!--Users-->
                        <section class="b-now">
                            <h3>Users:</h3>
                            <div class="darkwell" id="users">
                                
                            </div>
                        </section>

                        <!--Roles-->
                        <section class="b-now">
                            <h3>Roles:</h3>
                            <div class="darkwell" id="roles">
                                
                            </div>
                        </section>
                    </div>

                    <div class="col right">
                        <!--Servers-->
                        <section class="b-now">
                            <h3>Servers:</h3>
                            <div class="darkwell" id="servers">
                                
                            </div>
                        </section>

                    </div>
                    <div class="clear"></div><br>
                    <div style="text-align: center;" class="import_buttons">
                        <a href="#" id="button_import_mysql" rel="mysql" class="button icon arrowdown">Import to MySQL</a>
                        <a href="#" id="button_import_mysql" rel="sqlite" class="button icon arrowdown">Import to SQLite</a>
                        <a href="<?php echo $this->Html->url('/install/step2', true); ?>" id="button_import_mysql" rel="noimport" class="button icon remove">Do not import</a>
                    </div>
                </div>

                <div id="importing" style="display: none;">
                    <h2>Importing...</h2>
                    <p>Please wait...</p>
                    <img src="../img/big_loader.gif" />
                </div>


            </div>

        </div>

    </div>

    <div class="clear"></div>

    </section> 
      
    <header>
       <a href="<?php echo $this->Html->url('/install/step2', true); ?>" id="button_next" class="button icon arrowright leftsubmit" style="display: none;">Next</a>
    </header>   

 </section>

<div class="clear"></div>
</section>
<!-- End #content --> 

 <script>

    $('document').ready(function () {
        var selector = $('#upgrade_selector');
        var mysql = $('#upgrade_form_mysql');
        var old_mysql = $('#old_mysql_form');
        var url = old_mysql.attr('action');
        var button_import = $('#button_import_mysql');

        //buttons
        button_fetch = $('#button_fetch_mysql');

        //yes/no button event
        selector.live('click', function (event) {
            if (event.target.rel === "no") {
                selector.fadeOut();
                return true;
            } else if (event.target.rel === "yes") {
                event.preventDefault();
                selector.fadeOut(350, function() {mysql.fadeIn(350);});
            }
        });

        //fetch button event
        button_fetch.live('click', function (event) {
            event.preventDefault();
            var act   = $('#inst_activity');
            act.html("");

            act.spin();

            $.ajax({
                type: 'POST',
                url: url,
                data: old_mysql.serialize(),
                success: function (data) {
                    var content = $.parseJSON(data);
                    if (content.status == 'true') {
                        $('#old_data div#users').html(content.users);
                        $('#old_data div#servers').html(content.servers);
                        $('#old_data div#roles').html(content.roles);
                        act.hide();
                        mysql.fadeOut(350, function () {
                            $('#old_data').fadeIn(350);
                        });
                    }
                    else {
                        act.spin();
                      act.html(content.status);
                    }
                }
            });
        });

        button_import.live('click', function (event) {
            event.preventDefault();
            $('#old_data').fadeOut(350, function () {
                $('#importing').fadeIn(350);
            });
            if (this.rel === 'noimport') {
                window.location.replace("<?php echo $this->Html->url('/install/step2', true); ?>");
            }
            if (this.rel === 'mysql' || this.rel === 'sqlite') {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo $this->Html->url('/install/upgrade', true); ?>"+ '/' + this.rel,
                    data: old_mysql.serialize(),
                    success: function (data) {
                        if (data == 'true') {
                            window.location.replace("<?php echo $this->Html->url('/install/step5', true); ?>");
                        }
                    }
                });
            }
        });
    });
</script>