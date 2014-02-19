<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage m320
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="s" class="visuallyhidden"><?php _e( 'Search', 'm320' ); ?></label>
	<input type="search" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'm320' ); ?>" />
	<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'm320' ); ?>" />
</form>
