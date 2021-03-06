<?php 
    /**
     * Template Name: Only Logged In
     */
get_header();
the_post(); ?>
    <div class="sp-md-2"></div>
    <?php if(bw_user_logged_in()): ?>
        <?php the_content(); ?>
    <?php else: ?>
        <h1>You must be logged in to see this page!</h1>
        <?php echo do_shortcode('[bw-custom-auth]'); ?>
    <?php endif; ?>
    <div class="sp-md-2"></div>
<?php get_footer(); ?>