<?php if ( ! defined( 'ABSPATH' ) ) exit;?>
<tr>
	<th scope="row" colspan=2><h3><?php _e( 'Registration Settings ', 'users-activity' ); ?></h3></th>	
</tr>

<tr>
	<th scope="row"><?php _e( 'Display First Name', 'users-activity' ); ?></th>
	<td>
		<input type="checkbox" <?php if(!empty($option['display_fname'])) { echo 'checked="checked"'; }?> id="display_fname">
		<i><?php _e( 'Check this box if you want to display First Name in the registration form', 'users-activity' ); ?></i>	
		<input type="hidden" name='ua_options[display_fname]' value="">
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Display Last Name', 'users-activity' ); ?></th>
	<td>
		<input type="checkbox" <?php if(!empty($option['display_lname'])) { echo 'checked="checked"'; }?> id="display_lname">
		<i><?php _e( 'First Name in the registration form', 'users-activity' ); ?></i>	
		<input type="hidden" name='ua_options[display_lname]' value="">
	</td>
</tr>

<tr>
	<th scope="row"><label for="ilc_tag_class"><?php _e( 'Message', 'users-activity' ); ?></label></th>
	<td>
		<?php
			$content = !empty($option['message']) ? $option['message'] : 'Please check your email {email} for a confirmation link to creation account';
			wp_editor($content, 'uamessage', array(
				'wpautop'       => 0,
				'media_buttons' => 1,
				'textarea_name' => 'ua_options[message]',										
				'tabindex'      => null,										
				'teeny'         => 0,
				'dfw'           => 0,
				'tinymce'       => 1,
				'quicktags'     => 1,
				'drag_drop_upload' => false
				)
			); 
		?>	 
		<p class="description"><?php _e( 'Enter message which user will see after submitting registration for', 'users-activity' ); ?></p>
		<i>{email} - <?php _e( 'User email on the site is specified at registration', 'users-activity' ); ?></i><br/>	
		<i>{username} - <?php _e( 'User name on the site is specified at registration', 'users-activity' ); ?></i><br/>		
		<i>{fname} - <?php _e( 'User First Name on the site is specified at registration', 'users-activity' ); ?> </i><br/>
		<i>{lname} - <?php _e( 'User Last Name on the site is specified at registration', 'users-activity' ); ?> </i><br/>
	</td>
</tr>