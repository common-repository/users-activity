<?php if ( ! defined( 'ABSPATH' ) ) exit;?>
<tr>
	<th scope="row" colspan=2><h3><?php _e( 'Registration Email Settings', 'users-activity' ); ?></h3></th>	
</tr>

<tr>
	<th scope="row"><?php _e( 'Email Subject', 'users-activity' ); ?>:</th>
	<td>
		<input type='text' class="regular-text"  name='ua_options[reg_mail_subject]' value="<?php if(!empty($option['reg_mail_subject'])) { echo $option['reg_mail_subject']; } else { echo 'Notice of Activate Account';} ?>"/>	
		<p class="description"><?php _e( 'Enter the subject line for the email registration', 'users-activity' ); ?>.</p>	 
		
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Email', 'users-activity' ); ?>:</th>
	<td>		
		<?php
			$content = !empty($option['reg_success_email']) ? $option['reg_success_email'] : 'Hi, <b>{username}</b>! <p>This notice confirms that your account was created a success.</p> This email has been sent to {email}';
			wp_editor($content, 'wowregsuccessemail', array(
				'wpautop'       => 0,
				'media_buttons' => 1,
				'textarea_name' => 'ua_options[reg_success_email]',										
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
			<?php _e( 'Enter the text that is sent as email to users after account is activated. HTML is accepted. Available template tags', 'users-activity' ); ?>:
		</p>
		<i>{email} - <?php _e( 'User email on the site is specified at registration', 'users-activity' ); ?></i><br/>	
		<i>{username} - <?php _e( 'User name on the site is specified at registration', 'users-activity' ); ?></i><br/>		
		<i>{fname} - <?php _e( 'User First Name on the site is specified at registration', 'users-activity' ); ?> </i><br/>
		<i>{lname} - <?php _e( 'User Last Name on the site is specified at registration', 'users-activity' ); ?> </i><br/>	
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Disable', 'users-activity' ); ?></th>
	<td>
		<input type="checkbox" <?php if(!empty($option['reg_mail_disable'])) { echo 'checked="checked"'; }?>>
		<i><?php _e( 'Check this box if you do not want to send email to user', 'users-activity' ); ?>.	</i>
		<input type="hidden" name='ua_options[reg_mail_disable]' value="">
	</td>
</tr>

<tr>
	<th scope="row"><h3><?php _e( 'Confirmation email', 'users-activity' ); ?></h3></th>
	<td></td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Email Subject', 'users-activity' ); ?>:</th>
	<td>
		<input type='text' class="regular-text"  name='ua_options[mail_subject]' value="<?php if(!empty($option['mail_subject'])) { echo $option['mail_subject']; } else { echo 'Your new account';} ?>"/>	
		<p class="description"><?php _e( 'Enter the subject line to confirm email', 'users-activity' ); ?>.</p>	 
		
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Email', 'users-activity' ); ?>:</th>
	<td>		
		<?php
			$content = !empty($option['confirm_email']) ? $option['confirm_email'] : 'Hello, <b>{fname}</b>! <p>You have successfully registered.</p> Your login: {username}<br/>Your password: {password}<br/>To activate your account, please follow this link: {url_authorization}';
			wp_editor($content, 'wowconfirmemail', array(
				'wpautop'       => 0,
				'media_buttons' => 1,
				'textarea_name' => 'ua_options[confirm_email]',										
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
			<?php _e( 'Enter the text that is sent as email confirmation to users after submitting registration form. HTML is accepted. Available template tags', 'users-activity' ); ?>:
		</p>
		<i>{email} - <?php _e( 'User email on the site is specified at registration', 'users-activity' ); ?></i><br/>	
		<i>{username} - <?php _e( 'User name on the site is specified at registration', 'users-activity' ); ?></i><br/>		
		<i>{fname} - <?php _e( 'User First Name on the site is specified at registration', 'users-activity' ); ?> </i><br/>
		<i>{lname} - <?php _e( 'User Last Name on the site is specified at registration', 'users-activity' ); ?> </i><br/>		
	</td>
</tr>