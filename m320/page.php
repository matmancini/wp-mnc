<?php get_header(); ?>

<section class="l-content" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<div <?php post_class(); ?>>
			<h1 class="page-title">
				<?php the_title(); ?>
			</h1>
			<?php the_content(); ?>
		</div>

	<?php endwhile; ?>

</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
