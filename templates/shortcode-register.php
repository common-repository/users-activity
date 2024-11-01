<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	if ( !is_user_logged_in() ) {
		$option = get_option('ua_options');
	?>
	<?php do_action( 'ua_form_error' ); ?>
	<form id="ua_reg_user_form" class="ua-users-form" action="" method="post">
		<?php do_action( 'ua_register_form_fields_top' ); ?>	
		<fieldset>	
			<p>
				<label for="ua-user-login"><?php _e( 'Username', 'users-activity' ); ?></label>
				<input id="ua-user-login" class="required ua-input" type="text" name="ua_user_name"/>
				<small><?php _e( 'Required. Only lower case letters (a-z) and numbers (0-9) are allowed', 'users-activity' ); ?></small>				
			</p>
			
			<p>
				<label for="ua-user-email"><?php _e( 'Email', 'users-activity' ); ?></label>
				<input id="ua-user-email" class="required ua-input" type="email" name="ua_user_email"/>
				<small><?php _e( 'Required. Your password will be emailed here', 'users-activity' ); ?></small>
			</p>
			<?php if(!empty($option['display_fname'])){ ?>
				<p>
					<label for="ua-user-fname"><?php _e( 'First Name', 'users-activity' ); ?></label>
					<input id="ua-user-fname" class="required ua-input" type="text" name="ua_user_fname" />
				</p>
				<?php } if(!empty($option['display_lname'])){ ?>
				<p>
					<label for="ua-user-lname"><?php _e( 'Last Name', 'users-activity' ); ?></label>
					<input id="ua-user-lname" class="required ua-input" type="text" name="ua_user_lname" />
				</p>
			<?php } ?>
			<p>			
				<input type="hidden" name="ua_action" value="user_register" />
				<input type="hidden" name="ua_redirect" value=""/>
				<input class="button" name="ua_register_submit" type="submit" value="Register" />
			</p>
			
		</fieldset>
		
		<?php do_action( 'ua_register_form_fields_bottom' ); ?>
		</form>
	<?php } 
