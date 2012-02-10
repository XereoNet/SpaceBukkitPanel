<!-- Content -->
<section id='content'> 

<section class='box boxpad'> 
 
    <header>
        <div class='col left'>
            <h2><?php echo __('Installing Spacebukkit') ?></h2> 
        </div>    
        <div class='col right' style='text-align: right'>
            <h2>3 of 5 | DATABASE</h2>
        </div>
    </header>

    <section class='installation'>

    <div class='col left col_1_3 '>
    <img src='<?php echo $this->Html->url('http://dl.dropbox.com/u/23235766/avatar.png', true); ?>' /><br />    <p>Hi I'm Jamy, I do all sorts of stuff :D!</p>
        <?php 
    if (isset($result)) {
    	echo '<p class="failed">Your settings are invalid, the following errors occoured:</p>';
    	echo '<div class="code">'.$result.'</div>';

    }
?><div class="error_box"></div>

    </div>
 
    <div class='col right col_2_3'>

    <div class='triangle-border left'>

    <p>Now please enter your database settings below. The installer will test your settings after you click "next"!</p><br />

		<form action='<?php echo $this->Html->url('/install/step2', true); ?>' id='db' method='post'>

			<table cellpadding='2'>
				<tr>
					<td>Hostname</td>
					<td><input type='text' name='host' id='hostname' value='' size='30' tabindex='1' placeholder='(usually localhost)'/></td>
				</tr>
				<tr>
					<td>Username</td>
					<td><input type='text' name='login' id='username' value='' size='30' tabindex='2' /></td>
					<td></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type='text' name='password' id='password' value='' size='30' tabindex='3' /></td>
					<td></td>
				</tr>
				<tr>
					<td>Database</td>
					<td><input type='text' name='database' id='database' value='' size='30' tabindex='4' /></td>
				</tr>
            </table>

    </div>

    </div>

    <div class='clear'></div>

    </section> 
      
    <header>
       <a href='<?php echo $this->Html->url('/install/step1', true); ?>' class='button icon arrowleft'>Previous</a>
       <input type='submit' id='submit' value='Next' tabindex='5' class='button leftsubmit' />
		
	</form>
    </header>                   
 </section>

<div class='clear'></div>
</section>
<!-- End #content --> 
<script>
$('document').ready(function(){
    var validator = new FormValidator('db', [{
        name: 'hostname',
        display: 'hostname',    
        rules: 'required'
    }, {
        name: 'username',
        display: 'username',    
        rules: 'required'
    }, {
        name: 'database',
        display: 'database',    
        rules: 'required'
    }], function(errors, event) {    
            var SELECTOR_ERRORS = $('.error_box');     
            
            if (errors.length > 0) {        
              SELECTOR_ERRORS.empty();        
              SELECTOR_ERRORS.append(errors.join('<br />'));
              SELECTOR_ERRORS.fadeIn(200);   
              event.preventDefault();    
              } else {        
              SELECTOR_ERRORS.css({ display: 'none' });       
              }        
    });
});
</script>