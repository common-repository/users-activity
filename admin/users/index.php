<?php if ( ! defined( 'ABSPATH' ) ) exit;
	$tool= (isset($_REQUEST["tool"])) ? sanitize_text_field($_REQUEST["tool"]) : '';		
		if ($tool == ""){
			include_once( 'users-list.php' );
			return;
		}		
		if ($tool == "user"){
			include_once( 'user.php' );
			return;	
		}
		
	?>
