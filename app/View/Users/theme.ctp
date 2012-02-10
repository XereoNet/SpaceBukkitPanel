<nav id="mainnav" class="popup">
    <h3>Theme settings for <?php echo $username; ?></h3>
</nav>
<!-- Tabs -->
<nav id="popuptabs">
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 

 <table class="datatable tdtb notitle"> 
    <thead> 
      <tr> 
        <th>Thumbnail</th> 
        <th>Theme</th> 
        <th>Version</th> 
        <th>Author</th> 
        <th>Description</th> 
        <th>Link</th> 
        <th>Action</th> 
      </tr> 
    </thead> 
    <tbody> 
	<?php include 'findthemes.php'; ?>
    </tbody> 
  </table> 
     	
<div class="clear"></div>
</section>
<!-- End #content --> 
<script>
$(document).ready(function() {

  $(".tdtb").dataTable();
    
});
</script>