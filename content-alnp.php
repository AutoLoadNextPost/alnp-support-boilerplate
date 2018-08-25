<?php
/**
 * The repeater template for displaying a post when called.
 *
 * @author  Sébastien Dumont
 * @license GPL-2.0+
 * @version 1.5.0
 */

if ( have_posts() ) :

	// Load content before the loop.
	do_action( 'alnp_load_before_loop' );

	// Check that there are posts to load.
	while ( have_posts() ) : the_post();

		$post_format = get_post_format(); // Post Format e.g. video

		$post_type = alnp_get_post_type(); // Post Type e.g. single

		// Load content before the post content.
		do_action( 'alnp_load_before_content' );

		// Load content before the post content for a specific post format.
		do_action( 'alnp_load_before_content_post_format_' . $post_format );

		// Load content before the post content for a specific post type.
		do_action( 'alnp_load_before_content_post_type_' . $post_type );

		if ( false === $post_format ) {
			/*
			 * Include the Post-Type-specific template for the content.
			 * content-___.php (where ___ is the Post Type name).
			 */
			if ( locate_template( alnp_template_location() . 'content-' . $post_type . '.php') != '' ) {
				get_template_part( alnp_template_location() . 'content', $post_type );
			} else {
				// If no specific post type found then fallback to standard content.php file.
				get_template_part( alnp_template_location() . 'content' );
			}
		} else {
			/*
			 * Include the Post-Format-specific template for the content.
			 * called format-___.php (where ___ is the Post Format name).
			 */
			if ( locate_template( alnp_template_location() . 'format-' . $post_format . '.php' ) != '' ) {
				get_template_part( alnp_template_location() . 'format', $post_format );
			} else {
				// If no format-{post-format}.php file found then fallback to content-{post-format}.php
				get_template_part( alnp_template_location() . 'content', $post_format );
			}
		}

		// Load content after the post content for a specific post type.
		do_action( 'alnp_load_after_content_post_type_' . $post_type );

		// Load content after the post content for a specific post format.
		do_action( 'alnp_load_after_content_post_format_' . $post_format );

		// Load content after the post content.
		do_action( 'alnp_load_after_content' );

	// End the loop.
	endwhile;

	// Load content after the loop.
	do_action( 'alnp_load_after_loop' );

else :

	// Load content if there are no more posts.
	do_action( 'alnp_no_more_posts' );

endif; // END if have_posts()
