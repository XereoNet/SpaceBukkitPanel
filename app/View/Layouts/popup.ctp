<script type = "text/javascript">

$(function () {


  var tabContainers = $('section#content > div.tab2');
  tabContainers.hide().filter(':first').show();

  $('nav#popuptabs ul li a').click(function () {

          tabContainers.hide();
          tabContainers.filter(this.hash).show();
          $("nav#popuptabs ul li").removeClass("current");
          $(this).parent().addClass("current");

          return false;
  }).filter(':first').click();
                });

  </script>
<style>
  .error_box {
    position: absolute;
    top: -50px;
  }
</style>

<!-- Main Content Start -->
<div id="wrapper" class="popup">

	<?php echo $content_for_layout ?>

</div>
<!-- End #wrapper -->
