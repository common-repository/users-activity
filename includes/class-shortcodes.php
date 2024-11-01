<?php
	/**
		* Shortcodes
		*
		* @package     USERS_ACTIVITY
		* @subpackage  Shortcodes
		* @copyright   Copyright (c) 2017, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       1.0
	*/
	
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	class USERS_ACTIVITY_SHORTCODES { 
		public function __construct() {			
			add_action( 'wp_enqueue_scripts', array($this, 'plugin_scripts') );
			add_shortcode('ua_register', array($this, 'shortcode_registration') );
			add_shortcode('ua_login', array($this, 'shortcode_login') );
			add_shortcode('ua_lost_password', array($this, 'shortcode_lost_password') );
			add_shortcode('ua_profile', array($this, 'shortcode_profile') );
			add_shortcode('ua_comments', array($this, 'shortcode_comments') );
			add_shortcode('ua_posts', array($this, 'shortcode_posts') );
			add_shortcode('ua_add_posts', array($this, 'shortcode_add_posts') );
			add_shortcode('ua_user_activity', array($this, 'shortcode_user_activity') );
			add_shortcode('ua_users_activities', array($this, 'shortcode_users_activities') );
			add_shortcode('ua_restrict', array($this, 'shortcode_restrict') );
		}	
		
		// General plugin styles & scripts
		public function plugin_scripts(){				
			wp_enqueue_style( 'dashicons' );
			wp_enqueue_style( 'users-activity', USERS_ACTIVITY_PLUGIN_URL . 'asset/css/style.css', array(), USERS_ACTIVITY_VERSION );
		}
		// Registration Shortcode		
		public function shortcode_registration($atts) { 
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-register.php';				
			$form = ob_get_contents();
			ob_end_clean();					
			return $form;
		}
		
		// LogIn Shortcode
		public function shortcode_login($atts) { 
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-login.php';				
			$form = ob_get_contents();
			ob_end_clean();
			return $form;
		}
		// LostPassword Shortcode
		public function shortcode_lost_password($atts) { 
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-lostpassword.php';				
			$form = ob_get_contents();
			ob_end_clean();
			return $form;
		}
		// Profile Shortcode
		public function shortcode_profile (){
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-profile.php';				
			$form = ob_get_contents();
			ob_end_clean();
			return $form;			
		}
		// Comments Shortcode
		public function shortcode_comments (){
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-comments.php';				
			$form = ob_get_contents();
			ob_end_clean();
			return $form;			
		}
		// Posts Shortcode
		public function shortcode_posts (){
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-posts.php';				
			$form = ob_get_contents();
			ob_end_clean();
			return $form;			
		}
		// Add Posts Shortcode
		public function shortcode_add_posts (){
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-add-posts.php';				
			$form = ob_get_contents();
			ob_end_clean();		
			return $form;	
			
		}
		// Activity User Shortcode
		public function shortcode_user_activity (){
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-user-activity.php';				
			$form = ob_get_contents();
			ob_end_clean();
			return $form;			
		}
		// Activities of All Users Shortcode
		public function shortcode_users_activities ($atts){
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-users-activities.php';				
			$form = ob_get_contents();
			ob_end_clean();
			return $form;			
		}
		
		// Restrict content
		public function shortcode_restrict ($atts, $content){
			ob_start();
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'templates/shortcode-restrict.php';				
			$form = ob_get_contents();
			ob_end_clean();
			return $form;			
		}	
		
	}
	
