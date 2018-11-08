<?php

	class BW_Custom_Post_Category implements IBW_Custom_Post_Category_Term {
		public $title = "";

		public $link = "";

		public function __construct(WP_Term $term) {
			$this->title = $term->name;

			$this->link = get_term_link($term);
		}

		public function get_link () {
			return $this->link;
		}
		public function get_title () {
			return $this->title;
		}
	}