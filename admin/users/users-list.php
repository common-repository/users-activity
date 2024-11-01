<?php if ( ! defined( 'ABSPATH' ) ) exit;
	include( dirname( __FILE__ ) . '/class-users-table.php' );	
	$customers_table = new USERS_ACTIVITY_USERS_TABLE();
	$customers_table->prepare_items();
?>	 
<div class="wrap">
	<h2><?php _e( 'Users', 'users-activity' ); ?></h2>
	<form method="post">
		<input type="submit" class="button" name="ua-csv-file" value="Export all users in CSV">
		<?php wp_nonce_field('ua_export_all_action','ua_export_all_field'); ?>
	</form>	
	<form method="post" class="ua-usaers-table">		
		<?php			
			$customers_table->search_box( __( 'Search User', 'users-activity' ), 'users-activity' );
			$customers_table->display();
		?>		
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />	
		<?php wp_nonce_field('ua_export_action','ua_export_field'); ?>
	</form>
</div>
