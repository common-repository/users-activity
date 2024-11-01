<?php if ( ! defined( 'ABSPATH' ) ) exit;
	/**
		* Users Export Import
		*
		* @package     USERS_ACTIVITY
		* @subpackage  Includes/Users
		* @copyright   Copyright (c) 2017, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       2.3
	*/
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;
	/**
		* UA_Users Class
		*
		* @since 1.0
	*/
	class USERS_ACTIVITY_USERS { 
		public function __construct() {			
			add_action( 'admin_init', array($this, 'export_import') );			
		}
		function export_import() { 
			if( isset($_POST['ua-csv-file'] )) {
				if( wp_verify_nonce($_POST['ua_export_all_field'],'ua_export_all_action') && current_user_can('manage_options') ){
					$filename = "users.csv";
					$fp = fopen('php://output', 'w');					
					header('Content-type: application/csv');
					header('Content-Disposition: attachment; filename='.$filename);					
					fputcsv($fp, array('ID','Username','First Name', 'Last Name', 'Email', 'Registration'));					
					$customers = get_users();					
					foreach ( $customers as $customer ) {
						$user = get_userdata( $customer->ID );
						fputcsv($fp, array($customer->ID, $user->user_login, $user->first_name, $user->last_name, $user->user_email, $user->user_registered));						
					}					
					exit;
				}
			}
			if( isset($_POST['action'] )) {
				if ($_POST['action'] === 'ua-export') {
					if( wp_verify_nonce($_POST['ua_export_field'],'ua_export_action') && current_user_can('manage_options') ){
						$ids = isset( $_POST['ID'] ) ? $_POST['ID'] : false;
						if ( ! is_array( $ids ) )
						$ids = array( $ids );									
						$filename = "users.csv";
						$fp = fopen('php://output', 'w');					
						header('Content-type: application/csv');
						header('Content-Disposition: attachment; filename='.$filename);					
						fputcsv($fp, array('ID','Username','First Name', 'Last Name', 'Email', 'Registration'));	
						foreach ( $ids as $id ) {
							$user = get_userdata( $id );
							fputcsv($fp, array($id, $user->user_login, $user->first_name, $user->last_name, $user->user_email, $user->user_registered));
						}
						exit;
					}
				}
				if ($_POST['action'] === 'ua-import-activity') {
					if( wp_verify_nonce($_POST['ua_export_field'],'ua_export_action') && current_user_can('manage_options') ){
						$ids    = isset( $_POST['ID'] ) ? $_POST['ID'] : false;
						if ( ! is_array( $ids ) )
						$ids = array( $ids );
						foreach ( $ids as $id ) {
							$posts = get_posts(array('author' => $id, 'numberposts' => 0));
							if( $posts ){
								foreach($posts as $post){		
									$activity = get_user_meta( $post->post_author, '_ua_user_activity', true );
									$new_activity = array('type' => 'post', 'params' => $post->ID);
									$key = strtotime($post->post_date);
									if (empty($activity)){
										$activity = array($key => $new_activity);
									}
									else {
										$activity[$key] = $new_activity;					
									}
									update_user_meta($post->post_author, '_ua_user_activity', $activity);
									do_action( 'ua_add_users_activities', $post->post_author, $key, 'post', $post->ID );
								}
							}
							$comments = get_comments(array('user_id' => $id));
							if( $comments ){
								foreach( $comments as $comment ){
									$activity = get_user_meta( $comment->user_id, '_ua_user_activity', true );
									$new_activity = array('type' => 'comment', 'params' => $comment->comment_post_ID);
									$key = strtotime($comment->comment_date);
									if (empty($activity)){
										$activity = array($key => $new_activity);
									}
									else {
										$activity[$key] = $new_activity;					
									}
									update_user_meta($comment->user_id, '_ua_user_activity', $activity);
									do_action( 'ua_add_users_activities', $comment->user_id, $key, 'comment', $comment->comment_post_ID );
								}
							}
							$customer = get_userdata( $id );
							$activity = get_user_meta( $id, '_ua_user_activity', true );
							$new_activity = array('type' => 'register');
							$key = strtotime($customer->user_registered);
							if (empty($activity)){
								$activity = array($key => $new_activity);
							}
							else {
								$activity[$key] = $new_activity;					
							}
							update_user_meta($id, '_ua_user_activity', $activity);
							do_action( 'ua_add_users_activities', $id, $key, 'register', '' );
						}
					}
				}
			}
		}
	}		