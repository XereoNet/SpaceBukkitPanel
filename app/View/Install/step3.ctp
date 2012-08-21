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

                <h2>Step 3</h2>

                <h3>Administration</h3>

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

                <h2>Create a SuperUser</h2>

                <div>

                    <p> Now let's add a SuperUser to SpaceBukkit. A SuperUser is a user with special rights: </p>
                    <p> He has access to any part of the panel and can do whatever he pleases. Actually, his life is pretty sweet, if you think about it. </p>
                    <p> Jokes aside, SuperUser is just another word for Root or Administrator. You get the idea. </p>

                </div>

                <h2>Information needed</h2>

                <div>

                <form action='<?php echo $this->Html->url('/install/step3', true); ?>' id='userform' method='post' class="installform" >

                    <div class="error_box"></div>

                    <input type="hidden" name="theme" value="Spacebukkit" />
                    <input type="hidden" name="is_super" value="1" />

                    <section>

                      <label for="title">
                        
                        Username

                      </label>
                    
                      <div>

                        <input id="username" name="username" type="text" />

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Password

                      </label>
                    
                      <div>

                        <input id="password" name="password" type="password" />

                      </div>

                    </section>

                    <section>

                      <label for="language">
                        
                        Language

                      </label>
                    
                      <div>

                        <select id="language" name="language" >

                        <?php 

                          foreach ($language as $k => $l) {

                            echo '<option value="'.$l.'">'.$k.'</option>';

                          }

                        ?>

                        </select>
                        <p class="help-block">Your language is not here? You can help us translating SpaceBukkit <a href="#">here</a>.</p>

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
       <a href="<?php echo $this->Html->url('/install/step2', true); ?>" class="button icon arrowleft">Previous</a>        
       <a href="<?php echo $this->Html->url('/install/step4', true); ?>" class="button icon arrowright leftsubmit" id="submit" >Next</a>
    </header>   

 </section>


 <script>

    $('document').ready(function () {

          /* AJAX SUBMIT FORMS, AND LISTEN FOR RESPONSE */

        // this is the id of the submit button
        $("#submit").click(function() {

            var form  = $('#userform');
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

                        window.location.replace("<?php echo $this->Html->url('/install/step4', true); ?>");

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