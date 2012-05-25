<div id="bukget">
	<div class="top_bar">
		<h2>
		<?php echo __('Welcome to Bukget :)'); ?>
		</h2>
		<div class="bukget_search">
		<form method="get">
				<div>
				</div> 
		</form>
		</div>
	</div>
	<div class="binder">
		<div class="slider">
			<div id="first" class="additional-block">
				<div class="header">
					<h3>
					<?php echo __('Categories'); ?>
					</h3>
				</div>
				<ul class="menu">
					<?php

					$id = array();

					foreach ($cats as $cat) {

					$id[$cat] = str_replace(" ", "_", $cat);
						
						echo '<li><a href="#'.$id[$cat].'" class="has-child unloaded" rel="'.$id[$cat].'">'.$cat.'</a></li>';

					}

					?>
				</ul>
			</div>
<?php
foreach ($cats as $cat) {

echo <<<END
	<div id="$id[$cat]" class="additional-block">
				<div class="header">
					<h3>
					$cat

					</h3>
			    <input type="text" title="$id[$cat]" class="bukget_filter" id="$id[$cat]_filter" value="" placeholder="Filter $cat" />
				<div id="$id[$cat]_menu-nav" class="bukget_pagination"></div>


				</div>
				<ul class="menu" id="$id[$cat]_menu">
					
				</ul>
			</div>

END;

}

?>	
			</div>		
		</div>
	</div>
</div>

<script>
$("document").ready(function() {

	$('.more').live("click", function() {
		var li = $(this).parents("li.plugin");
		li.toggleClass("expanded");
		if (li.hasClass("expanded") == true) {
			$(this).text('Less info').removeClass("arrowdown").addClass("arrowup");
		} else {
			$(this).text('More info').removeClass("arrowup").addClass("arrowdown");	
		};

	});


	/*

	*	Sliding lists

	*/

	defaultWidth	= 920; //pixels
	transition		= 500; //millisecond
	
	function resetMargin(width) {
			
		divLeftMargin	= 0;
	
		$('.additional-block').each(function() {
			
			thisLeftMargin	= divLeftMargin + 'px';
			
			$(this).css('margin-left', thisLeftMargin);
			
			divLeftMargin	= divLeftMargin + width;

			
		});
	}
	
	resetMargin(defaultWidth);
	
	$('.menu a').each(function() {
		
		thisHref	= $(this).attr('href');
		
		if($(thisHref).length > 0) {
			$(this).addClass('has-child');
		}
		
	});
	
	$('.menu a.unloaded').live("click", function(event) {
		
		event.preventDefault();
		$(this).removeClass("unloaded").addClass("loaded");


		selectedDiv			= $(this).attr('href');
		selectedFilter		= selectedDiv+'_filter';
		selectedMenu		= selectedDiv+'_menu';
		selectedLis 		= selectedMenu+' li';
		source 				= "./bukget/getPlugins/"+$(this).attr('rel');
		ajax_load 			= '<div class="preloader"><div><img src="./img/big_loader.gif" /></div></div>'; 
		selectedMargin		= $(selectedDiv).css('margin-left');
		selectedParent		= $(this).parents('.additional-block');
		sliderMargin		= $('.slider').css('margin-left');
		slidingMargin		= (parseInt(sliderMargin) - defaultWidth) + 'px';
		
		//load in the plugins with ajax

		$(selectedMenu).html(ajax_load).load(source, function() 
		{
			$(selectedMenu).listnav();
		});

		$(selectedFilter).keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;


 
        // Loop through the comment list
        $(selectedLis).each(function(){
 
            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
            }
        });
 
    });

		
		if(selectedMargin.length > 0) {
			
			$(selectedDiv).children('.header').prepend('<span class="back"></span>');
			$("span.back").live('click', function () {
		
				selectedParent	= $(this).parents('.additional-block');
				sliderMargin	= - (parseInt(selectedParent.css('margin-left')) - defaultWidth) + 'px';
				$('.slider').animate({marginLeft: sliderMargin}, transition);
				
			});
				
			if((parseInt(selectedMargin) - defaultWidth) >= defaultWidth) {
			
				selectedParent.after($(selectedDiv));
				
				resetMargin(defaultWidth);
			
				$('.slider').animate({marginLeft: slidingMargin}, transition);
			
			} else {
			
				$('.slider').animate({marginLeft: slidingMargin}, transition);
		
			}
		}
	});

	$('.menu a.loaded').live("click", function(event) {
		
		event.preventDefault();
		
		selectedDiv			= $(this).attr('href');
		selectedMargin		= $(selectedDiv).css('margin-left');
		selectedParent		= $(this).parents('.additional-block');
		sliderMargin		= $('.slider').css('margin-left');
		slidingMargin		= (parseInt(sliderMargin) - defaultWidth) + 'px';
				
		if(selectedMargin.length > 0) {
			
			if((parseInt(selectedMargin) - defaultWidth) >= defaultWidth) {
			
				selectedParent.after($(selectedDiv));
				
				resetMargin(defaultWidth);
			
				$('.slider').animate({marginLeft: slidingMargin}, transition);
			
			} else {
			
				$('.slider').animate({marginLeft: slidingMargin}, transition);
		
			}
		}


	});

	$(".installer").live('click', (function(){

	  var source = $(this).attr("href");
	  var btn = $(this);


	  $(this).addClass("disable");
	  $.ajax({
	    url: source,
	    success: function(data) {
	        $(btn).removeClass("disable button favorite").addClass("nobutton approve").text("Installed! Reload or Restart to load it.");
	    }
	  });
	  return false;

	}));

});
</script>