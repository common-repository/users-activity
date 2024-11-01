<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">
	<h2><?php _e( 'Settings', 'users-activity' ); ?></h2>	
	<?php		
		$current = (isset($_GET['tab'])) ? sanitize_text_field($_GET['tab']) : 'general';	
		$tabs = self::ua_settings_get_tabs(); 				
		echo '<h2 class="nav-tab-wrapper">';
		foreach( $tabs as $tab => $name ){
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=ua-settings&tab=$tab'>$name</a>";		
		}
		echo '</h2>';	
		
		$sub_menu      = self::ua_get_settings_tab_sections( $current );
		
		
		
		if ($sub_menu){
			$current_sub = (isset($_GET['sudmenu'])) ? sanitize_text_field($_GET['sudmenu']) : 'main';
			$count_sub = count($sub_menu);			
			echo '<div><ul class="subsubsub">';
			$number = 0;
			foreach( $sub_menu as $sub_key => $sub_name ){
				echo '<li>';
				if ($number == 0) {
					$first_sub = $sub_key;
				}				 
				$number++;
				$tab_url = add_query_arg( array(					
					'tab' => $current,
					'sudmenu' => $sub_key,
					) 
				);
				$class = '';
				if ( $sub_key == $current_sub ) {
					$class = 'current';
				}
				echo '<a class="' . $class . '" href="' . esc_url( $tab_url ) . '">' . $sub_name . '</a>';				
				if ( $number != $count_sub ) {
					echo ' | ';
				}				
				echo '</li>';
			}
			echo '</ul></div>';		
		}
	?>
	
	<div id="poststuff">
		<form method="post" name="ua_options" action="" id="ua_options">
			<?php wp_nonce_field('update_ua_options','ua_nonce_field'); 
				$option = get_option('ua_options');				
				echo '<table class="form-table">';	
				if ($current === 'extensions') {
					$section = (isset($_GET['sudmenu'])) ? sanitize_text_field($_GET['sudmenu']) : $first_sub;
					if(!empty($section))
						do_action( 'ua_extensions_options_'.$section, $option );
				}
				else {
					include_once ($current.'/'.$current_sub.'.php');		
				}
				echo '</table>';
			?>
			<?php submit_button(); ?>					
		</form>	
	</div>	
</div>