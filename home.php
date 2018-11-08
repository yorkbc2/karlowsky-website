<?php get_header(); ?>
<h1 class="page-name"><?php single_post_title(); ?></h1>

<?php get_template_part('loops/content-2', get_post_format()); ?>

<?php get_footer(); ?>
