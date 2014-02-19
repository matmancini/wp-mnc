<?php
/**
* The Header for our theme.
*
* @package WordPress
* @subpackage m320
*/
?>
<!DOCTYPE html>
<!--[if lt IE 8]>
<html class="no-js ie oldie" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="no-js ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html class="no-js ie ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8)| !(IE 9)  ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />

	<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
	<meta name="author" content="Matias Mancini" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- wp header -->
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header class="l-header" role="banner">
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
			</a>

			<div class="main-nav" role="navigation">
				<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'm320' ); ?>"><?php _e( 'Skip to content', 'm320' ); ?></a>
				<?php wp_nav_menu( array('container' => false, 'menu' => 'primary', 'menu_class' => 'main-nav-menu' ) ) ?>
			</div>
		</header>

		<main class="l-main">

