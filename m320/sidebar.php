<?php
/**
* The Sidebar containing the main widget area.
*
* @package WordPress
* @subpackage m320
*/
?>
<section class="l-sidebar" role="complementary">

	<h1 class="visuallyhidden">Sidebar</h1>

	<div class="widget widget-search">
		<h2><?php _e( 'Blog Search', 'm320' ); ?></h2>
		<?php get_search_form(); ?>
	</div>

	<div class="widget widget-categories">
		<h2><?php _e( 'Posts Categories', 'm320' ); ?></h2>

		<?php $cats = get_categories(); ?>
		<ul>
			<?php
			foreach($cats as $category){
				echo '<li><a href="'. get_category_link( $category->term_id ) .'" title="Ver todas las entradas en '.$category->name.'">' . $category->name . '</a></li>';
			}
			?>
		</ul>
	</div>

	<div class="widget widget-recentposts">
		<?php $args = array(
			'numberposts' => 5,
			'orderby' => 'post_date'
			);
		$posts = get_posts($args);
		?>
		<h2><?php _e( 'Recent Posts', 'm320' ); ?></h2>
		<ul>
			<?php foreach($posts as $post) : ?>
				<li><a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><?php the_title(); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>


	<div class="widget widget-tags">
		<h2><?php _e( 'Posts Tags', 'm320' ); ?></h2>
		<?php $args = array(
			'smallest' => 10,
			'largest' => 20,
			'orderby' => 'count',
			'order' => 'DESC',
			'number' => 50,
			'separator' => ",\n",
			'format' => 'list'
		); ?>
		<?php wp_tag_cloud($args); ?>
	</div>

</section>
