<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	if ( is_user_logged_in() ) { 
		$user_id = get_current_user_id();
		$activity = get_user_meta( $user_id, '_ua_user_activity', true );
		if (!empty($activity)) { ?>
		<ul id="ua-activity-list" class="ua-activity">
			<?php
				krsort($activity);
				foreach ($activity as $key => $val) {						
					$time_diff = human_time_diff( $key, current_time('timestamp') );
					if ($val['type'] == 'post' && get_post_status($val['params'] ) == 'publish'){
						$post_id = $val['params'];
						
					?>
					<li class="ua-users-activity ua-users-post">
						<p> 
							<?php _e( 'Published post', 'users-activity' ); ?>: <i><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title( $post_id );?></a></i><br/>
							<span class="ago"><?php echo $time_diff;?></span>
						</p>								
					</li>
					<?php						
					}
					
					if ($val['type'] == 'comment'){
						$post_id = $val['params'];
						
					?>
					<li class="ua-users-activity ua-users-comment">
						<p> 
							<?php _e( 'Commented on', 'users-activity' ); ?>: <i><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title( $post_id );?></a></i><br/>
							<span class="ago"><?php echo $time_diff;?></span>
						</p>								
					</li>
					<?php						
					}
					
					if ($val['type'] == 'register'){					
						
					?>
					<li class="ua-users-activity ua-users-register">
						<p> 
							<?php _e( 'Registered', 'users-activity' ); ?> <br/>
							<span class="ago"><?php echo $time_diff;?></span>
						</p>								
					</li>
					<?php						
					}
					
				}
				
			?>
		</ul>
		<?php
		}
		
	}
	else {
		echo '<div class="ua-alert ua-alert-error "><p class="ua_error">'.__( 'You must be logged in to view this page', 'users-activity' ).'</p></div>';
	}		