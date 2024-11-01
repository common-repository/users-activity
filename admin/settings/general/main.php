<?php if ( ! defined( 'ABSPATH' ) ) exit;?>
<tr>
	<th scope="row" colspan=2><h3><?php _e( 'General Settings', 'users-activity' ); ?></h3></th>	
</tr>
<tr>
	<th scope="row"><?php _e( 'Activity', 'users-activity' ); ?>:</th>
	<td>
		<input type="checkbox" <?php if(!empty($option['new_user'])) { echo 'checked="checked"'; } ?> id="new_user"> <label for="new_user"> <?php _e( 'Registration', 'users-activity' ); ?> </label><br/>
		<input type="checkbox" <?php if(!empty($option['add_post'])) { echo 'checked="checked"'; } ?> id="add_post"> <label for="add_post"> <?php _e( 'Post creation', 'users-activity' ); ?></label><br/>
		<input type="checkbox" <?php if(!empty($option['add_comment'])) { echo 'checked="checked"'; } ?> id="add_comment"> <label for="add_comment"> <?php _e( 'New comment', 'users-activity' ); ?></label>	
		<input type="hidden" name="ua_options[new_user]" value="">
		<input type="hidden" name="ua_options[add_post]" value="">
		<input type="hidden" name="ua_options[add_comment]" value="">		
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Login redirect', 'users-activity' ); ?>:</th>
	<td>
		<input type="text" class="regular-text" placeholder="" name='ua_options[login_redirect]' value="<?php if(!empty($option['login_redirect'])) echo $option['login_redirect']; ?>">	
		<p class="description"><?php _e( 'Leave the field blank to redirect to the current page', 'users-activity' ); ?></p>	
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Logout redirect', 'users-activity' ); ?>:</th>
	<td>
		<input type="text" class="regular-text" placeholder="" name='ua_options[logout_redirect]' value="<?php if(!empty($option['logout_redirect'])) echo $option['logout_redirect']; ?>">	
		<p class="description"><?php _e( 'Leave the field blank to redirect to the current page', 'users-activity' ); ?></p>
	</td>
</tr>

<tr>
	<th scope="row"><?php _e( 'Registration redirect', 'users-activity' ); ?>:</th>
	<td>
		<input type="text" class="regular-text" name='ua_options[reg_redirect]' value="<?php if(!empty($option['reg_redirect'])) { echo $option['reg_redirect']; } else {echo get_option('home');} ?>">	
		<p class="description"><?php _e( 'Enter url for redirection after user confirms email and registers', 'users-activity' ); ?></p>
	</td>
</tr>