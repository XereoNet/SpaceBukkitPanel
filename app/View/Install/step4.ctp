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

            </span>

        </div>

    </div>

    <div class="col right install-right">

        <div class="install-inner">

            <div class="install-block">

                <h2>Create a SuperUser</h2>

                <div>

                    <p> Welcome to the final, last step of installation. </p>
                    <p> It is finally time to connect this panel to a server! </p>
                    <p> You can, of course, add more servers later on, if you want. For now, let's just add one. </p>
                    <p class="fail"> Remember: to add a server it has to be running! </p>

                </div>

                <h2>Information needed</h2>

                <div>

                <form action='<?php echo $this->Html->url('/install/step3', true); ?>' id='server' method='post' class="installform" >

                    <div class="error_box"></div>

                    <section>

                      <label for="title">
                        
                        Name

                      </label>
                    
                      <div>

                        <input id="name" name="name" type="text" />

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Address

                      </label>
                    
                      <div>

                        <input id="address" name="address" type="text" />

                      </div>

                    </section>

                    <section>

                      <label for="title">
                        
                        Salt

                      </label>
                    
                      <div>

                        <input id="salt" name="salt" type="text" />

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