
$(window).load(function () {
    $("#content").fadeIn(700);
});
$('document').ready(function () {
    
    $('.slideDown').animate({
        opacity: 'toggle',
        height: 'toggle'
    }, "slow");
    $(".fadein").each(function (i) {
        $(this).delay(i * 150).fadeIn(500);
    });
    $('#mainnav a').click(function () {
        $("#loading").fadeIn();
    });
    $('.fancy').live('click', function () {
        $.fn.colorbox({
            href: $(this).attr('href'),
            open: true,
            'top': '2%',
            "scrolling": false
        });
        return false;
    });

    $(".console-button").click(function() {
        $(".sidebar-wrap").each(function() { $(this).hide();});

            if (!($(this).hasClass('active'))) {
                $(this).siblings('.active').removeClass('active');             
                $(this).addClass('active');
                $("#sidebar-console-wrap").show();
            } else {
                $(this).removeClass('active');
            }

        return false;
    });
   

    $(".chat-button").click(function() {
        $(".sidebar-wrap").each(function() { $(this).hide();});

            if (!($(this).hasClass('active'))) {
                $(this).siblings('.active').removeClass('active');
                $(this).addClass('active');
                $("#sidebar-chat-wrap").show();
            } else {
                $(this).removeClass('active');
            }

        return false;
    });
                         
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("widget-reset")) {
        $(".sidebar-wrap").each(function() { $(this).hide();});
        $(".widget-reset").find('a.active').removeClass('active');    
    }
    });

  $('.console-controls ul li a').click(function(e) {

    var rel = $(this).attr('rel');
    var console_url = './global/getConsole/'+rel;

    $('.console-controls li').each(function () { $(this).removeClass('selected-1'); });
    $(this).parent('li').addClass('selected-1');
    $('#console-list').attr('rel', rel).html('<div class="preloader"><div><img src="./img/big_loader.gif" /></div></div>');
   
    e.preventDefault();  
    return false;

  });

    $(document).bind('cbox_complete', function () {
        $("select, input:checkbox, input:radio, input:file").uniform();
    });
    $("select, input:checkbox, input:radio, input:file").uniform();
    $(".bounce").hover(function () {
        $(this).stop().animate({
            opacity: 0.75,
            marginTop: -10
        }, 500);
    }, function () {
        $(this).stop().animate({
            opacity: 1.0,
            marginTop: 0
        }, 500);
    });
    $(".tip").tooltip({
        position: "bottom center",
        effect: "fade",
        relative: "true"
    });
    $(".rtip").tooltip({
        position: "center right",
        effect: "fade",
        relative: "true",
        offset: [0, -35]
    });
    $(".ltip").tooltip({
        position: "bottom right",
        effect: "fade",
        relative: "true"
    });
    $(".dtb").dataTable();
    //$('input[type="text"]').placeholderFunction('input-focused');
    $(function () {
        var tabContainers = $('section#content > div.tab');
        tabContainers.hide().filter(':first').show();
        $('nav#smalltabs ul li a').click(function () {
            tabContainers.hide();
            tabContainers.filter(this.hash).show();
            $("nav#smalltabs ul li").removeClass("current");
            $(this).parent().addClass("current");
            return false;
        }).filter(':first').click();
    });
    var colors = ['#005ba8', '#EE1F10', '#92d5ea', '#1175c9', '#8d10ee', '#5a3b16', '#26a4ed', '#f45a90', '#e9e744'];
    $('.barchart').visualize({
        type: 'bar',
        colors: colors
    });
    $('.linechart').visualize({
        type: 'line',
        lineWeight: 2,
        colors: colors
    });
    $('.areachart').visualize({
        type: 'area',
        lineWeight: 1,
        colors: colors
    });
    $('.piechart').visualize({
        type: 'pie',
        colors: colors
    });
    $('.barchart, .linechart, .areachart, .piechart').hide();
    $(".ajax_btn").live('click', (function () {
        var source = $(this).attr("href");
        var btn = $(this);
        $(this).addClass("disable");
        $.ajax({
            url: source,
            success: function (data) {
                notifications.show({
                    msg: data,
                    icon: 'img/win.png'
                });
                $(btn).removeClass("disable");
            }
        });
        return false;
    }));
    $(".cdis").live('click', (function () {
        $(this).addClass("disable");
    }));
    $(".loginkey").live('click', (function () {
        $(this).addClass("disable");
        $("#content").fadeOut(700);
        $("#loading-container").fadeIn(700);
    }));
});