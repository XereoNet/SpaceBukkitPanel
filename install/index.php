<!DOCTYPE html>
<html>
<head>
<title>Install SpaceBukkit | Bukkit Web Administration</title>
<link rel="stylesheet" href="../app/webroot/css/import.css" /> 

<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="../app/webroot/themes/Spacebukkit/css/theme.css" /> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />

</head>
<body>
	<div id="header">
		<div id="container" class="login"> 		

			<div class="hheight">
				<div class="col left col_1_3">
					<h1 id="logo">SpaceBukkit</h1>
				</div>
			</div>
<section id="content"> 
<section class="box boxpad"> 
    <header>
        <div class="col left">
            <h2>Installing Spacebukkit</h2> 
        </div>
        <div class="col right" style="text-align: right">
            <h2>Error Notice</h2>
        </div>
    </header>

    <section class="installation">
	    <div class="triangle-border left">
		    <p><b>
		    	It seems like either your rewrite engine is not running or you first need to add some rewrite-rules!
		    	<br />SpaceBukkit uses .htaccess files and rewrite to create its URLs.
		    	<br />Please enable your rewrite engine and/or add the rewrite rules in the .htaccess file to your webservers config and restart your webserver.
		    </b></p>

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
		    
		    <p>Then I unfortunately can't help you here, visit our <a href="http://forums.xereo.net/">Forum</a> or try this <a href="http://www.google.com/">fine site</a>.</p>

	    </div>

	    <div class="clear"></div>
    </section>
    <header>
       <a href="../install" class="button icon arrowright reload leftsubmit">Refresh</a>
    </header>          
 </section>

<div class="clear"></div>
</section>

	</div>
		<div class="clearfooter"></div>
	</div>
	<script src="../app/webroot/js/compiled.js"></script> 
	<!--<script src="../app/webroot/js/ttw-simple-notifications-min.js"></script> 
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
	<script src="../app/webroot/js/jquery.colorbox-min.js"></script>-->
	</body>
</html>