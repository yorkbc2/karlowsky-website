<?php get_header(); ?>
	<div id="gallery" class="gallery">
		<div class="gallery-items">
			<?php if (have_posts()): ?>
				<?php while(have_posts()): the_post(); ?>
					<div class="gallery-item">
						<img data-key="image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), "large"); ?>" alt="">
						<img data-key="thumbnail" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), "medium"); ?>" alt="" />
						<span data-key="name"><?php the_title(); ?></span>
						<span data-key="year"><?php echo get_post_meta(get_the_ID(), 'bw-year', true) ?></span>
						<span data-key="place"><?php echo get_post_meta(get_the_ID(), 'bw-place', true) ?></span>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer(); ?>
