<nav id="mainnav" class="popup">
    <h3>Add a permissions group</h3>
</nav>
<nav id="popuptabs">
</nav>
<!-- End Tabs -->

<!-- Content -->
<section id="content"> 
<div class="error_box"></div>

<div class="users form">
<form id="GroupAddForm" method="post" action="./tpermissions/addGroup">
  
    <section>
      <label for="groupn">
        Group Name
      </label>
    
      <div>
        <input id="groupn" name="groupn" type="text"/>
      </div>
    </section>

    <section>
      <label for="password">
        Default
      </label>
    
      <div>
        <input type="checkbox" name="default" value="0" id="default"/> 
      </div>
    </section>   

<input type="submit" class="button primary submit" value="Submit">
</form>
</div>
<div class="clear"></div>
</section>