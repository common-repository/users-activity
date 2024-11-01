<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();		
		$posts = get_posts(array('author' => $current_user->ID, 'numberposts' => 0));
	?>	
	<div class="ua-block-list">
		<?php
			foreach ($posts as $post) { 
				setup_postdata($post);
			?>
			<div class="ua-block-wrap">
				<div class="comment">
					<p class="text-header"><?php echo get_the_title($post->ID);?></p>
					<p class="timestamp"><?php echo get_the_date('Y-m-d', $post->ID);?></p>
					<a href="<?php echo get_the_permalink($post->ID); ?>" class="reply">View Post</a>					
					<p><?php echo get_the_excerpt($post->ID);?></p>
				</div>				
			</div>
			<hr class="line-separator">
		<?php }	wp_reset_postdata();	?>
		
	</div>
	<?php
		
	}
	else {
		echo '<div class="ua-alert ua-alert-error "><p class="ua_error">'.__( 'You must be logged in to view this page', 'users-activity' ).'</p></div>';	
	}			