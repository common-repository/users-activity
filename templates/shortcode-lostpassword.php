<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	if ( !is_user_logged_in() ) {
		if (isset($_GET['errors'])){
			if ($_GET['errors'] === 'invalidcombo') {
				echo '<div class="ua-alert ua-alert-error "><p class="ua_error"><strong>'.__( 'ERROR', 'users-activity' ).'</strong>: '.__( 'Invalid username or e-mail.', 'users-activity' ).'</p></div>';
			}
			if ($_GET['errors'] === 'empty_username') {
				echo '<div class="ua-alert ua-alert-error "><p class="ua_error"><strong>'.__( 'ERROR', 'users-activity' ).'</strong>: '.__( 'Enter a username or e-mail address.', 'users-activity' ).'</p></div>';
			}
		}
		if (isset($_GET['checkemail'])){ 
			echo '<div class="ua-alert ua-alert-update "><p class="ua_error">'.__( 'A link to change the password was sent to you by e-mail', 'users-activity' ).'</p></div>';
		}
		
	?>
	<form id="lostpasswordform" class="ua-users-form" action="<?php echo wp_lostpassword_url(); ?>" method="post">
		<p class="form-row">
			<label for="user_login">Username or Email Address
				<input type="text" name="user_login" id="user_login">
			</p>
			
			<p class="lostpassword-submit">
				<input type="submit" name="submit" class="lostpassword-button"
				value="Reset Password"/>
			</p>
		</form>			
		<?php } 
		