<?php 
/**
 * Template Name: Page Front
 **/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
    <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/img/favicon.ico'); ?>"
          type="image/x-icon">
    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/img/favicon.ico'); ?>"
          type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body>
	
	<div class="wrapper container">
		<div class="nav">
			<div class="nav-container">
				<div></div>
				<div class="nav-menu">
					<ul class="nav-lang-menu">
                        <?php pll_the_languages(['hide_empty' => 0, 'display_names_as' => 'slug']); ?>
                    </ul>
				</div>
			</div>
		</div>
		<div class="centered-logo">
			<a href="<?php echo esc_url( "/artworks" ); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.jpg" alt="" width="640px" height="auto" />	
			</a>
		</div>
	</div>

	<?php wp_footer(); ?>
</body>
</html>