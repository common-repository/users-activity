<?php
	/**
		* Admin Pages
		*
		* @package     USERS_ACTIVITY
		* @subpackage  Admin
		* @copyright   Copyright (c) 2017, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       1.0
	*/
	
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	class USERS_ACTIVITY_ADMIN{
		public function __construct() {			
			add_action( 'admin_menu', array($this, 'add_menu') );				
			add_filter( 'admin_footer_text', array($this, 'admin_footer_text') );
			add_action( 'admin_enqueue_scripts', array($this, 'style_script') );
			add_action( 'admin_init', array($this, 'update_option') );
			add_action( 'admin_notices', array($this, 'admin_messages') );			
		}
		
		// Add admin pages
		public function add_menu() {
			$icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgNTE1LjkxIDcyOC41IiBoZWlnaHQ9IjUxMiIgaWQ9IkxheWVyXzEiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDUxMi4wMDAwMyA1MTIiIHdpZHRoPSI1MTIiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6Y2M9Imh0dHA6Ly9jcmVhdGl2ZWNvbW1vbnMub3JnL25zIyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczppbmtzY2FwZT0iaHR0cDovL3d3dy5pbmtzY2FwZS5vcmcvbmFtZXNwYWNlcy9pbmtzY2FwZSIgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIiB4bWxuczpzb2RpcG9kaT0iaHR0cDovL3NvZGlwb2RpLnNvdXJjZWZvcmdlLm5ldC9EVEQvc29kaXBvZGktMC5kdGQiIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxkZWZzIGlkPSJkZWZzNyIvPjxnIGlkPSJnOTcwNCIgdHJhbnNmb3JtPSJtYXRyaXgoMS4wMDAwMTQxLDAsMCwxLjAwMDAxNDEsLTg3NDkuMTkyOCwtNzg0MC41NTE3KSI+PHBhdGggZD0ibSA4OTQ2LjU2MjUsODMzMC4zNzUgYyAtODEuNjQ3LDAgLTgwLjY1NjMsNzEuMjgxMiAtODAuNjU2Myw3MS4yODEyIGwgLTAuNSwzNy44NzUgYyAtNi42NzEsLTAuMDg5IC04LjI4MTIsNi41MDc0IC04LjI4MTIsMTkuNjg3NiAwLDE5Ljc1NTYgMTIuMDgwMiw0MC40NDY1IDIzLjAzMTIsNTEuMTI1IDMuNzEyLDE1LjUzMDkgMTAuODAyOCwyOS4yMDA2IDIwLjM0MzgsMzkuNjI1IC0wLjMzMywwLjIwNDcgLTAuNjk4MiwwLjM5MDEgLTEuMDMxMiwwLjU5MzcgLTMyLjUzOTEsMTkuODQ4NyAtNzEuMzEyMywzMy4zMDY5IC05Ni42NTYzLDQ2Ljc1IC02Ljk4OCwzLjcwNDEgLTE0LjQ2MSwxMC4xOTY1IC0yMC41LDE4LjQ2ODcgLTQuMTEzLDUuNjkwNSAtNy42NzEsMTEuNzc2NyAtMTAuNzUsMTguMDkzOCAtMC4xMTIsMC4yMjM4IC0wLjIzMjgsMC40MzIgLTAuMzQzNywwLjY1NjIgLTAuNDIxMSwwLjg3NjggLTAuODQ3LDEuNzcxNSAtMS4yNSwyLjY1NjMgLTYuMTIxLDEzLjEwMDcgLTEwLjIzLDI3LjA5NDMgLTEyLjYyNSw0MS4xMjUgLTAuMDUsMC4yNjA3IC0wLjEwOTMsMC41MjEyIC0wLjE1NjMsMC43ODEzIC0wLjExLDAuNjU4OSAtMC4yNDI4LDEuMzQxMyAtMC4zNDM3LDIgLTAuNDI5MSwyLjQzIC0wLjg0MjYsNC44MzA4IC0xLjE4NzYsNy4yMTg3IC0wLjI5MzksMS45NjcgLTAuNjgwMiw2LjE2ODkgLTAuNTMxMiw4LjIxODcgLTAuMDIsMC4xMjQgLTAuMDIxLDAuMjUwNCAtMC4wMzEsMC4zNzUgLTAuOTAzMSwxMi44MDUzIDIzLjE1NjIsMTYuOTY4OCAyMy4xNTYyLDE2Ljk2ODggOC45OTcsMi42NjA4IDI1LjUyMDcsNS42MTYyIDQ1LjU5MzgsOC4zMTI1IDM1LjgwODksNS45MTAxIDcyLjQ3ODksNy44OTM3IDEwOC41LDkgMy40OTU5LDAuMTA4MiA3LjE2NTcsMC4xNzQ1IDEwLjk2ODcsMC4xODc1IGwgMC43MTg3LDAgYyAxLjg5MzEsMCAzLjgyNDMsMC4wMTcgNS43ODEzLDAgMy44MDQsLTAuMDE2IDcuNDcyOCwtMC4wODEgMTAuOTY4NywtMC4xODc1IDI0LjMzODcsLTAuNzQ3NSA0OC45Njg2LC0xLjkxMTYgNzMuNDM3NiwtNC40MDYzIC0wLjg2NzMsLTQyLjQ5NDUgMC4yMTgzLC04NS4xMjE0IC0wLjA2MywtMTI3LjYyNSAwLjQxOTEsLTkuMjEzOSAtMC4wNDgsLTE4LjQ0MzQgLTAuMjE4NywtMjcuNjU2MiAtMTMuNjAxMiwtNi4yNDExIC0yNy40MTY1LC0xMy4wODk4IC00MC4yODEzLC0yMC45Mzc1IC0wLjMzNCwtMC4yMDM2IC0wLjY5ODIsLTAuMzg5IC0xLjAzMTIsLTAuNTkzNyA5LjU0MiwtMTAuNDI0NCAxNi42MzI4LC0yNC4wOTQxIDIwLjM0MzgsLTM5LjYyNSAxMC45NTA5LC0xMC42Nzg0IDIzLjAzMTIsLTMxLjM2OTQgMjMuMDMxMiwtNTEuMTI1IDAsLTEzLjE4MDIgLTEuNjQyNSwtMTkuNzc3NCAtOC4zMTI1LC0xOS42ODc2IGwgLTAuNDY4NywtMzcuODc1IGMgMCwwIDAuOTkwNywtNzEuMjgxMiAtODAuNjU2MywtNzEuMjgxMiB6IiBpZD0icGF0aDkyMjkiIHN0eWxlPSJmaWxsOiMzMzMzMzM7ZmlsbC1vcGFjaXR5OjE7c3Ryb2tlOm5vbmUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsLTQ0OCkiLz48cGF0aCBkPSJtIDkyMTcuMzQzOCw4NTI4LjUgYyAtMS45MjY4LDEwZS01IC0zLjY4NzMsMS43NjA3IC0zLjY4NzYsMy42ODc1IGwgMCwyMjIuNjI1IGMgM2UtNCwxLjkyNjggMS43NjA3LDMuNjg3MyAzLjY4NzYsMy42ODc1IGwgMzQuMDMxMiwwIGMgMS45MjY4LC0yZS00IDMuNjg3MywtMS43NjA3IDMuNjg3NSwtMy42ODc1IGwgMCwtMjIyLjYyNSBjIC0yZS00LC0xLjkyNjggLTEuNzYwNywtMy42ODc0IC0zLjY4NzUsLTMuNjg3NSB6IG0gLTExMC40MDYzLDQ2IGMgLTEuOTI2OCwxMGUtNSAtMy42NTYsMS43NjA3IC0zLjY1NjMsMy42ODc1IGwgMCwxNzYuNjI1IGMgM2UtNCwxLjkyNjggMS43Mjk1LDMuNjg3MyAzLjY1NjMsMy42ODc1IGwgMzQuMDYyNSwwIGMgMS45MjY4LC0yZS00IDMuNjU2LC0xLjc2MDcgMy42NTYyLC0zLjY4NzUgbCAwLC0xNzYuNjI1IGMgLTJlLTQsLTEuOTI2OCAtMS43Mjk0LC0zLjY4NzQgLTMuNjU2MiwtMy42ODc1IHogbSAtNTUuMTg3NSwtMjIuOTEwOCBjIC0xLjkyNjgsMTBlLTUgLTMuNjg3MywxLjc2MDcgLTMuNjg3NSwzLjY4NzUgbCAwLDE5OS41MzU4IGMgMmUtNCwxLjkyNjggMS43NjA3LDMuNjg3MyAzLjY4NzUsMy42ODc1IGwgMzQuMDMxMiwwIGMgMS45MjY4LC0yZS00IDMuNjg3MywtMS43NjA3IDMuNjg3NiwtMy42ODc1IGwgMCwtMTk5LjUzNTggYyAtM2UtNCwtMS45MjY4IC0xLjc2MDcsLTMuNjg3NCAtMy42ODc2LC0zLjY4NzUgeiBtIDExMC40MDYyLDkxLjkxMDggYyAtMS45MjY3LDJlLTQgLTMuNjg3MiwxLjc2MDcgLTMuNjg3NCwzLjY4NzUgbCAwLDEwNy42MjUgYyAyZS00LDEuOTI2OCAxLjc2MDYsMy42ODczIDMuNjg3NCwzLjY4NzUgbCAzNC4wMzEzLDAgYyAxLjkyNjgsLTJlLTQgMy42ODczLC0xLjc2MDcgMy42ODc1LC0zLjY4NzUgbCAwLC0xMDcuNjI1IGMgLTJlLTQsLTEuOTI2OCAtMS43NjA3LC0zLjY4NzMgLTMuNjg3NSwtMy42ODc1IHoiIGlkPSJwYXRoNDk0NC04IiBzdHlsZT0iZm9udC1zaXplOm1lZGl1bTtmb250LXN0eWxlOm5vcm1hbDtmb250LXZhcmlhbnQ6bm9ybWFsO2ZvbnQtd2VpZ2h0Om5vcm1hbDtmb250LXN0cmV0Y2g6bm9ybWFsO3RleHQtaW5kZW50OjA7dGV4dC1hbGlnbjpzdGFydDt0ZXh0LWRlY29yYXRpb246bm9uZTtsaW5lLWhlaWdodDpub3JtYWw7bGV0dGVyLXNwYWNpbmc6bm9ybWFsO3dvcmQtc3BhY2luZzpub3JtYWw7dGV4dC10cmFuc2Zvcm06bm9uZTtkaXJlY3Rpb246bHRyO2Jsb2NrLXByb2dyZXNzaW9uOnRiO3dyaXRpbmctbW9kZTpsci10Yjt0ZXh0LWFuY2hvcjpzdGFydDtiYXNlbGluZS1zaGlmdDpiYXNlbGluZTtjb2xvcjojMDAwMDAwO2ZpbGw6IzAwYTFmMTtmaWxsLW9wYWNpdHk6MTtmaWxsLXJ1bGU6bm9uemVybztzdHJva2U6bm9uZTtzdHJva2Utd2lkdGg6MTY7bWFya2VyOm5vbmU7dmlzaWJpbGl0eTp2aXNpYmxlO2Rpc3BsYXk6aW5saW5lO292ZXJmbG93OnZpc2libGU7ZW5hYmxlLWJhY2tncm91bmQ6YWNjdW11bGF0ZTtmb250LWZhbWlseTpTYW5zOy1pbmtzY2FwZS1mb250LXNwZWNpZmljYXRpb246U2FucyIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCwtNDQ4KSIvPjwvZz48L3N2Zz4=';
			add_menu_page('Users Activity', 'Users Activity', 'manage_options', 'users-activity', array($this, 'main_page'), $icon);
			add_submenu_page('users-activity', 'Users', 'Users', 'manage_options', 'users-activity');
			add_submenu_page('users-activity', 'Users Activity Settings', 'Settings', 'manage_options', 'ua-settings', array($this, 'settings_page'));
			add_submenu_page('users-activity', 'Get more', 'Get more', 'manage_options', 'ua-get-more', array($this, 'get_more'));			
		}
		
		// Admin style
		public function style_script() {
			wp_enqueue_style( 'users-activity', USERS_ACTIVITY_PLUGIN_URL . 'asset/css/admin.css', array(), USERS_ACTIVITY_VERSION);							
		}		
		
		//Users page
		public function main_page() {
			global $ua_type;	
			$ua_type = true;			
			include_once( 'users/index.php' );	
			wp_enqueue_script( 'users-activity', USERS_ACTIVITY_PLUGIN_URL . 'asset/js/admin.js', array('jquery'), USERS_ACTIVITY_VERSION);
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
		}		
		
		//Settings page
		public function settings_page() {
			global $ua_type;	
			$ua_type = true;			
			include_once( 'settings/index.php' );
			wp_enqueue_script( 'users-activity', USERS_ACTIVITY_PLUGIN_URL . 'asset/js/admin.js', array('jquery'), USERS_ACTIVITY_VERSION);
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
		}		
				
		public function get_more() {
			global $ua_type;	
			$ua_type = true;			
			include_once( 'more/index.php' );
			wp_enqueue_style( 'ua-wow-style', USERS_ACTIVITY_PLUGIN_URL . 'asset/css/wow-style.css', array(), USERS_ACTIVITY_VERSION);
		}		
				
		public function ua_settings_get_tabs() {	
			global $ua_extensions;
			
			$tabs             = array();
			$tabs['general']  = __( 'General', 'users-activity' );			
			$tabs['emails']   = __( 'Emails', 'users-activity' );
			
			
			if( ! empty( $ua_extensions ) ) {
				$tabs['extensions'] = __( 'Extensions', 'users-activity' );
			}
			
			
			return apply_filters( 'ua_settings_tabs', $tabs );
		}
		
		function ua_get_settings_tab_sections( $tab = false ) {
			
			$tabs     = false;
			$sections = self::ua_get_registered_settings_sections();
			
			if( $tab && ! empty( $sections[ $tab ] ) ) {
				$tabs = $sections[ $tab ];
				} else if ( $tab ) {
				$tabs = false;
			}
			
			return $tabs;
		}
		
		function ua_get_registered_settings_sections() {
			
			static $sections = false;
			
			if ( false !== $sections ) {
				return $sections;
			}
			
			$sections = array(
				'general'    => apply_filters( 'ua_settings_sections_general', array(
					'main'               => __( 'General Settings', 'users-activity' ),
					'registration'       => __( 'Registration', 'users-activity' ),					
					) 
				),				
				'emails'     => apply_filters( 'ua_settings_sections_emails', array(
					'main'               => __( 'Email Settings', 'users-activity' ),
					'registration'       => __( 'Registration Email', 'users-activity' ),
					'notification'       => __( 'New User Notifications', 'users-activity' ),
					) 
				),			
				'extensions' => apply_filters( 'ua_settings_sections_extensions', array(					
					) 
				),
			
			);
			
			$sections = apply_filters( 'ua_settings_sections', $sections );
			
			return $sections;
		}
		
		
		
		// Update an option
		public function update_option(){			
			if ( !empty($_POST['ua_nonce_field']) && wp_verify_nonce($_POST['ua_nonce_field'],'update_ua_options') ){
				$new_option = wp_unslash($_POST['ua_options']);				
				$options = get_option( 'ua_options' );
				if (empty($options)){
					$result = $new_option;
				}
				else {					
					$result = array_merge($options, $new_option);					
				}				
				update_option( 'ua_options', $result );				
				$reffer = $_POST['_wp_http_referer'];
				$url = add_query_arg( array('ua-message' => 'update'), $reffer );
				wp_redirect($url);
				exit;					
			}			
		}
		
		// Admin Messages
		public function admin_messages(){			
			if ( isset( $_GET['ua-message'] ) && 'update' == $_GET['ua-message']) {				
				add_settings_error( 'ua-notices', 'ua-option-update', __( 'Settings updated.', 'users-activity' ), 'updated' );
			}
			if ( isset( $_GET['ua-message'] ) && 'user-activity' == $_GET['ua-message']) {				
				add_settings_error( 'ua-notices', 'ua-user-activity', __( 'No yet activity for user. Please, import activity for user.', 'users-activity' ), 'error' );
			}
			settings_errors( 'ua-notices' );
		}
		
		// Footer message
		public function admin_footer_text( $footer_text ) {
			global $ua_type;			
			if ( $ua_type == true ) {
				$rate_text = sprintf( __( 'Thank you for using <a href="%1$s" target="_blank">Users Activity</a>! Please <a href="%2$s" target="_blank">rate us</a> on <a href="%2$s" target="_blank">WordPress.org</a>', 'users-activity' ),
				'https://wordpress.org/support/view/plugin-reviews/users-activity',
				'https://wordpress.org/support/view/plugin-reviews/users-activity?filter=5#postform'
				);				
				return str_replace( '</span>', '', $footer_text ) . ' | ' . $rate_text . '</span>';
				} else {
				return $footer_text;
			}
		}
	}									