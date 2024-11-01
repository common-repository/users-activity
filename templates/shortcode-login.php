<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	if ( !is_user_logged_in() ) {
		$option = get_option('ua_options');			
		$url = !empty($option['login_redirect']) ? $option['login_redirect'] : site_url( $_SERVER['REQUEST_URI'] );
		$args = array(
		'echo'           => true,
		'redirect'       => $url, 
		'form_id'        => 'ualoginform',
		'label_username' => __( 'Username' ),
		'label_password' => __( 'Password' ),
		'label_remember' => __( 'Remember Me' ),
		'label_log_in'   => __( 'Log In' ),
		'id_username'    => 'user_login',
		'id_password'    => 'user_pass',
		'id_remember'    => 'rememberme',
		'id_submit'      => 'wp-submit',
		'remember'       => true,
		'value_username' => NULL,
		'value_remember' => true 
		);
		if (isset($_GET['ua_login'])){
			echo '<div class="ua-alert ua-alert-error "><p class="ua_error"><strong>'.__( 'ERROR', 'users-activity' ).'</strong>:'.__( 'Password or username you entered is incorrect', 'users-activity' ).'</p></div>';
		}
		wp_login_form( $args );	
	}	
?>
