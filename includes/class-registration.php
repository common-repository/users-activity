<?php if ( ! defined( 'ABSPATH' ) ) exit;
	/**
		* Users Registration
		*
		* @package     USERS_ACTIVITY
		* @subpackage  Includes
		* @copyright   Copyright (c) 2017, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       1.0
	*/
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;
	/**
		* UA_Users_Registration Class
		*
		* @since 1.0
	*/
	
	class USERS_ACTIVITY_REGISTRATION{
		public function __construct() {			
			add_action( 'init', array($this, 'new_user_register') );
			add_action( 'ua_send_mail_register', array($this, 'send_mail_register'), 10, 1 );
		}
				
		// Start Registration
		public function new_user_register(){
			if(isset($_POST['ua_register_submit']))
			{
				self::add_new_user_temp();
			}
			elseif(isset($_GET['ua_user_code']))
			{
				self::add_new_user_in_WP();
			}	
		}
		
		// Registration process 
		public function add_new_user_temp() {
			global $wpdb;
			global $ua_error_resister;
			global $ua_output;
			$table_new_user = $wpdb->prefix . "ua_table";
			$option = get_option('ua_options');			
			$user_name = isset($_POST['ua_user_name']) ? sanitize_user($_POST['ua_user_name']) : '';
			$user_email = isset($_POST['ua_user_email']) ? sanitize_email($_POST['ua_user_email']) : '';
			$user_fname = isset($_POST['ua_user_fname']) ? sanitize_text_field($_POST['ua_user_fname']) : '';
			$user_lname = isset($_POST['ua_user_lname']) ? sanitize_text_field($_POST['ua_user_lname']) : '';			
			$errors = array();			
			$vals['user_name'] = $user_name;
			$vals['user_email'] = $user_email;
			if (!empty($option['display_fname'])){
				$vals['user_fname'] = $user_fname;
			}
			if (!empty($option['display_lname'])){
				$vals['user_lname'] = $user_lname;
			}			
			$errors = self::user_data_validation($vals);			
			if ($errors) {	
				$ua_error_resister = $errors;
				add_filter('ua_form_error', array(&$this, 'user_error_print'));
				return ;
			}			
			$random_code = wp_generate_password($length=12, $include_standard_special_chars=false);
			$password = wp_generate_password($length=12, $include_standard_special_chars=false);
			$ctime = time();			
			$wpdb->insert(
			$table_new_user,  
			array('user_name' => $user_name, 'user_fname' => $user_fname, 'user_lname' => $user_lname, 'user_email' => $user_email, 'password' => $password, 'code' => $random_code, 'ctime' => $ctime),
			array('%s', '%s', '%s', '%s', '%s', '%s', '%d')
			);
			$url_authorization = site_url( $_SERVER['REQUEST_URI'] ).'?ua_user_code='.$random_code;
			$from_text = !empty($option['from_text']) ? $option['from_text'] : 'WordPress';
			$from_mail = !empty($option['from_mail']) ? $option['from_mail'] : get_option('admin_email');
			$subject = !empty($option['mail_subject']) ? $option['mail_subject'] : 'Your new account';
			$headers= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= 'From: '.$from_text.' <'.$from_mail.'>' . "\r\n";		
			$message = !empty($option['confirm_email']) ? $option['confirm_email'] : 'Hi, <b>{username}</b>! <p>Welcome to our site! Your new account has been setup..</p> Your username: {username}<br/>Your password: {password}<br/>To activate your account, please follow this link: {url_authorization}';			
			$message = str_replace( '{email}', $user_email, $message );
			$message = str_replace( '{username}', $user_name, $message );
			if(!empty($user_fname))
				$message = str_replace( '{fname}', $user_fname, $message );
			if(!empty($user_lname))
				$message = str_replace( '{lname}', $user_lname, $message );
			$message = str_replace( '{password}', $password, $message );
			$message = str_replace( '{url_authorization}', $url_authorization, $message );						
			wp_mail($user_email, $subject, $message, $headers );	
			$ua_output = $vals;
			add_filter('ua_form_error', array(&$this, 'user_register_print'));			
		}	
		
		// Check fields
		public function user_data_validation($vals)	{				
			$option = get_option('ua_options');			
			$user_name = $vals['user_name'];
			$user_email = $vals['user_email'];
			if (!empty($option['display_fname']))
				$user_fname = $vals['user_fname'];
			if (!empty($option['display_lname']))
				$user_lname = $vals['user_lname'];
			$errors = array();
			if (empty($user_name) || mb_strlen($user_name) > 60) {
				$errors['user_name'] = __('Invalid username','users-activity');
			}
			$exp_name = '/^[0-9a-z\d]*[0-9a-z\d]$/';
			if (!preg_match($exp_name, $user_name) || strlen($user_name) < 4){
				$errors['user_name'] = __( 'Usernames can only contain lowercase letters (a-z) and numbers. The minimum length is 4 characters','users-activity');
			}
			$user_id = username_exists($user_name);
			if($user_id) {
				$errors['user_name'] = __('Username already taken','users-activity');
			}			
			$exp = '/^[0-9a-z][0-9a-z_\-\.%#]*@[0-9a-z][0-9a-z\-\.]{0,63}\.[a-z]{2,}$/i';
			if ( !preg_match($exp, $user_email) || empty($user_email) || mb_strlen($user_email) > 100 ) {
				$errors['user_email'] = __('Invalid email','users-activity');
			}
			if(email_exists($user_email)){
				$errors['user_email'] = __('Email already taken','users-activity');
			}
			if (!empty($option['display_fname']) && empty($user_fname) > 60) {
				$errors['user_fname'] = __('Invalid First Name','users-activity');
			}
			if (!empty($option['display_lname']) && empty($user_lname) > 60) {
				$errors['user_lname'] = __('Invalid Last Name','users-activity');
			}			
			return $errors;
		}	
		
		// Print error message
		public function user_error_print (){
			global $ua_error_resister;
			echo '<div class="ua-alert ua-alert-error ">';
			foreach ($ua_error_resister as $error) {				
				echo '<p class="ua_error"><strong>'.__('Error','users-activity').'</strong>: ' . $error . '</p>';
			}
			echo '</div>';
		}
		
		// Print message after submit registration form
		public function user_register_print (){
			$option = get_option('ua_options');
			global $ua_output;
			$user = $ua_output;
			$message = !empty($option['message']) ? $option['message'] : 'Please check your email {email} for a confirmation link to creation account';		
			$message = str_replace( '{email}', $user['user_email'], $message );
			$message = str_replace( '{username}', $user['user_name'], $message );			
			if (!empty($user['user_fname']))
				$message = str_replace( '{fname}', $user['user_fname'], $message );
			if (!empty($user['user_lname']))
				$message = str_replace( '{lname}', $user['user_lname'], $message );			
			echo $message;	
		}
		
		// Create a new user on site
		public function add_new_user_in_WP()
		{
			global $wpdb;
			global $ua_output;
			$table_new_user = $wpdb->prefix . "ua_table";			
			$emailcode = sanitize_text_field($_GET['ua_user_code']);			
			$email_check = $wpdb->get_row(  
			$wpdb->prepare( "SELECT * FROM $table_new_user WHERE code = %s", $emailcode ) );			
			if($email_check)
			{	
				$vals['user_name'] = $email_check->user_name;
				$vals['user_email'] = $email_check->user_email;
				$vals['user_fname'] = $email_check->user_fname;
				$vals['user_lname'] = $email_check->user_lname;				
				$errors = self::user_data_validation($vals);				
				if($errors) {
					$ua_output = '<div class="ua-alert ua-alert-error "><p>'.__('You have already activated your account. Use the login form.','users-activity').'</p></div>';
				}
				else {	
					$userdata = array(				  
						'user_pass'       => $email_check->password,
						'user_login'      => $email_check->user_name,				
						'user_email'      => $email_check->user_email,				
						'first_name'      => $email_check->user_fname,
						'last_name'       => $email_check->user_lname,	
						'show_admin_bar_front' => 'false',
					);				
					$user_id = wp_insert_user( $userdata );				
					$creds = array();
					$creds['user_login'] = $email_check->user_name;
					$creds['user_password'] = $email_check->password;
					$creds['remember'] = true;
					$user = wp_signon( $creds, false );
					if ( is_wp_error($user) ) {
						echo $user->get_error_message();
					}
					else{					
						update_user_meta ($user_id, '_ua_user_status', 1);					
						self::users_update_table($userdata,$table_new_user);
						$option = get_option('ua_options');					
						if (!empty($option['new_user'])){
							$activity = array(time() => array('type' => 'register', 'params' => ''));
							update_user_meta($user_id, '_ua_user_activity', $activity);		
						}												
						do_action( 'ua_send_mail_register', $vals );
						do_action( 'ua_integration_servises', $vals );						
						if (!empty($option['reg_redirect'])){
							$item_redirect = $option['reg_redirect'];
						}
						else {
							$item_redirect = $_SERVER['REQUEST_URI'];
						}						
						wp_redirect ($item_redirect);
						exit;
					}
				}
			}
			else
			{
				$ua_output = '<div class="ua-alert ua-alert-error "><p>'.__('The verification code does NOT match!','users-activity').'</p></div>';
			}
			
			add_filter('the_content', array(&$this, 'content_filter') );
		}
		
		// Print error for user code
		public function content_filter($content)
		{
			global $ua_output;			
			return $ua_output.$content;
		}		
		
		// Delete user from ua table
		public function users_update_table($userdata, $table){
			global $wpdb;	
			$time = time()- 86400;
			$wpdb->query( $wpdb->prepare( "DELETE FROM $table WHERE ctime < %d",$time ));		
		}
		
		// Send email to user and admin after New User registration
		public function send_mail_register($vals){
			$option = get_option('ua_options');			
			if(empty($option['reg_mail_disable'])){
				$from_text = !empty($option['from_text']) ? $option['from_text'] : 'WordPress.org';
				$from_mail = !empty($option['from_mail']) ? $option['from_mail'] : get_option('admin_email');
				$subject = !empty($option['reg_mail_subject']) ? $option['reg_mail_subject'] : 'Notice of Activate Account';
				$headers= "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				$headers .= 'From: '.$from_text.' <'.$from_mail.'>' . "\r\n";		
				$message = !empty($option['reg_success_email']) ? $option['reg_success_email'] : 'Hi, <b>{username}</b>! <p>This notice confirms that your account was created successfully.</p> This email has been sent to {email}';				
				$message = str_replace( '{email}', $vals['user_email'], $message );
				$message = str_replace( '{username}', $vals['user_name'], $message );
				if(!empty($vals['user_fname']))
					$message = str_replace( '{fname}', $vals['user_fname'], $message );
				if(!empty($vals['user_lname']))
					$message = str_replace( '{lname}', $vals['user_lname'], $message );						
				wp_mail($vals['user_email'], $subject, $message, $headers );	
			}
			
			if(empty($option['admin_mail_disable'])){
				$from_text = !empty($option['from_text']) ? $option['from_text'] : 'WordPress.org';
				$from_mail = !empty($option['from_mail']) ? $option['from_mail'] : get_option('admin_email');	
				$subject = !empty($option['admin_mail_subject']) ? $option['admin_mail_subject'] : 'New User Registration';
				$headers= "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				$headers .= 'From: '.$from_text.' <'.$from_mail.'>' . "\r\n";		
				$message = !empty($option['admin_email']) ? $option['admin_email'] : '<p>New user registration on your site</p><p>Username: {username}</p><p>Email: {email}</p>';				
				$message = str_replace( '{email}', $vals['user_email'], $message );
				$message = str_replace( '{username}', $vals['user_name'], $message );
				if(!empty($vals['user_fname']))
					$message = str_replace( '{fname}', $vals['user_fname'], $message );
				if(!empty($vals['user_lname']))
					$message = str_replace( '{lname}', $vals['user_lname'], $message );				
				wp_mail($from_mail, $subject, $message, $headers );	
			}
			
		}
		
	}							