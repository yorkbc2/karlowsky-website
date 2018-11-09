<?php 

	if (!function_exists('get_localize')) {
		function get_localize () {
			$filename = get_template_directory() . "/languages/" . pll_current_language() . ".json"; 
			$content = array();

			if (file_exists($filename)) {
				$content = file_get_contents($filename);
				$content = json_decode($content);
			}

			return $content;
		}
	}

	if (!function_exists('the_localize_script')) {
		function the_localize_script () {
			$strings = get_localize();
			$output = "<script>
			window.TRANSLATED_STRINGS = {";
			
			foreach ($strings as $key=>$string) {
				$output .= "\"$key\": \"$string\","; 
			}

			
			$output .= "
				$: function (key) {
					return this[key] || key;
				}
			}
		</script>";

			echo $output;
		}
	}