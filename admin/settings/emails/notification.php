<?php if ( ! defined( 'ABSPATH' ) ) exit;?>
<tr>
	<th scope="row" colspan=2><h3><?php _e( 'User Notification Settings', 'users-activity' ); ?></h3></th>	
</tr>

<tr>
	<th scope="row"><?php _e( 'Email Subject', 'users-activity' ); ?>:</th>
	<td>
		<input type='text' class="regular-text"  name='ua_options[admin_mail_subject]' value="<?php if(!empty($option['admin_mail_subject'])) { echo $option['admin_mail_subject']; } else { echo 'New User Registration'; } ?>"/>	
		<p class="description"><?php _e( 'Enter the subject line for the email to admin', 'users-activity' ); ?></p>	 
		
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Email', 'users-activity' ); ?>:</th>
	<td>		
		<?php
			$content = !empty($option['admin_email']) ? $option['admin_email'] : '<p>New user registration on your site</p><p>Username: {username}</p><p>Email: {email}</p>';
			wp_editor($content, 'uaadminmail', array(
				'wpautop'       => 0,
				'media_buttons' => 0,
				'textarea_name' => 'ua_options[admin_email]',										
				'tabindex'      => null,										
				'teeny'         => 0,
				'dfw'           => 0,
				'tinymce'       => 1,
				'quicktags'     => 1,
				'drag_drop_upload' => false
				)
			); 
		?>	
		<p class="description">
			<?php _e( 'Enter the text that is sent as email to users after account is activated. HTML is accepted. Available template tags', 'users-activity' ); ?>:</p>
			<i>{email} - <?php _e( 'User email on the site is specified at registration', 'users-activity' ); ?></i><br/>	
			<i>{username} - <?php _e( 'User name on the site is specified at registration', 'users-activity' ); ?></i><br/>		
			<i>{fname} - <?php _e( 'User First Name on the site is specified at registration', 'users-activity' ); ?> </i><br/>
			<i>{lname} - <?php _e( 'User Last Name on the site is specified at registration', 'users-activity' ); ?> </i><br/>
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Disable', 'users-activity' ); ?></th>
	<td>
		<input type="checkbox" <?php if(!empty($option['admin_mail_disable'])) { echo 'checked="checked"'; }?>>
		<i><?php _e( 'Check this box if you do not want to send email to admin', 'users-activity' ); ?></i>
		<input type="hidden" name="ua_options[admin_mail_disable]" value="">
	</td>
</tr>