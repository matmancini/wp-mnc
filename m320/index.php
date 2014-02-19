<?php get_header(); ?>

<section class="l-content" role="main">

	<h1 class="page-title">
		<?php _e('Recent Posts', 'm320'); ?>
	</h1>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

		<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; ?>

</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
