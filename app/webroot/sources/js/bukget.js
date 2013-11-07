$("document").ready(function() {
	/*

	*	Sliding lists

	*/

	defaultWidth	= 580; //pixels
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
			//$(selectedMenu).listnav();
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