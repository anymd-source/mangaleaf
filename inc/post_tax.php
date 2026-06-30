<?php
// Register Manga 
function manga() { 

    $labels = array( 
        'name'                => _x( 'Manga', 'Post Type General Name', 'text_domain' ), 
        'singular_name'       => _x( 'Manga', 'Post Type Singular Name', 'text_domain' ), 
        'menu_name'           => __( 'Manga', 'text_domain' ), 
        'parent_item_colon'   => __( 'Parent Manga:', 'text_domain' ), 
        'all_items'           => __( 'All Manga', 'text_domain' ), 
        'view_item'           => __( 'View Manga', 'text_domain' ), 
        'add_new_item'        => __( 'Add Manga', 'text_domain' ), 
        'add_new'             => __( 'Add Manga', 'text_domain' ), 
        'edit_item'           => __( 'Edit Manga', 'text_domain' ), 
        'update_item'         => __( 'Update Manga', 'text_domain' ), 
        'search_items'        => __( 'Search manga', 'text_domain' ), 
        'not_found'           => __( 'Not Found', 'text_domain' ), 
        'not_found_in_trash'  => __( 'Not Found', 'text_domain' ), 
    ); 
    $args = array( 
        'label'               => __( 'manga', 'text_domain' ), 
        'description'         => __( 'Manga', 'text_domain' ), 
        'labels'              => $labels, 
        'supports'            => array( 'title', 'editor', 'thumbnail', 'comments'), 
        'taxonomies'          => array( 'genres' ), 
        'hierarchical'        => false, 
        'public'              => true, 
        'show_ui'             => true, 
        'show_in_menu'        => true, 
        'show_in_nav_menus'   => true, 
        'show_in_admin_bar'   => true, 
        'menu_position'       => 5, 
        'menu_icon'           => 'dashicons-forms', 
        'can_export'          => true, 
        'has_archive'         => true, 
        'exclude_from_search' => false, 
        'publicly_queryable'  => true, 
        'capability_type'     => 'post', 
    ); 
    register_post_type( 'manga', $args ); 

} 

// Hook into the 'init' action 
add_action( 'init', 'manga', 0 ); 

// Register Blog 
function blog() { 

    $labels = array( 
        'name'                => _x( 'Blog', 'Post Type General Name', 'text_domain' ), 
        'singular_name'       => _x( 'Blog', 'Post Type Singular Name', 'text_domain' ), 
        'menu_name'           => __( 'Blog', 'text_domain' ), 
        'parent_item_colon'   => __( 'Parent Blog:', 'text_domain' ), 
        'all_items'           => __( 'All Blog', 'text_domain' ), 
        'view_item'           => __( 'View Blog', 'text_domain' ), 
        'add_new_item'        => __( 'Add Blog', 'text_domain' ), 
        'add_new'             => __( 'Add Blog', 'text_domain' ), 
        'edit_item'           => __( 'Edit Blog', 'text_domain' ), 
        'update_item'         => __( 'Update Blog', 'text_domain' ), 
        'search_items'        => __( 'Search blog', 'text_domain' ), 
        'not_found'           => __( 'Not Found', 'text_domain' ), 
        'not_found_in_trash'  => __( 'Not Found', 'text_domain' ), 
    ); 
    $args = array( 
        'label'               => __( 'blog', 'text_domain' ), 
        'description'         => __( 'Blog', 'text_domain' ), 
        'labels'              => $labels, 
        'supports'            => array( 'title', 'editor', 'thumbnail', 'comments'), 
		'taxonomies'          => array( 'post_tag' ), 
        'hierarchical'        => false, 
        'public'              => true, 
        'show_ui'             => true, 
        'show_in_menu'        => true, 
        'show_in_nav_menus'   => true, 
        'show_in_admin_bar'   => true, 
        'menu_position'       => 5, 
        'menu_icon'           => 'dashicons-editor-alignleft', 
        'can_export'          => true, 
        'has_archive'         => true, 
        'exclude_from_search' => false, 
        'publicly_queryable'  => true, 
        'capability_type'     => 'post', 
    ); 
    register_post_type( 'blog', $args ); 

} 

// Hook into the 'init' action 
add_action( 'init', 'blog', 0 ); 

// Register Taxonomy Genres 
function genres() { 

    $labels = array( 
        'name'                       => _x( 'Genres', 'Taxonomy General Name', 'text_domain' ), 
        'singular_name'              => _x( 'Genres', 'Taxonomy Singular Name', 'text_domain' ), 
        'menu_name'                  => __( 'Genres', 'text_domain' ), 
        'all_items'                  => __( 'All Genres', 'text_domain' ), 
        'parent_item'                => __( 'Parent Genre', 'text_domain' ), 
        'parent_item_colon'          => __( 'Parent Genre:', 'text_domain' ), 
        'new_item_name'              => __( 'New Genre Name', 'text_domain' ), 
        'add_new_item'               => __( 'Add New Genre', 'text_domain' ), 
        'edit_item'                  => __( 'Edit Genre', 'text_domain' ), 
        'update_item'                => __( 'Update Genre', 'text_domain' ), 
        'separate_items_with_commas' => __( 'Separate Genres with commas', 'text_domain' ), 
        'search_items'               => __( 'Search Genres', 'text_domain' ), 
        'add_or_remove_items'        => __( 'Add or remove genres', 'text_domain' ), 
        'choose_from_most_used'      => __( 'Choose from the most used genres', 'text_domain' ), 
        'not_found'                  => __( 'Not Found', 'text_domain' ), 
    ); 
    $args = array( 
        'labels'                     => $labels, 
        'hierarchical'               => false, 
        'public'                     => true, 
        'show_ui'                    => true, 
        'show_admin_column'          => true, 
        'show_in_nav_menus'          => true, 
        'show_tagcloud'              => true, 
    ); 
    register_taxonomy( 'genres', array( 'manga' ), $args ); 

} 

// Hook into the 'init' action 
add_action( 'init', 'genres', 0 ); 