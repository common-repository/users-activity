<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	extract(shortcode_atts(array('type' => "", 'number' => ""), $atts));
	$activities = get_option( '_ua_users_activities' );	
	if (!empty($activities)) { ?>
	<ul id="ua-activity-list" class="ua-activity">
		<?php			
			$number = !empty($number) ? $number : 30;
			$type = !empty($type) ? $type : '';
			$i = 1;
			foreach ($activities as $key => $val) {
				
				if ($val['type'] == $type || empty($type)){
					
					$time_diff = human_time_diff( $key, current_time('timestamp') );
					if ($val['type'] == 'post' && get_post_status($val['params'] ) == 'publish'){
						$post_id = $val['params'];
						
					?>
					<li class="ua-users-activity ua-users-post">
						<p> 
							<?php echo $val['user_name']; ?> <?php _e( 'published post', 'users-activity' ); ?>: <i><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title( $post_id );?></a></i><br/>
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
							<?php echo $val['user_name']; ?> <?php _e( 'commented on', 'users-activity' ); ?>: <i><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title( $post_id );?></a></i><br/>
							<span class="ago"><?php echo $time_diff;?></span>
						</p>								
					</li>
					<?php						
					}
					
					if ($val['type'] == 'register'){					
						
					?>
					<li class="ua-users-activity ua-users-register">
						<p> 
							<?php echo $val['user_name']; ?> <?php _e( 'registered', 'users-activity' ); ?> <br/>
							<span class="ago"><?php echo $time_diff;?></span>
						</p>								
					</li>
					<?php						
					}
					if ($i >= $number)
					break;					
					$i++;
				}
			}
		?>
	</ul>
	<?php
	}