<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	if (is_user_logged_in()){
		echo $content;		
	}
	else {
		echo '<div class="ua-alert ua-alert-error "><p class="ua_error">'.__( 'You must be logged in to view this content', 'users-activity' ).'</p></div>';
	}
	