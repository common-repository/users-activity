<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<a href="<?php echo admin_url('user-edit.php?user_id='.$customer_id); ?>" class="button button-primary"><?php _e( 'Edit User', 'users-activity' ); ?></a>
<table class="form-table">
	<tr>
		<th scope="row"><?php _e( 'Username', 'users-activity' ); ?>:</th>
		<td>
			<?php echo $customer->user_login;?>		
		</td>
	</tr>
	
	<tr>
		<th scope="row"><?php _e( 'First Name', 'users-activity' ); ?>:</th>
		<td>
			<?php echo $customer->first_name;?>			
		</td>
	</tr>
	
	<tr>
		<th scope="row"><?php _e( 'Last Name', 'users-activity' ); ?>:</th>
		<td>
			<?php echo $customer->last_name;?>		
		</td>
	</tr>
	
	<tr>
		<th scope="row"><?php _e( 'Email', 'users-activity' ); ?>:</th>
		<td>
			<?php echo $customer->user_email;?>		
		</td>
	</tr>
	
	<tr>
		<th scope="row"><?php _e( 'Registration', 'users-activity' ); ?>:</th>
		<td>
			<?php echo $customer->user_registered;?>	
		</td>
	</tr>
	
	
	<tr>
		<th scope="row"><?php _e( 'Comments', 'users-activity' ); ?>:</th>
		<td>
			<?php if($comments_count > 0 ) { echo '<a href="?page=users-activity&tool=user&user_id='.$customer_id.'&tab=activity&submenu=comments">'.$comments_count.'</a>';} else {echo $comments_count; };?>		
		</td>
	</tr>
	
	<tr>
		<th scope="row"><?php _e( 'Posts', 'users-activity' ); ?>:</th>
		<td>
			<?php if($posts_count > 0 ) { echo '<a href="?page=users-activity&tool=user&user_id='.$customer_id.'&tab=activity&submenu=posts">'.$posts_count.'</a>';} else {echo $posts_count; };?>		
		</td>
	</tr>
	
</table>