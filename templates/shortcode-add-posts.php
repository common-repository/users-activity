<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	if ( is_user_logged_in() ) {	
		if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] && wp_verify_nonce($_POST['ua_add_post'],'new-post') )) {			
			// Do some minor form validation to make sure there is content
			if (!empty ($_POST['title'])) {
				$title =  sanitize_text_field($_POST['title']);
				} else {
				echo '<div class="ua-alert ua-alert-error "><p class="ua_error">'.__( 'Please enter a title', 'users-activity' ).'</p></div>';				
			}
			if (!empty ($_POST['description'])) {
				$description = sanitize_textarea_field($_POST['description']);
				} else {
				echo '<div class="ua-alert ua-alert-error "><p class="ua_error">'.__( 'Please enter the content', 'users-activity' ).'</p></div>';
			}
			$tags = $_POST['post_tags'];			
			if (!empty ($_POST['title']) && !empty ($_POST['description'])) {
				// Add the content of the form to $post as an array
				$post = array(
					'post_title'	=> $title,
					'post_content'	=> $description,
					'post_category'	=> array(sanitize_text_field($_POST['cat'])),  
					'tags_input'	=> $tags,
					'post_status'	=> 'pending',				
				);
				$post_id = wp_insert_post($post);  // Pass  the value of $post to WordPress the insert function	
				$option = get_option('ua_users');
				if (!empty($option['add_post']))
				do_action( 'ua_add_user_activity', 'post', $post_id );
				echo '<div class="ua-alert ua-alert-update"><p class="ua_error">'.__( 'The post was successfully sent for review', 'users-activity' ).'</p></div>';
			}
		} // end IF
		
	?>
	
	<form method="post" action="<?php echo get_permalink();?>" class="ua-users-form">
		<fieldset>
			<!-- post title -->
			<p>
				<label for="title"><?php _e( 'Title', 'users-activity' ); ?></label>
				<input type="text" id="title" value="" tabindex="5" name="title" />
			</p>			
			
			<!-- post Category -->
			<p>
				<label for="category"><?php _e( 'Category', 'users-activity' ); ?></label>
				<?php wp_dropdown_categories( 'tab_index=10&taxonomy=category&hide_empty=0' ); ?>
			</p>
			
			<!-- post Content -->
			<p>
				<label for="content"><?php _e( 'Content', 'users-activity' ); ?></label>
				<?php 
					$content = '';
					$editor_id = 'description';
					$settings =   array(
					'wpautop' => true, 
					'media_buttons' => 1, 
					'textarea_name' => $editor_id, 
					'textarea_rows' => get_option('default_post_edit_rows', 10), 
					'tabindex' => '',
					'editor_css' => '',
					'editor_class' => '', 
					'teeny' => false, 
					'dfw' => false, 
					'tinymce' => true, 
					'quicktags' => true 
					);
				wp_editor( $content, $editor_id, $settings ); ?>
				
			</p>			
			
			<!-- post tags -->
			<p>
				<label for="tags"><?php _e( 'Additional Keywords (comma separated)', 'users-activity' ); ?></label>
				<input type="text" value="" tabindex="35" name="post_tags" id="post_tags" />
			</p>
			
			<input type="submit" value="<?php _e( 'Post Review', 'users-activity' ); ?>" tabindex="40" id="submit" name="submit" />			
			<input type="hidden" name="action" value="new_post" />
			<?php wp_nonce_field( 'new-post', 'ua_add_post' ); ?>
		</fieldset>
	</form>	
	<?php
	}
	else {
		echo '<div class="ua-alert ua-alert-error "><p class="ua_error">'.__( 'You must be logged in to view this page', 'users-activity' ).'</p></div>';
	}
?>
