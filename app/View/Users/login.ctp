<!-- Content -->
<div id="loading-container">
<div id="loading-content">Logging in...</div>
</div>

<section id="content"> 
<div class="colorbox blue">
    <h3>Welcome to the SpaceBukkit Beta!</h3> 
    <p> 
        Please do report any bug to GitHub, located here: <a href="https://github.com/SpaceDev/SpaceBukkit/issues">GitHub</a><br />
        You can contact us on our forums: <a href="forums.xereo.net">Forums</a><br />
        Have fun!
    </p> 
</div>

<section class="box boxpad"> 
 
        <header>
            <h2>Login to SpaceBukkit</h2> 
        </header>
        
       <section>      
       <div class="error_box"></div>
      <?php  

    if($flash != false) {
        ?>
        <div class="colorbox red">

            <?php echo $flash; ?>
        </div> 
    <?php }  ?>                      
    <?php echo $this->Form->create('User');?>
        <div>
        <input type="text" id="UserUsername" maxlength="50" name="data[User][username]" placeholder="Enter username" class="login_user">
        <input type="password" id="UserPassword" name="data[User][password]" placeholder="Enter password" class="login_pass">
        <input type="submit" class="button big primary submit loginkey" value="Login">
        </div>
    </form>

    </section>
<div class="clear"></div>
</section>

<!-- End #content --> 
