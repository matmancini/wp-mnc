<?php
/**
 * MNC Global Theme Options
 * Add custom menu in the Settings Admin to update the wp_options table
 * Based on: http://wp.tutsplus.com/tutorials/creative-coding/quick-tip-create-a-wordpress-global-options-page/
 */

add_action('admin_menu', function(){
	add_options_page('MNC Theme Options', 'MNC Theme Options', 'manage_options', 'mnc-theme-options', 'mnc_theme_options');
});

function mnc_theme_options(){ ?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2><?php _e('Theme Global Options', 'm320') ?></h2>

		<form action="options.php" method="post">
			<?php wp_nonce_field('update-options') ?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="mnc_twitter_url, mnc_facebook_url, mnc_site_email, mnc_youtube_url, mnc_typekit_id, mnc_google_ua, mnc_google_sv, mnc_linkedin_url,
mnc_vimeo_url, mnc_googleplus_url" />

			<h3><?php _e('Website Data', 'm320') ?></h3>
			<table class="form-table">
				<tr>
					<th><label for="mnc_site_email">Site Email</label></th>
					<td><input type="text" name="mnc_site_email" class="regular-text" value="<?php echo get_option('mnc_site_email') ?>" /></td>
				</tr>
			</table>
			<h3><?php _e('Social Profiles', 'm320') ?></h3>
			<table class="form-table">
				<tr>
					<th><label for="mnc_facebook_url">Facebook URL</label></th>
					<td><input type="text" name="mnc_facebook_url" class="regular-text" value="<?php echo get_option('mnc_facebook_url') ?>" /></td>
				</tr>
				<tr>
					<th><label for="mnc_twitter_url">Twitter URL</label></th>
					<td><input type="text" name="mnc_twitter_url" class="regular-text" value="<?php echo get_option('mnc_twitter_url') ?>" /></td>
				</tr>
				<tr>
					<th><label for="mnc_googleplus_url">Google+ URL</label></th>
					<td><input type="text" name="mnc_googleplus_url" class="regular-text" value="<?php echo get_option('mnc_googleplus_url') ?>" /></td>
				</tr>
				<tr>
					<th><label for="mnc_linkedin_url">Linkedin URL</label></th>
					<td><input type="text" name="mnc_linkedin_url" class="regular-text" value="<?php echo get_option('mnc_linkedin_url') ?>" /></td>
				</tr>
				<tr>
					<th><label for="mnc_youtube_url">YouTube URL</label></th>
					<td><input type="text" name="mnc_youtube_url" class="regular-text" value="<?php echo get_option('mnc_youtube_url') ?>" /></td>
				</tr>
				<tr>
					<th><label for="mnc_vimeo_url">Vimeo URL</label></th>
					<td><input type="text" name="mnc_vimeo_url" class="regular-text" value="<?php echo get_option('mnc_vimeo_url') ?>" /></td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" id="submit" class="button-primary" value="Save Changes" name="Submit" />
			</p>
		</form>
	</div>
<?php }

?>
