<?php
/*
The Page Loop
=============
*/
?>
<?php if (!is_front_page() && function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » '); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>
<?php the_content()?>
<?php wp_link_pages(); ?>

<?php endwhile; else: ?>
<?php get_template_part( 'loops/content', 'none' ); ?>
<?php exit; ?>
<?php endif; ?>
