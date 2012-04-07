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

                <h2>Step 1</h2>

                <h3>Start</h3>

                <p>               

                </p>

            </span>

        </div>

    </div>

    <div class="col right install-right">

        <div class="install-inner">

            <div class="install-block">

                <h2>Welcome!</h2>

                <div>

                    <p> Hello there! Welcome to the last part of installing SpaceBukkit. </p>

                    <p> But before continuing, we'd like to thank you for choosing SpaceBukkit! </p>

                    <p> Allright, let's get going then, shall we? First, let's check if everything is set correctly.  </p>

                </div>

                <h2>Checks</h2>

                <div>

<p> 
<?php
    if (version_compare(PHP_VERSION, '5.2.8', '>=')):
        echo '<span class="alert alert-success">';
            echo __('Your version of PHP is 5.2.8 or higher.');
        echo '</span>';
    else:
        echo '<span class="alert alert-error">';
            echo __('Your version of PHP is too low. You need PHP 5.2.8 or higher to use CakePHP.');
        echo '</span>';
    endif;
?> 
</p>
<p>
    <?php
        if (function_exists('curl_init')):
            echo '<span class="alert alert-success">';
                echo __('The CURL library is loaded in your php.ini!');
            echo '</span>';
        else:
            echo '<span class="alert alert-error">';
                echo __('The CURL library is NOT loaded in your php.ini!');
            echo '</span>';
        endif;
    ?>
</p>  
<p>
    <?php
        if (ini_get('allow_url_fopen')):
            echo '<span class="alert alert-success">';
                echo __('The "allow_url_fopen" function is loaded in your php.ini!');
            echo '</span>';
        else:
            echo '<span class="alert alert-error">';
                echo __('The "allow_url_fopen" function is NOT loaded in your php.ini!');
            echo '</span>';
        endif;
    ?>
</p>  
<p>
    <?php
        if (is_writable(TMP)):
            echo '<span class="alert alert-success">';
                echo __('The app/tmp directory is writable.');
            echo '</span>';
        else:
            echo '<span class="alert alert-error">';
                echo __('The app/tmp directory is NOT writable.');
            echo '</span>';
        endif;
    ?>
</p>                    
<p>
    <?php
        if (is_writable(APP . 'webroot')):
            echo '<span class="alert alert-success">';
                echo __('The app/webroot directory is writable.');
            echo '</span>';
        else:
            echo '<span class="alert alert-error">';
                echo __('The app/webroot directory is NOT writable.');
            echo '</span>';
        endif;
    ?>
</p>                       
<p>
    <?php
        if (is_writable(APP . 'Config/database.php ')):
            echo '<span class="alert alert-success">';
                echo __('The app/Config/database file is writable.');
            echo '</span>';
        else:
            echo '<span class="alert alert-error">';
                echo __('The app/Config/database file is NOT writable.');
            echo '</span>';
        endif;
    ?>
</p>   
                </div>

            </div>

        </div>

    </div>

    <div class="clear"></div>

    </section> 
      
    <header>
       <a href="<?php echo $this->Html->url('/install/step2', true); ?>" class="button icon arrowright leftsubmit">Next</a>
    </header>   

 </section>

<div class="clear"></div>
</section>
<!-- End #content --> 