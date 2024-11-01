<?php
	/**
		* Activity Class
		*
		* @package     USERS_ACTIVITY		
		* @copyright   Copyright (c) 2017, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       1.0
	*/
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;
	class USERS_ACTIVITY_CLASS{ 
		public function __construct() {			
			add_action( 'wp_login_failed', array( $this, 'front_end_login_fail' ) );
			add_action( 'login_form_lostpassword', array( $this, 'do_password_lost' ) );			
			add_action( 'comment_post', array( $this, 'user_add_comment'), 10, 3 );
			add_action( 'ua_add_user_activity', array( $this, 'add_user_activity' ), 10, 2 );
			add_action( 'ua_add_users_activities', array( $this, 'add_users_activities' ), 10, 4 );			
		}
		// Login failed
		public function front_end_login_fail() {
			$referrer = $_SERVER['HTTP_REFERER']; 		
			if( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
				wp_redirect( add_query_arg('ua_login', 'failed', $referrer ) );
				exit;
			}
		}
		
		// Lost Password
		public function do_password_lost() {
			$referrer = $_SERVER['HTTP_REFERER'];
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
				$errors = retrieve_password();
				if ( is_wp_error( $errors ) ) {
					// Errors found
					$redirect_url = $referrer;
					$redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
					} else {
					// Email sent
					$redirect_url = $referrer;
					$redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
				}
				wp_redirect( $redirect_url );
				exit;
			}
		}
		
		// Add comments
		public function user_add_comment( $comment_ID, $comment_approved, $commentdata ) {
			$current_user = wp_get_current_user();				
			if ($current_user->ID == $commentdata['user_id']) {
				$option = get_option('ua_options');
				if (!empty($option['add_comment']))
				do_action( 'ua_add_user_activity', 'comment', $commentdata['comment_post_ID'] );
			}
		}
		
		// Update user activity
		public function add_user_activity ($type, $param){								
			$user_id = get_current_user_id();
			$activity = get_user_meta( $user_id, '_ua_user_activity', true );				
			$new_activity = array('type' => $type, 'params' => $param);
			$key = time();
			if (empty($activity)){
				$activity = array($key => $new_activity);
			}
			else {
				$activity[$key] = $new_activity;
			}				
			update_user_meta($user_id, '_ua_user_activity', $activity);	
			self::add_users_activities ($user_id,$key,$type,$param);
		}
		
		// Update General Activity
		public function add_users_activities ($user_id,$key,$type,$param){
			$activities = get_option( '_ua_users_activities' );
			$user_info = get_userdata($user_id);
			$new_activities = array('user_id' => $user_id, 'user_name' => $user_info->user_login, 'type' => $type, 'params' => $param);
			if($activities === false) {
				$activities = array($key => $new_activities);
			}
			else {				
				$activities[$key] = $new_activities;
			}
			krsort($activities);
			$count = count($activities);
			if ($count > 500){				
				$activities = array_slice($activities, 0, 500, true);				
			}
			update_option( '_ua_users_activities', $activities);
		}
	}			