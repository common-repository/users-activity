<?php
	/**
		* Plugin Name:       Users Activity 
		* Plugin URI:        https://wordpress.org/plugins/users-activity
		* Description:       Pay more attention to your users
		* Version:           1.0
		* Author:            Dmytro Lobov		
		* License:           GPL-2.0+
		* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt		
		* Text Domain:       users-activity
		* Domain Path:       languages
		*
		* Users Activity is free software: you can redistribute it and/or modify
		* it under the terms of the GNU General Public License as published by
		* the Free Software Foundation, either version 2 of the License, or
		* any later version.
		*
		* Users Activity is distributed in the hope that it will be useful,
		* but WITHOUT ANY WARRANTY; without even the implied warranty of
		* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
		* GNU General Public License for more details.
		*
		* You should have received a copy of the GNU General Public License
		* along with Easy Digital Downloads. If not, see <http://www.gnu.org/licenses/>.
		*
	*/	
	
	// Exit if accessed directly.
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	if ( ! class_exists( 'Users_Activity' ) ) :
	
	/**
		* Main Users_Activity Class.
		*
		* @since 1.0
	*/
	final class Users_Activity {
		/** Singleton *************************************************************/
		
		/**
			* @var Users_Activity The one true Users_Activity
			* @since 1.4
		*/
		private static $instance;
		
		/**
			* Main Users_Activity Instance.
			*
			* Insures that only one instance of Users_Activity exists in memory at any one
			* time. Also prevents needing to define globals all over the place.
			*
			* @since 1.0
			* @static
			* @staticvar array $instance
			* @uses Users_Activity::setup_constants() Setup the constants needed.
			* @uses Users_Activity::includes() Include the required files.
			* @uses Users_Activity::load_textdomain() load the language files.
			* @see UsA()
			* @return object|Users_Activity The one true Users_Activity
		*/
		
		public static function instance() {
			
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Users_Activity ) ) {
				self::$instance = new Users_Activity;
				self::$instance->setup_constants();				
				
				register_activation_hook( __FILE__, array(self::$instance, 'install' ) );
				
				add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );	
				
				
				self::$instance->includes();
				self::$instance->admin      = new USERS_ACTIVITY_ADMIN();
				self::$instance->users      = new USERS_ACTIVITY_USERS();
				self::$instance->activity   = new USERS_ACTIVITY_CLASS();
				self::$instance->shortcodes = new USERS_ACTIVITY_SHORTCODES();
				self::$instance->links      = new USERS_ACTIVITY_MENU_PAGE();
				self::$instance->registr    = new USERS_ACTIVITY_REGISTRATION();				
			}
			return self::$instance;
		}
		
		/**
			* Throw error on object clone.
			*
			* The whole idea of the singleton design pattern is that there is a single
			* object therefore, we don't want the object to be cloned.
			*
			* @since 1.0
			* @access protected
			* @return void
		*/
		
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'users-activity' ), '1.0' );
		}
		
		/**
			* Disable unserializing of the class.
			*
			* @since 1.0
			* @access protected
			* @return void
		*/
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'users-activity' ), '1.0' );
		}
		
		private function setup_constants() {
		
			// Plugin version.
			if ( ! defined( 'USERS_ACTIVITY_NAME' ) ) {
				define( 'USERS_ACTIVITY_NAME', 'Users Activity' );
			}
			
			// Plugin version.
			if ( ! defined( 'USERS_ACTIVITY_VERSION' ) ) {
				define( 'USERS_ACTIVITY_VERSION', '1.0' );
			}
			
			// Plugin Folder Path.
			if ( ! defined( 'USERS_ACTIVITY_PLUGIN_DIR' ) ) {
				define( 'USERS_ACTIVITY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}
			
			// Plugin Folder URL.
			if ( ! defined( 'USERS_ACTIVITY_PLUGIN_URL' ) ) {
				define( 'USERS_ACTIVITY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}
			
			// Plugin Root File.
			if ( ! defined( 'USERS_ACTIVITY_PLUGIN_FILE' ) ) {
				define( 'USERS_ACTIVITY_PLUGIN_FILE', __FILE__ );
			}			
		}
		
		/**
			* Include required files.
			*
			* @access private
			* @since 1.0
			* @return void
		*/
		
		private function includes() {			
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'admin/admin.php';			
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'includes/class-users.php';
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'includes/class-activity.php';
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'includes/class-shortcodes.php';
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'includes/class-menu.php';
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'includes/class-registration.php';			
		}	
		
		/**
			* Install
			*
			* @since 1.0
			* @global $wpdb
			* @return void
		*/
		
		public function install() {
			require_once USERS_ACTIVITY_PLUGIN_DIR . 'includes/install.php';	
		}
		
		/**
			* Loads the plugin language files.
			*
			* @access public
			* @since 1.0
			* @return void
		*/
		public function load_textdomain() {
			$ua_lang_dir  = dirname( plugin_basename( USERS_ACTIVITY_PLUGIN_FILE ) ) . '/languages/';
			// Load the default language files.
			load_plugin_textdomain( 'users-activity', false, $ua_lang_dir );
		}	
		
	}
	endif; // End if class_exists check.
	
	/**
		* The main function for that returns Users_Activity
		*
		* The main function responsible for returning the one true Users_Activity
		* Instance to functions everywhere.
		*
		* Use this function like you would a global variable, except without needing
		* to declare the global.
		*
		* Example: <?php $ua = Users_Activity(); ?>
		*
		* @since 1.0
		* @return object|Users_Activity The one true Users_Activity Instance.
	*/
	function Users_Activity() {
		return Users_Activity::instance();
	}
	
	// Get UA Running.
	Users_Activity();