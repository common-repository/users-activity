<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	global $current_user, $wp_roles;
	//get_currentuserinfo(); //deprecated since 3.1
	
	/* Load the registration file. */
	
	$error = array();    
	/* If profile was saved, update profile. */
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
		
		/* Update user password. */
		if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
			if ( $_POST['pass1'] == $_POST['pass2'] ){
				$pass1 = sanitize_text_field($_POST['pass1']);
				wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => $pass1 ) );
			}
			else {
				$error[] = __('Passwords you entered do not match. Your password was not updated.', 'users-activity');
			}
		}
		
		/* Update user information. */
		if ( !empty( $_POST['url'] ) )
        wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );
		if ( !empty( $_POST['email'] ) ){
			if (!is_email(esc_attr( $_POST['email'] )))
				$error[] = __('Email you entered is not valid. Please try again', 'users-activity');
			elseif(email_exists(esc_attr( $_POST['email'])) && email_exists(esc_attr( $_POST['email'])) != $current_user->ID)
				$error[] = __('This email is already used by another user. Try a different one.', 'users-activity');
			else{
				$email = sanitize_email($_POST['email']);
				wp_update_user( array ('ID' => $current_user->ID, 'user_email' => $email ));
			}
		}
		
		if ( !empty( $_POST['first-name'] ) ){
			$fname = sanitize_text_field($_POST['first-name']);
			update_user_meta( $current_user->ID, 'first_name', $fname );
		}
		if ( !empty( $_POST['last-name'] ) ){
			$lname = sanitize_text_field($_POST['last-name']);
			update_user_meta($current_user->ID, 'last_name', $lname );
		}
		if ( !empty( $_POST['description'] ) ) {
			$description = sanitize_textarea_field($_POST['description']);
			update_user_meta( $current_user->ID, 'description', $description );
		}
		if ( !empty( $_POST['nickname'] ) ) {
			$nickname = sanitize_text_field($_POST['nickname']);
			wp_update_user( array ('ID' => $current_user->ID, 'display_name' =>  $nickname));
		}
		
		
		/* Redirect so the page will show updated info.*/		
		if ( count($error) == 0 ) {
			//action hook for plugins and extra fields saving
			do_action('edit_user_profile_update', $current_user->ID);			
		}		
	}
	
if ( !is_user_logged_in() ) :	
?>
<div class="ua-alert ua-alert-error "><p class="ua_error">
	<?php _e('You must be logged in to edit your profile.', 'users-activity'); ?>
</p></div><!-- .warning -->
<?php else : 
	$user_login = get_the_author_meta( 'user_login', $current_user->ID );
	$first_name = get_the_author_meta( 'first_name', $current_user->ID );
	$last_name = get_the_author_meta( 'last_name', $current_user->ID );
	$nickname = get_the_author_meta( 'display_name', $current_user->ID );	
?>
<?php if ( count($error) > 0 ) echo '<div class="ua-alert ua-alert-error "><p class="ua_error">' . implode("<br />", $error) . '</p></div>'; ?>
<form method="post" id="adduser" class="ua-users-form" action="<?php the_permalink(); ?>">
	<p class="form-username">
		<label for="user-login"><?php _e('Username', 'users-activity'); ?></label>
		<input class="text-input" name="user-login" type="text" id="user-login" value="<?php echo $user_login; ?>" readonly disabled />
	</p><!-- .form-username -->
	<p class="form-username">
		<label for="first-name"><?php _e('First Name', 'users-activity'); ?></label>
		<input class="text-input" name="first-name" type="text" id="first-name" value="<?php echo $first_name; ?>" />
	</p><!-- .form-username -->	
	<p class="form-username">
		<label for="last-name"><?php _e('Last Name', 'users-activity'); ?></label>
		<input class="text-input" name="last-name" type="text" id="last-name" value="<?php echo $last_name; ?>" />
	</p><!-- .form-username -->	
	<p class="form-username">
		<label for="nickname"><?php _e('Nickname', 'users-activity'); ?></label>
		<input class="text-input" name="nickname" type="text" id="nickname" value="<?php echo $nickname; ?>" />
	</p><!-- .form-username -->	
	<p class="form-email">
		<label for="email"><?php _e('E-mail *', 'users-activity'); ?></label>
		<input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
	</p><!-- .form-email -->
	<p class="form-url">
		<label for="url"><?php _e('Website', 'users-activity'); ?></label>
		<input class="text-input" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
	</p><!-- .form-url -->
	<p class="form-password">
		<label for="pass1"><?php _e('Password *', 'users-activity'); ?> </label>
		<input class="text-input" name="pass1" type="password" id="pass1" />
	</p><!-- .form-password -->
	<p class="form-password">
		<label for="pass2"><?php _e('Repeat Password *', 'users-activity'); ?></label>
		<input class="text-input" name="pass2" type="password" id="pass2" />
	</p><!-- .form-password -->
	<p class="form-textarea">
		<label for="description"><?php _e('Biographical Information', 'users-activity') ?></label>
		<textarea name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
	</p><!-- .form-textarea -->
	
	<?php 
		//action hook for plugin and extra fields
		do_action('edit_user_profile',$current_user); 
	?>
	<p class="form-submit">		
		<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'users-activity'); ?>" />
		<?php wp_nonce_field( 'update-user' ) ?>
		<input name="action" type="hidden" id="action" value="update-user" />
	</p><!-- .form-submit -->
</form><!-- #adduser -->
<?php endif; ?>