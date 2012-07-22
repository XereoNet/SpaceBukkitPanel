<!DOCTYPE html>

<html>

<head>

<title>Install | SpaceBukkit by XereoNet | Bukkit Web Administration</title>



<!-- CSS -->

<link rel="stylesheet" href="../app/webroot/css/import.css" /> 



<!--[if lt IE 9]>

<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>

<![endif]-->



<!-- Load theme -->

<link rel="stylesheet" href="../app/webroot/themes/Spacebukkit/css/theme.css" /> 



<!-- Load Jquery -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />

<script src="../app/webroot/js/script.js"></script> 

<script src="../app/webroot/js/selectivizr.min.js"></script> 



</head>

	

<body>

	<div id="header">

		<div id="container" class="login"> 

			

			<!-- Logo -->

			<div class="hheight">

				<div class="col left col_1_3">

				<h1 id="logo">SpaceBukkit</h1>

				</div>

			</div>

			

			<!-- Main Content Start -->

			

			<!-- Content -->

<section id="content"> 



<section class="box boxpad"> 

 

    <header>

        <div class="col left">

            <h2>Installing Spacebukkit</h2> 

        </div>    

        <div class="col right" style="text-align: right">

            <h2>Error: URL rewriting is not configured correctly</h2>

        </div>

    </header>


    <section class="installation" style="font-size: 15px; color: #444; line-height: 21px">

    <div style="text-align: center">

    	<img src="../app/webroot/img/sad.png" />
    	<h2>Houston, we've got a little problem!</h2>

    </div>

    	<p><b>Don't fear, my friend, it's an easy fix!</b></p>

    	<p><b>SpaceBukkit uses URL rewriting. This means that instead of having long-ass URLs they get rewritten and overally get much nicer.</b></p>
	<br>
		<p><b>It seems like something is not working as it should on your webserver, though.</b></p>
	<br>

	    <p><b>The possible causes are:</b></p>

	    <ul style="list-style: disc; margin-left: 20px">

	    	<li>You didn't copy the .htaccess files (they are hidden files and sometimes get ignored). <a href="#" target="_blank">Solution</a></li>
	    	<li>Your rewrite engine is not running / installed. <a href="#" target="_blank">Solution</a></li>
	    	<li>Your override settings are not being nice to SpaceBukkit. <a href="#" target="_blank">Solution</a></li>

	    </ul><br><br>
	    <small>(solutions coming with 1.2 final. Refer to old solutions below)</small>
    <br>
    <hr>

    <p><font size=4>If you are on Apache2 (xampp, wampp, lampp, mampp or similar)</font></p><br />

    <p>Usually the command "a2enmod rewrite" should enable the module, if not, there may be something wrong with your installation of Apache2.</p>
    <p>Also make sure that AllowOverride for your webroot directory (NOT /) is set to "All".</p> <p> Restart your webserver and refresh this page.</p>

    <hr>

    <p><font size=4>If you are on IIS7</font></p><br />

    <p>Use Microsoft's Web Platform Installer to install the URL Rewrite Module 2.0</p>
	<p>After that you will need to convert the .htaccess files with a tool provided with the module.</p>

    <hr>

    <p><font size=4>If you are on Nginx</font></p><br />
    
    <p>You need to add some lines into your server config. Please refer to our <a href="http://spacebukkit.xereo.net/wiki/index.php?title=Installing#An_error_page_sent_me_hear.2C_about_that_Nginx_stuff">Wiki</a></p>

    <hr>

    <p><font size=4>If you are running some other webserver not listed</font></p><br />
    
    <p>Then I unfortunately can't help you here, visit our <a href="http://forums.xereo.net/">Forum</a> or try this <a href="http://www.google.com/">fine site</a></p>

    <div class="clear"></div>



    </section> 

      

    <header>

       <a href="../install" class="button icon arrowright reload leftsubmit">Refresh</a>

    </header>                   

 </section>



<div class="clear"></div>

</section>

<!-- End #content --> 				

			<!-- End #wrapper --> 

			

		</div>

		<!-- End #container --> 

		<div class="clearfooter"></div>

	</div>

	<!-- End #header --> 



	<script src="../app/webroot/js/ttw-simple-notifications-min.js"></script> 

	<script src="../app/webroot/js/excanvas.js"></script> 

	<script src="../app/webroot/js/jquery.uniform.min.js"></script> 

	<script src="http://tab-slide-out.googlecode.com/files/jquery.tabSlideOut.v1.3.js"></script>

	<script src="../app/webroot/js/jquery.livesearch.js"></script>

	<script src="../app/webroot/js/jquery.visualize.js"></script> 

	<script src="../app/webroot/js/jquery.validate.min.js"></script> 

	<script src="../app/webroot/js/jquery.datatables.js"></script>

	<script src="../app/webroot/js/reload_dtb.js"></script>

	<script src="../app/webroot/js/ajax.js"></script> 

	<script src="../app/webroot/js/jquery.placeholder.js"></script> 

	<script src="../app/webroot/js/jquery.tools.min.js"></script> 

	<script src="../app/webroot/js/jquery.colorbox-min.js"></script>

	</body>

</html>