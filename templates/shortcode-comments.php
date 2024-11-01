<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
	$comments = get_comments(array('user_id' => $current_user->ID));?>		
	<div class="ua-block-list">
		<?php
			foreach ($comments as $comment) { ?>
			<div class="ua-block-wrap">
				<div class="comment">
					<p class="text-header"><?php echo $comment->comment_date;?></p>								
					<a href="<?php the_permalink($comment->comment_post_ID); ?>" class="reply"><?php _e( 'View Post', 'users-activity' ); ?></a>				
					<p><?php echo $comment->comment_content;?></p>
				</div>
				
			</div>
			<hr class="line-separator">
		<?php }	?>
		
	</div>
	<?php
		
	}
	else {
		echo '<div class="ua-alert ua-alert-error "><p class="ua_error">'.__( 'You must be logged in to view this page', 'users-activity' ).'</p></div>';	
	}			