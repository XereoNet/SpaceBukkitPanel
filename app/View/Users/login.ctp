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
        -moz-border-bottom-left-radius: 7px;        
        -moz-border-top-left-radius: 7px;        
        -webkit-border-bottom-left-radius: 7px;        
        -webkit-border-top-left-radius: 7px;        
        height: 100%;
    }

    .new-login .right {
        border-radius: 7px;        
        -moz-border-radius: 7px;        
        -webkit-border-radius: 7px;        
        background-image: -webkit-gradient(linear, center top, center bottom, from(white), to(#c2c2c2));
        background-image: -webkit-linear-gradient(top, white, #c2c2c2);
        background-image: -moz-linear-gradient(top, white, #c2c2c2);
        background-image: -o-linear-gradient(top, white, #c2c2c2);
        background-image: -ms-linear-gradient(top, white, #c2c2c2);
        background-image: linear-gradient(to bottom, white, #c2c2c2);
        height: 100%;
        padding-bottom: 20px;
    }
    .new-login > div div {
        margin: 20px 10px;
    }
    .login-news > div {
        margin: 10px 30px 20px;
        clear: both;
        display: block;
        padding-bottom: 10px;
    }
    .login-news > div.clear {
        border-bottom: 1px solid #444;
        box-shadow: 0px 1px 0px #111;
    }
    .login-news > div.clear:last-child {
        border: none;
        box-shadow: none;
    }
    .new-login > div h2 {
        font-size: 40px;
        margin: 14px 0;
        text-shadow: 0 1px 0 #555;
        color: #eee;
        padding-bottom: 30px;
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

    .login-news {
        text-shadow: 0 1px 0 black;
        margin-top: 30px;
        border: 1px solid #171717;
        border-top: 1px solid #252525;
        background: #2D2D2D;
        background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzJkMmQyZCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMyMTIxMjEiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
        background: -moz-linear-gradient(top, #2D2D2D 0%, #212121 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#2D2D2D), color-stop(100%,#212121));
        background: -webkit-linear-gradient(top, #2D2D2D 0%,#212121 100%);
        background: -o-linear-gradient(top, #2D2D2D 0%,#212121 100%);
        background: -ms-linear-gradient(top, #2D2D2D 0%,#212121 100%);
        background: linear-gradient(top, #2D2D2D 0%,#212121 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2d2d2d', endColorstr='#212121',GradientType=0 );
        border: 1px solid;
        border-top-color: #444;
        border-bottom: transparent;
        border-left-width: 0;
        border-right-width: 0;
        border-radius: 7px;
        box-shadow: 0 2px 3px 0 #111;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        -webkit-box-shadow: 0 2px 3px 0 #111;
        height: auto;
        -moz-box-shadow: 0 2px 3px 0 #111;
        padding-bottom: 30px;
        color: white;
        font-size: 15px;
    }
    .login-news > div h2 {
        font-size: 21px;
        margin: 14px 0;
        color: #eee;
        text-shadow: 0 1px 0 #111;
    }
    .login-news > div a {
        display: inline-block;
        padding-top: 10px;
        position: relative;
        float: left;
        color: #3979B1;
    }  
    .login-news > div span {
        display: inline-block;
        padding-top: 10px;
        position: relative;
        float: right;
        color: #777;
    }  
</style>

<section id="content"> 


    <div class="new-login">

        <div class="col left col_1_3">
            <div>
            
                <h2>Login</h2>
                
                <p> 
                    You can report any bugs to our <a href="http://forums.xereo.net">Forums</a><br><br>


                    SpaceBukkit if free for personal usage. Please consider making a donation: <br><br> <form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post" style="display: inline; position: relative">
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

                if(!empty($flash)) {
                ?>
                <div class="colorbox red">

                    <?php echo $flash; ?>
                </div> 
                <?php }  ?>    

                <?php echo $this->Form->create('User');?>
                    <div>
                        <input type="text" id="UserUsername" maxlength="50" name="data[User][username]" placeholder="Enter username" class="login_user"><br>
                        <input type="password" id="UserPassword" name="data[User][password]" placeholder="Enter password" class="login_pass"><br>
                        <input type="submit" class="button big primary submit loginkey pull-right" value="Login">
                    </div>
                </form>

            </div>        
        </div>

    </div>

    <?php if(isset($message)) : ?>
    <div class="login-news">

<?php 

foreach($message['NEWS']['N'] as $m) {

    if ($m['STATUS'] == '1') {

        echo <<<END
        <div>
            <h2>$m[TITLE]</h2>
            <p>$m[TEXT]</p>

            <a href="$m[LINK]">$m[LTEXT]</a><span>$m[DATE]</span>

        </div>
        <div class="clear"></div>
END;

        }

    }
?>

    </div>

    <?php endif; ?>

</section>
