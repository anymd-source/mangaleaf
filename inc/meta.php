<?php
add_filter( 'rwmb_meta_boxes', 'your_prefix_register_meta_boxes' );
function your_prefix_register_meta_boxes( $meta_boxes )
{
	$prefix = 'ero_';
	$meta_boxes[] = array(
		'id' => 'autogenerateimgcat',
		'title' => __( 'Automatic', 'meta-box' ),
	        'pages' => array( 'manga' ),
	        'context' => 'normal',
		'priority' => 'high',
		'autosave' => false,
		'fields' => array(
			array(
				
				'id'   => "{$prefix}autogenerateimgcat",
				'desc'  => __( 'Auto Create Featured Image and Category', 'meta-box' ),
				'type' => 'checkbox',
				'std' => 1,
			),
			array(
				'name'  => __( 'Auto Generate Image URL', 'meta-box' ),
				'id'    => "{$prefix}image",
				'type'  => 'text',
			),
		)
	);
	$meta_boxes[] = array(
		'id' => 'manga',
		'title' => __( 'Manga Info', 'meta-box' ),
		'pages' => array( 'manga' ),
		'context' => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields' => array(
			array(
				'name'     => __( 'Reader Area Style', 'meta-box' ),
				'id'       => "{$prefix}chapter_mode",
				'desc'	   => 'If you set it to "None", it will follow the main setting in the theme settings',
				'type'     => 'select',
				'options'  => array(
					'' => __( 'None', 'meta-box' ),
					'minimal' => __( 'Minimal', 'meta-box' ),
					'advanced' => __( 'Advanced', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '',
			),
			array(
				'name'     => __( 'Slider?', 'meta-box' ),
				'id'       => "{$prefix}slider",
				'desc'	   => 'make sure you upload Big Cover',
				'type'     => 'select',
				'options'  => array(
					'0' => __( 'No', 'meta-box' ),
					'1' => __( 'Yes', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '0',
			),
			array(
                'name'  => __( 'Big Cover', 'meta-box' ),
                'id'    => "{$prefix}cover",
                'type'  => 'image_advanced',
				'max_file_uploads' => '1'
            ),
			array(
				'name'     => __( 'Hot Manga?', 'meta-box' ),
				'id'       => "{$prefix}hot",
				'type'     => 'select',
				'options'  => array(
					'1' => __( 'Yes', 'meta-box' ),
					'0' => __( 'No', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '0',
			),
			array(
				'name'     => __( 'Project?', 'meta-box' ),
				'id'       => "{$prefix}project",
				'type'     => 'select',
				'options'  => array(
					'0' => __( 'No', 'meta-box' ),
					'1' => __( 'Yes', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '0',
			),
			array(
				'name'  => __( 'Alternative', 'meta-box' ),
				'id'    => "{$prefix}japanese",
				'type'  => 'text',
			),
			array(
				'name'     => __( 'Type', 'meta-box' ),
				'id'       => "{$prefix}type",
				'type'     => 'select',
				'options'  => array(
					'Manga' => __( 'Manga', 'meta-box' ),
					'Manhwa' => __( 'Manhwa', 'meta-box' ),
					'Manhua' => __( 'Manhua', 'meta-box' ),
					'Comic' => __( 'Comic', 'meta-box' ),
					'Novel' => __( 'Novel', 'meta-box' )
				),
				'multiple'    => false,
				'std'         => 'Manga',
			),
			array(
				'name'     => __( 'Status', 'meta-box' ),
				'id'       => "{$prefix}status",
				'type'     => 'select',
				'options'  => array(
					'Ongoing' => __( 'Ongoing', 'meta-box' ),
					'Completed' => __( 'Completed', 'meta-box' ),
					'Hiatus' => __( 'Hiatus', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => 'Ongoing',
			),
			array(
				'name'  => __( 'Author', 'meta-box' ),
				'id'    => "{$prefix}author",
				'type'  => 'text',
			),
			array(
				'name'  => __( 'Artist', 'meta-box' ),
				'id'    => "{$prefix}artist",
				'type'  => 'text',
			),
			array(
				'name'  => __( 'Published', 'meta-box' ),
				'id'    => "{$prefix}published",
				'type'  => 'text',
			),
			array(
				'name'  => __( 'Serialization', 'meta-box' ),
				'id'    => "{$prefix}serialization",
				'type'  => 'text',
			),
			array(
				'name'  => __( 'Score', 'meta-box' ),
				'id'    => "{$prefix}score",
				'type'  => 'text',
			),
         )
			
	);
	$meta_boxes[] = array(
		'id' => 'galleryarea',
		'title' => __( 'Gallery', 'meta-box' ),
	        'pages' => array( 'manga' ),
	        'context' => 'normal',
		'fields' => array(
			array(
				'name' => __( 'Upload', 'meta-box' ),
				'id'   => "{$prefix}gallery",
				'type' => 'image_advanced',
				'force_delete' => false,
				'image_size' => 'thumbnail',
			),
		)
	);
	$meta_boxes[] = array(
		'id' => 'mangabatch',
		'title' => __( 'Additional Content', 'meta-box' ),
		'pages' => array( 'manga' ),
		'context' => 'normal',
		'autosave' => true,
		'fields' => array(
			array(
				'name'  => __( 'Content', 'meta-box' ),
				'id'    => "{$prefix}batch",
				'type'  => 'wysiwyg',
				'sanitize_callback' => 'none',
			),
         )
			
	);
	$meta_boxes[] = array(
		'id' => 'chapter',
		'title' => __( 'Chapter', 'meta-box' ),
	        'pages' => array( 'post' ),
		'context' => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields' => array(
			array(
				'name' => __( 'Chapter', 'meta-box' ),
				'id'   => "{$prefix}chapter",
				'type' => 'text',
			),
			array(
				'name'    => __( 'Manga', 'meta-box' ),
				'id'      => "{$prefix}seri",
				'type'    => 'post',

				// Post type
				'post_type' => 'manga',
				// Field type, either 'select' or 'select_advanced' (default)
				'field_type' => 'select_advanced',
				// Query arguments (optional). No settings means get all published posts
				'query_args' => array(
					'post_status'    => 'publish',
					'posts_per_page' => -1,
				)
			),
			array(
				'name'  => __( 'Link Download', 'meta-box' ),
				'id'    => "{$prefix}download",
				'type'  => 'text',
				'desc'  => __( 'Use http:// or https://', 'meta-box' ),
			),
			array(
				'name'     => __( 'Photon CDN', 'meta-box' ),
				'id'       => "{$prefix}imagecdn",
				'type'     => 'select',
				'options'  => array(
					'' => __( 'Default', 'meta-box' ),
					'disable' => __( 'Disable', 'meta-box' ),
					'enable' => __( 'Enable', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '',
			),
		)
	);
	$meta_boxes[] = array(
        'title'  => 'Mirror',
		'pages' => array( 'post' ),
        'fields' => array(
            array(
                'id'     => 'ab_embedgroup',
                'type'   => 'group',
                'clone'  => true,
				'sort_clone'  => true,
				'save_state' => true,
                'fields' => array(
                    array(
                        'name'  => 'Host Name',
                        'id'    => 'ab_hostname',
                        'type'  => 'text',
                    ),
                    array(
                        'name'   => 'Image Code',
                        'id'     => 'ab_embed',
                        'type'   => 'textarea',
						'sanitize_callback' => 'none',
                    ),
                ), //chapter
            ), //input-version
        ),
    );
	return $meta_boxes;
}