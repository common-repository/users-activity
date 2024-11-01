<?php
	/**
		* Install Function
		*
		* @package     UA
		* @subpackage  Functions/Install
		* @copyright   Copyright (c) 2017, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       1.0
	*/
	
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) exit;
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');	
	$table = $wpdb->prefix . 'ua_table';	
	$sql = "CREATE TABLE " . $table." (
		id mediumint(11) NOT NULL AUTO_INCREMENT,
		user_name VARCHAR(60),  
		user_email VARCHAR(100),
		user_fname VARCHAR(60),
		user_lname VARCHAR(60),
		password VARCHAR(15),
		code VARCHAR(15),
		ctime INT(11),	
		UNIQUE KEY id (id)
	) DEFAULT CHARSET=utf8;";
	dbDelta($sql);
	
	// Information needed for creating the plugin's pages
    $page_definitions = array(
		'ua-login' => array(
			'title' => __( 'Sign In', 'wow-users' ),
			'content' => '[ua_login]'
		),
		'ua-profile' => array(
			'title' => __( 'Your Profile', 'wow-users' ),
			'content' => '[ua_profile]'
		),
		'ua-register' => array(
			'title' => __( 'Sign Up', 'wow-users' ),
			'content' => '[ua_register]'
		),
		'ua-lostpassword' => array(
			'title' => __( 'Lost Password', 'wow-users' ),
			'content' => '[ua_lost_password]'
		),
		'ua-add-post' => array(
			'title' => __( 'Add Post', 'wow-users' ),
			'content' => '[ua_add_posts]'
		),
		'ua-posts' => array(
			'title' => __( 'Your Posts', 'wow-users' ),
			'content' => '[ua_posts]'
		),
		'ua-comments' => array(
			'title' => __( 'Your Comments', 'wow-users' ),
			'content' => '[ua_comments]'
		),
		'ua-activity' => array(
			'title' => __( 'Your Activity', 'wow-users' ),
			'content' => '[ua_user_activity]'
		),
	
    );
	
    foreach ( $page_definitions as $slug => $page ) {
        // Check that the page doesn't exist already
        $query = new WP_Query( 'pagename=' . $slug );
        if ( ! $query->have_posts() ) {
            // Add the page using the data from the array above
            wp_insert_post(
			array(
				'post_content'   => $page['content'],
				'post_name'      => $slug,
				'post_title'     => $page['title'],
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'ping_status'    => 'closed',
				'comment_status' => 'closed',
				)
            );
		}
	}