<?php 

	if (!function_exists("register_custom_post_artwork")) {
		/**
		 * Register custom type "Artwork" with attributes:
		 * - Title
		 * - Year
		 * - Place
		 * @return void
		 */
		function register_custom_post_artwork () {
			$labels = array(
				'name' => __("Artworks", "brainworks"),
				'singular_name' => __("Artwork", "brainworks")
			);

			$args = array(
				"labels" => $labels,
				"public" => true,
				"hierarchical" => true,
				"has_archive" => true,
				"supports" => ['title', 'editor', 'custom-fields', 'thumbnail', 'taxonomies']
			);

			register_post_type('artworks', $args);

			register_taxonomy( 'artwork_categories', array('artworks'), array(
				'hierarchical' => true,
				'label' => "Categories",
				'singular_label' => "Category",
				"rewrite" => array("slug" => "categories", "with_front" => true)
			) );
		}

		add_action( 'init', 'register_custom_post_artwork' );
	}

	if (!function_exists("artwork_metabox")) {
		/**
		 * @param {array} $meta_boxes Array of existed meta-boxes
		 * @return {array} Updated meta-boxes
		 */
		function artwork_metabox ($meta_boxes) {
			$prefix = "bw-";

			$meta_boxes[] = array(
				'id' => 'review_metabox',
				'title' => esc_html__( 'Meta-data', 'brainworks' ),
				'post_types' => array('artworks'),
				'context' => 'advanced',
				'priority' => 'default',
				'autosave' => 'false',
				'fields' => array(
					array(
						'id' => $prefix . 'year',
						'type' => 'number',
						'name' => esc_html__( 'Year (XXXX)', 'brainworks' ),
					),
					array(
						'id' => $prefix . 'place',
						'type' => 'number',
						'name' => esc_html__( 'The place of exposition (Berlin)', 'brainworks' ),
					)
				),
			);
			return $meta_boxes;
		}

		add_filter( 'rwmb_meta_boxes', 'artwork_metabox' );
	}

?>