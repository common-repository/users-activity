<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">
	<h2><?php _e( 'User Details', 'users-activity' ); ?></h2>	
	<?php	
		$user_id = sanitize_text_field($_GET['user_id']);
		$render = true;		
		if ( ! isset( $user_id ) || ! is_numeric( $user_id ) ) {		
			$render = false;
		}	
		global $post;
		$customer_id = absint($user_id);	
		$customer    = get_userdata( $customer_id );	
		$comments_count = get_comments(array('user_id' => $customer_id, 'count' => true));
		$comments = get_comments(array('user_id' => $customer_id));
		$posts_count = count_user_posts($customer_id);
		$posts = get_posts(array('author' => $customer_id, 'numberposts' => 0));
		$activity = get_user_meta( $customer_id, '_ua_user_activity', true );		
		$current = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'main';	
		$tabs = array( 'main' => 'User', 'activity' => 'Activity' ); 
		$links = array();		
		echo '<h2 class="nav-tab-wrapper">';
		foreach( $tabs as $tab => $name ){
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			if(empty($activity) && $tab == 'activity')
			continue;
			echo "<a class='nav-tab$class' href='?page=users-activity&tool=user&user_id=".$customer_id."&tab=$tab'>$name</a>";		
		}
		echo '</h2>';		
		$sub_activity = array( 'main' => 'Activity', 'posts' => 'Posts', 'comments' => 'Comments' );		
		if($current === 'activity'){
			$current_sub = (isset($_GET['submenu'])) ? sanitize_text_field($_GET['submenu']) : 'main';
			$count_sub = count($sub_activity);			
			echo '<div><ul class="subsubsub">';
			$number = 0;
			foreach( $sub_activity as $sub_key => $sub_name ){
				if($sub_key == 'posts' && $posts_count == 0)
				continue;
				if($sub_key == 'comments' && $comments_count == 0)
				continue;
				if($sub_key == 'comments'){
					$count = '('.$comments_count.')';
				}
				elseif($sub_key == 'posts'){
					$count = '('.$posts_count.')';
				}
				else {
					$count = '';
				}
				echo '<li>';
				$number++;
				$tab_url = add_query_arg( array(					
				'tab' => $current,
				'submenu' => $sub_key,
				) );
				$class = '';
				if ( $sub_key == $current_sub ) {
					$class = 'current';
				}
				echo '<a class="' . $class . '" href="' . esc_url( $tab_url ) . '">' . $sub_name . $count. '</a>';
				
				if ( $number != $count_sub ) {
					echo ' | ';
				}				
				echo '</li>';
			}
			echo '</ul></div>';
		}	
		
	?>
	
	<div id="poststuff" class="ua-panel">		
		<?php 				
			switch ( $current ){
				case 'main' :	
				if (empty($activity)){
					echo '
					<div id="message" class="notice notice-warning">
					<p>'.__('No user activity yet. Please, import activity for user.', 'users-activity' ).'</p>
					</div>';
				}
				include_once ($current.'-user.php');					
				break;
				case 'activity' :											
				include_once ($current.'-'.$current_sub.'.php');					
				break;
			}
			
		?>		
	</div>	
</div>	