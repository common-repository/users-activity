<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">
	<h2><?php _e( 'Settings', 'users-activity' ); ?></h2>	
	<?php		
		$current = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'support';	
		$tabs = array('support' => 'Support', 'plugins' => 'Good Experience'); 				
		echo '<h2 class="nav-tab-wrapper">';
		foreach( $tabs as $tab => $name ){
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=ua-get-more&tab=$tab'>$name</a>";		
		}
		echo '</h2>';			
		
	?>
	
	<div id="poststuff">		
			<?php								
				include_once ($current.'.php');					
			?>			
	</div>	
</div>