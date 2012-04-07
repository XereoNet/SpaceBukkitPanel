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

                <form action='<?php echo $this->Html->url('/install/step3', true); ?>' id='server' method='post' class="installform" >

                    <div class="error_box"></div>

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

                        <input id="password" name="password" type="text" />

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Language

                      </label>
                    
                      <div>

                        <select id="password" name="password" >
                            <option>test</option>
                            <option>test2</option>
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
       <a href="<?php echo $this->Html->url('/install/step4', true); ?>" class="button icon arrowright leftsubmit">Next</a>
    </header>   

 </section>