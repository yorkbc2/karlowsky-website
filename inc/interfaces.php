<?php 

	interface IBW_Custom_Post_Category_Term {

		public function __construct(WP_Term $term);
		public function get_link();
		public function get_title();

	}