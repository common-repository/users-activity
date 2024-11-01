<?php if ( ! defined( 'ABSPATH' ) ) exit;?>
<tr>
	<th scope="row" colspan=2><h3><?php _e( 'Email Settings ', 'users-activity' ); ?></h3></th>	
</tr>

<tr>
	<th scope="row"><?php _e( 'From Name', 'users-activity' ); ?>:</th>
	<td>
		<input type='text' class="regular-text" name='ua_options[from_text]' value="<?php if(!empty($option['from_text'])) { echo $option['from_text']; } else { echo get_option('blogname'); } ?>"/>	
		<p class="description"><?php _e( 'Email addresser. This should probably be your site', 'users-activity' ); ?>.</p>	 
		
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'From Email', 'users-activity' ); ?>:</th>
	<td>
		<input type='text' class="regular-text" name='ua_options[from_mail]' value="<?php if(!empty($option['from_mail'])) { echo $option['from_mail']; } else { echo get_option('admin_email'); } ?>"/>	
		<p class="description"><?php _e( 'Email is send from. This will act as the "from" and "reply-to" address', 'users-activity' ); ?>.</p> 
		
	</td>
</tr>