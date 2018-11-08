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
<body <?php body_class(); ?> id="top">

<?php wp_body(); ?>

<div class="wrapper">
    <div class="page-wrapper container">

        <div class="nav">
            <div class="nav-container">
                <div class="nav-logo">
                    <?php if (!is_front_page()): ?>
                        <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.jpg" alt=""></a>
                    <?php else: ?>
                        <span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.jpg" alt=""></span>
                    <?php endif; ?>
                </div>
                <div class="nav-menu">
                    <ul class="nav-lang-menu">
                        <?php pll_the_languages(['hide_empty' => 0, 'display_names_as' => 'name']); ?>
                    </ul>
                    <ul class="nav-primary-menu">
                        <?php if ($items = wp_get_nav_menu_items('Main Navigation')): ?>
                            <?php foreach ($items as $item): ?>
                                <li>
                                <?php if (home_url($wp->request) . '/' !== $item->url): ?>
                                    <a href="<?php echo $item->url; ?>">
                                        <?php echo $item->title; ?>
                                    </a>
                                <?php else: ?>
                                    <span class="current-item">
                                        <?php echo $item->title; ?>
                                    </span>
                                <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <?php if (is_post_type_archive('artworks')): ?>
                    <ul class="nav-submenu">
                        <?php if ($items = get_custom_post_type_categories('artworks')): ?>
                            <?php foreach ($items as $item): ?>
                                <li>
                                    <a href="<?php echo $item->get_link(); ?>">
                                        <?php echo $item->get_title(); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>