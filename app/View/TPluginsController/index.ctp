
<!-- Tabs -->
<nav id="smalltabs">
	<ul>
		<li class="current"><a href="#tab1"><?php echo __('Plugins') ?></a></li>
		<li><a href="#tab2"><?php echo __('Manage') ?></a></li>
	</ul>
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content">

	<div class="tab" id="tab1">

<!-- 	<div class="alert alert-info">
	<p><?php echo __('This page might be slow with many plugins!'); ?></p>
	<p><?php echo __('Plugins with the <img src="img/bukget_enabled.png" /> Bukget Icon are automatically checked for Updates. Disabling a plugin will only disable it till the next reload or restart (we are working on a better solution :)') ?></p>
	</div> -->

  <div class="table_container">

    <header>

      <h2><?php echo __('Plugins') ?></h2>


    </header>

	  <table class="datatable adtb1">
	    <thead>
	      <tr>
	        <th><?php echo __('Status') ?></th>
	        <th><?php echo __('Name') ?></th>
	        <th><?php echo __('Version') ?></th>
	        <th><?php echo __('Authors') ?></th>
	        <th><?php echo __('Description') ?></th>
	        <th style="width: 300px"><?php echo __('Actions') ?></th>
	        <th><?php echo __('Info') ?></th>
	      </tr>
	    </thead>

	    <tbody>

	    </tbody>
	  </table>

	<div class="clear"></div>

	</div>

	</div><!--end tab1 -->

	<div class="tab" id="tab2">

	<div class="col left">

	<div class="table_container">

    <header>

      <h2><?php echo __('Update Checker') ?></h2>


    </header>
		<table class="datatable adtb2">
		<thead>
		  <tr>
		    <th><?php echo __('Name') ?></th>
		    <th><?php echo __('Version') ?></th>
		    <th><?php echo __('New Version') ?></th>
		    <th><?php echo __('Actions') ?></th>
		  </tr>
		</thead>

		<tbody>
        </tbody>
		</table>

	</div>

	</div>

	<div class="col right">

		<section class="box">

			<header>
			    <h2><?php echo __('Install Plugin') ?></h2>
			</header>

			<section>

				<table class="table">
				    <tbody>
				        <tr>
				            <td><?php echo __('Via Bukget (Recommended)') ?></td>
				            <td class="ar"><a href="./bukget2" class="button icon arrowright fancy big"><?php echo __('Bukget') ?></a></td>
				        </tr>
				        <tr>
				            <td>Via URL</td>
				            <td class="ar">
							    <form id="installPluginURL" class="installPluginURL" method="post" action="./tplugins/URLinstall">
							      <div>
							        <input id="url" name="url" onFocus="$(this).val('');" type="text" placeholder="" style="width: 60%;"/>
							    	<input type="submit" class="button primary submit installURL" value="<?php echo __('Install') ?>">
							      </div>
							    </form>
				            </td>
				        </tr>
				    </tbody>

				</table>

			</section>

		</section>

	</div><!--end left -->

	<div class="clear"></div>

	</div>

	<div class="clear"></div>

</section>
<!-- End #content -->
<script>
$('document').ready(function() {

  Table1 = $('.adtb1').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tplugins/getPlugins'
  });

  Table2 = $('.adtb2').dataTable( {
      "bProcessing": true,
      "sAjaxSource": './tplugins/checkPluginUpdates'
  });

	$(".ajax_table1").live('click', (function(){

	var source = $(this).attr("href");
	pos = $(this).closest("tr");
    var aPos = Table1.fnGetPosition(pos[0]);
    var plugin = Table1.fnGetData(aPos, 1);
	Table1.fnUpdate( ["", "", "", "Processing...", "", "", ""], aPos, 0);

	$.ajax({
	  url: source,
	  success: function(data) {

		  $.getJSON('./tplugins/getPlugin/' + plugin, function(data2) {

				    Table1.fnUpdate( data2, aPos, 0);
		  });

	      notifications.show({msg:data, icon:'img/win.png'});

	  }
	});
	      return false;

	}));

	$('.installURL').live('click', function (e) {
		e.preventDefault();
		$(this).addClass('disable');
		$("#url").addClass('disabled');
		var form = $('#installPluginURL');
		var file = form.find( 'input[name=url] ').val();
		form.find( 'input[name=url] ').val("Installing...");
		var url = form.attr('action');

		$.ajax({
			type: 'POST',
			url: url,
			data: {url: file},
			success: function (d) {
				var data = $.parseJSON(d);
				if (data.ret) {
					notifications.show({msg:data.msg, icon:'img/win.png'});
					form.find( 'input[name=url] ').val("Installed!");
				} else {
					notifications.show({msg:data.msg, icon:'img/fail.png'});
					form.find( 'input[name=url] ').val("Error!");
				}
				$('.installURL').removeClass('disable');
			}
		});
	});

});
</script>