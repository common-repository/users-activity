<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
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
		}		
	?>
</ul>