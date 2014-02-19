<?php get_header(); ?>

<section class="l-content" role="main">

<?php if ( have_posts() ) : ?>

	<h1 class="page-title">
		<?php printf( __( 'Search Results for: %s', 'm320' ), '<span>' . get_search_query() . '</span>' ); ?>
	</h1>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', get_post_format() ); ?>

	<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part( 'content', 'none' ); ?>

<?php endif; ?>

</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
