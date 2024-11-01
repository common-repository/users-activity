<?php if ( ! defined( 'ABSPATH' ) ) exit;
	
	class USERS_ACTIVITY_MENU_PAGE {		
		public $db_id = 0;
		public $object = 'ualog';
		public $object_id;
		public $menu_item_parent = 0;
		public $type = 'custom';
		public $title;
		public $url;
		public $target = '';
		public $attr_title = '';
		public $classes = array();
		public $xfn = '';
		
		function __construct() {
			add_action( 'admin_head-nav-menus.php', array($this, 'add_nav_menu_metabox' ) );			
			add_filter( 'wp_setup_nav_menu_item', array($this, 'setup_nav_menu_item' ) );
			if( !is_admin() ){
				add_filter( 'wp_get_nav_menu_items', array( $this, 'exclude_menu_items' ), 20 );
			}
		}
		
		/* Add a metabox in admin menu page */
		public function add_nav_menu_metabox (){
			add_meta_box( 'ua_menu', __( 'UA links' ), array( $this, 'ua_nav_menu_metabox' ), 'nav-menus', 'side', 'default' );
		}		
		/* The metabox code : Awesome code stolen from screenfeed.fr (GregLone) Thank you mate. */
		public function ua_nav_menu_metabox( $object ) {
			global $nav_menu_selected_id;			
			$elems = array(	 
			'#ua_logout#'        => __( 'Log Out' ),
			'#ua_register#'      => __( 'Sign Up' ),
			'#ua_login#'         => __( 'Sign In' ),
			'#ua_lost_password#' => __( 'Lost Password' ), 
			'#ua_add_posts#'     => __( 'Add Post' ),				
			'#ua_user_activity#' => __( 'My Activity' ),
			'#ua_posts#'         => __( 'My Posts' ),
			'#ua_comments#'      => __( 'My Comments' ),
			'#ua_profile#'       => __( 'Profile' ),
			'#ua_account#'       => __( 'Account' ),
			);
			$elems_obj = array();
			foreach ( $elems as $value => $title ) {
				$elems_obj[ $title ] 				= new USERS_ACTIVITY_MENU_PAGE();
				$elems_obj[ $title ]->object_id		= esc_attr( $value );
				$elems_obj[ $title ]->title			= esc_attr( $title );
				$elems_obj[ $title ]->url			= esc_attr( $value );
				$elems_obj[ $title ]->classes   	= array(esc_attr( $value ));
			}
			
			$walker = new Walker_Nav_Menu_Checklist( array() );
		?>
		<div id="login-links" class="loginlinksdiv">
			
			<div id="tabs-panel-login-links-all" class="tabs-panel tabs-panel-view-all tabs-panel-active">
				<ul id="login-linkschecklist" class="list:login-links categorychecklist form-no-clear">
					<?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $elems_obj ), 0, (object) array( 'walker' => $walker ) ); ?>
				</ul>
			</div>
			
			<p class="button-controls">				
				<span class="add-to-menu">
					<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-login-links-menu-item" id="submit-login-links" />
					<span class="spinner"></span>
				</span>
			</p>
			
		</div>
		<?php
		}
		
		public function setup_nav_menu_item( $item ) {
			global $pagenow;
			if ( $pagenow != 'nav-menus.php' && ! defined( 'DOING_AJAX' ) && isset( $item->url ) && strstr( $item->url, '#ua_' ) != '') {
				$option = get_option('ua_options');
				if (!empty($option['logout_redirect'])){
					$item_redirect = $option['logout_redirect'];
				}
				else {
					$item_redirect = $_SERVER['REQUEST_URI'];
				}
				$item_url = substr( $item->url, 0, strpos( $item->url, '#', 1 ) ) . '#';				
				switch ( $item_url ) {					
					case '#ua_logout#' : 	$item->url = wp_logout_url( $item_redirect ); 
					break;
					case '#ua_register#' : 	$item->url = home_url( '/ua-register' ); 
					break;
					case '#ua_login#' : 	$item->url = home_url( '/ua-login' ); 
					break;
					case '#ua_lost_password#' : 	$item->url = home_url( '/ua-lostpassword' ); 
					break;
					case '#ua_add_posts#' : 	$item->url = home_url( '/ua-add-post' ); 
					break;
					case '#ua_user_activity#' : 	$item->url = home_url( '/ua-activity' ); 
					break;
					case '#ua_posts#' : 	$item->url = home_url( '/ua-posts' ); 
					break;
					case '#ua_comments#' : 	$item->url = home_url( '/ua-comments' ); 
					break;
					case '#ua_profile#' : 	$item->url = home_url( '/ua-profile' ); 
					break;
					case '#ua_account#' : 	$item->url = '#'; 					
					break;
				}
				$item->url = esc_url( $item->url );
				
			}
			
			return $item;
			
		}
		public function exclude_menu_items( $items ) {
			foreach ( $items as $key => $item ) {
				if ($item->type == 'custom'){
					$visible = is_user_logged_in() ? true : false;
					if ($visible == true){
						$classes = array('ua_register','ua_login','ua_lost_password'); 
						foreach ($classes as $value){
							$item_class = array_search($value, $item->classes);
							if ($item_class !== false){
								unset( $items[$key] );								
							}						
						}	
						if (array_search('ua_account', $item->classes)!== false){
							$user_id = get_current_user_id();
							$user_info = get_userdata($user_id);
							$item->title = $user_info->user_login;
						}
					}					
					else {
						$classes = array('ua_add_posts','ua_user_activity','ua_posts', 'ua_comments', 'ua_profile', 'ua_logout', 'ua_account'); 
						foreach ($classes as $value){
							$item_class = array_search($value, $item->classes);
							if ($item_class !== false){
								unset( $items[$key] );
							}
						}
					}
				}
				
			}
			return $items;			
		}		
	}