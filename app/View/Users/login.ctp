<!-- Content -->
<div id="loading-container">

<div id="loading-content">Logging in...</div>
</div>

<style>

    .new-login {
        border-radius: 7px;
background: #3979b1; /* Old browsers */
background: -moz-linear-gradient(top,  #3979b1 0%, #315987 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3979b1), color-stop(100%,#315987)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #3979b1 0%,#315987 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #3979b1 0%,#315987 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #3979b1 0%,#315987 100%); /* IE10+ */
background: linear-gradient(top,  #3979b1 0%,#315987 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3979b1', endColorstr='#315987',GradientType=0 ); /* IE6-9 */

        -webkit-box-shadow: 0 0 5px rgba(0,0,0,0.75);
        -moz-box-shadow: 0 0 5px rgba(0,0,0,0.75);
        box-shadow: 0 0 5px rgba(0,0,0,0.75);
        height: 240px;
        margin-top: 50px;
        text-shadow: 0 1px 0 #555;
        color: #eee;
    }
    .new-login .left {
        border-bottom-left-radius: 7px;        
        border-top-left-radius: 7px;        
        height: 100%;
    }

    .new-login .right {
        border-bottom-right-radius: 7px;        
        border-top-right-radius: 7px;        
        background-image: -webkit-gradient(linear, center top, center bottom, from(white), to(#c2c2c2));
        background-image: -webkit-linear-gradient(top, white, #c2c2c2);
        background-image: -moz-linear-gradient(top, white, #c2c2c2);
        background-image: -o-linear-gradient(top, white, #c2c2c2);
        background-image: -ms-linear-gradient(top, white, #c2c2c2);
        background-image: linear-gradient(to bottom, white, #c2c2c2);
        height: 100%;
    }
    .new-login > div > div {
        margin: 30px;
    }
    .new-login > div h2 {
        font-size: 40px;
        margin: 14px 0;
        text-shadow: 0 1px 0 #555;
        color: #eee;
        padding-bottom: 25px;
    }
    .new-login > div h3 {
        font-size: 21px;
        margin: 14px 0;
        text-shadow: 0 1px 0 #555;
        color: #eee;
    }    
    .new-login > div input[type="text"] {
        background: #F1F1F1 url(../img/login-sprite.png) no-repeat;
        padding: 7px 15px 7px 30px;
        margin: 0 0 10px 0;
        width: 90%;
        border: 1px solid #CCC;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        -moz-box-shadow: 0 1px 1px #ccc inset, 0 1px 0 #fff;
        -webkit-box-shadow: 0 1px 1px #ccc inset, 0 1px 0 #fff;
        box-shadow: 0 1px 1px #ccc inset, 0 1px 0 #fff;
        background-position: 5px -2px !important;
    }
    .new-login > div input[type="password"] {
        background: #F1F1F1 url(../img/login-sprite.png) no-repeat;
        padding: 7px 15px 7px 30px;
        margin: 0 0 10px 0;
        width: 90%;
        border: 1px solid #CCC;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        -moz-box-shadow: 0 1px 1px #ccc inset, 0 1px 0 #fff;
        -webkit-box-shadow: 0 1px 1px #ccc inset, 0 1px 0 #fff;
        box-shadow: 0 1px 1px #ccc inset, 0 1px 0 #fff;
        background-position: 5px -52px !important;
    }
    .new-login > div input[type="submit"] {
        padding: 10px 30px;
        border: 1px solid #bbb;
    }

    .new-login a {
        color: #eee;
        background: #333;
    }

    .new-login p {
        line-height: 15px;
    }


</style>

<section id="content"> 


    <div class="new-login">

        <div class="col left col_1_3">
            <div>
            
                <h2>Login</h2>
                
                <p> 
                    You can report any bugs to our <a href="http://forums.xereo.net">Forums</a><br><br>


                    SpaceBukkit if free for personal usage. Please consider making a donation: <br><br> <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="display: inline; position: relative">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="ZW8KTNTJLRGGY">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </p> 

            </div>
        </div>

        <div class="col right col_2_3">
            <div>
            
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
                        <input type="text" id="UserUsername" maxlength="50" name="data[User][username]" placeholder="Enter username" class="login_user"><br>
                        <input type="password" id="UserPassword" name="data[User][password]" placeholder="Enter password" class="login_pass"><br><br><br><br>
                        <input type="submit" class="button big primary submit loginkey pull-right" value="Login">
                    </div>
                </form>

            </div>        
        </div>

    </div>
