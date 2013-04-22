
$(window).load(function () {
    $("#content").fadeIn(700);
});
$('document').ready(function () {

    $('#content').animate({
            opacity: 1,
            left: '0'
          }, 800, function() {
            // Animation complete.
      });

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

    $('.fancy').live('click', function (e) {
        href = $(this).attr('href');
        $.nmManual(href, {callbacks: {beforeShowCont: function() {
            $("select, input:checkbox, input:radio, input:file").uniform();
        }}});
        return false;
    });


    $('.bukget_pop').live('click', function (e) {
        href = $(this).attr('href');
        $.nmManual(href, {sizes: { W: 960, H: 648, initW: 960, initH: 648, hMargin: 0 }});
        return false;
    });

    $(".console-button").click(function() {
        $(".sidebar-wrap").each(function() { $(this).hide();});

            if (!($(this).hasClass('active'))) {
                $(this).siblings('.active').removeClass('active');
                $(this).addClass('active');
                $("#sidebar-console-wrap").show();
                $('#console-list').html('<div class="preloader"><div><img src="./img/big_loader.gif" /></div></div>');
            } else {
                $(this).removeClass('active');
            }
        return false;
    });

    $(".showOverlay").live('click', function() {
        var text = $(this).attr('rel');
        showOverlay(text);
    });

    $(".chat-button").click(function() {
        $(".sidebar-wrap").each(function() { $(this).hide();});

            if (!($(this).hasClass('active'))) {
                $(this).siblings('.active').removeClass('active');
                $(this).addClass('active');
                $("#sidebar-chat-wrap").show();
                $('.chat_chat').html('<div class="preloader"><div><img src="./img/big_loader.gif" /></div></div>');

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
    $('#console-list').attr('rel', rel).addClass('loading-console').html('<div class="preloader"><div><img src="./img/big_loader.gif" /></div></div>');

    e.preventDefault();
    return false;

  });

    $("select, input:checkbox, input:radio, input:file").uniform();
    $(".bounce").live('hover', function () {
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

    $(function () {
        var tabContainers = $('section#content > div.tab');
        tabContainers.hide().filter(':first').show();
        $('nav#smalltabs ul li a').click(function () {
            tabContainers.hide();
            tabContainers.filter(this.hash).fadeIn(700);
            $("nav#smalltabs ul li").removeClass("current");
            $(this).parent().addClass("current");
            return false;
        }).filter(':first').click();
    });

    $(".cdis").live('click', (function () {
        $(this).addClass("disable");
    }));
    $(".loginkey").live('click', (function () {
        $(this).addClass("disable");
        $("#content").fadeOut(700);
        $("#loading-container").fadeIn(700);
    }));
});