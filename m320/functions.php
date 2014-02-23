<?php
/**
 * @package WordPress
 * @subpackage m320
 */

/**
 * Define Constants
 */
define('M320_TEMPLATE_URI', get_template_directory_uri());
define('M320_STYLESHEET_URI', get_stylesheet_directory_uri());
define('M320_SITE_EMAIL', get_option('mnc_site_email') ? get_option('mnc_site_email') : 'info@' . mb_substr(get_bloginfo('wpurl'), 7));
define('M320_SITE_NAME', wp_specialchars_decode(get_bloginfo('name')));
define('M320_SITE_DESCRIPTION', wp_specialchars_decode(get_bloginfo('description')));

/**
 * Load up our theme options page and related code.
 */
require_once( STYLESHEETPATH . '/inc/theme-options/theme-options.php' );





/*
-------------------------------------------------------------------------------
HOOKS
-------------------------------------------------------------------------------
*/

/**
 * after_setup_theme Hook
 */
add_action( 'after_setup_theme', function(){

    // Translations
    load_theme_textdomain( 'm320', TEMPLATEPATH . '/languages' );

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Add default posts and comments RSS feed links to <head>.
    //add_theme_support( 'automatic-feed-links' );

    // This theme supports a variety of post formats.
    //add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

    // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
    add_theme_support( 'post-thumbnails' );

    // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
    set_post_thumbnail_size( 640, 400, true );

    //Enable Navigation (primary - secondary))
    register_nav_menus(array(
        'primary' => __('Primary navigation', 'm320'),
        'secondary' => __('Secondary Navigation', 'm320')
    ));

});

/**
 * Remove Metadata Generator in HTML & RSS Feed
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove Admin Bar
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Default "Link to File" when uploading an image
 */
update_option('image_default_link_type', 'file');

/**
 * Register Default Sidebar
 **/
add_action('widgets_init', function(){

    // Register Default Sidebar
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'm320' ),
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    // Remove comment reply head styles
    // http://www.narga.net/how-to-remove-or-disable-comment-reply-js-and-recentcomments-from-wordpress-header
    global $wp_widget_factory;

    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );

});

/**
 * Adds body class with post_name
 */
add_filter( 'body_class', function($classes) {

    if ( is_page() ){
        global $post;
        $classes[] = $post->post_name;
    }
	return $classes;

});

/**
 * Adds body class with catecory name to single post
 */
add_filter('body_class', function ($classes) {

    if (is_single()) {

        global $post;

        foreach((get_the_category($post->ID)) as $category) {
            // add category slug to the $classes array
            $classes[] = $category->category_nicename;
        }
    }

    // return the $classes array
    return $classes;

});


/**
 * Remove the #id from the "read more" link
 */
add_filter('the_content_more_link', function($link){

    $offset = strpos($link, '#more-');

    if ($offset) {
        $end = strpos($link, '"',$offset);
    }
    if ($end) {
        $link = substr_replace($link, '', $offset, $end-$offset);
    }

    return $link;

});

/**
 * Modify Contact Information
 * Add: Google, Twitter, Facebook, LinkedIn
 * Remove: YIM, AIM, Jabber
 **/
add_filter('user_contactmethods', function($contactmethods){
    $contactmethods['google'] = 'Google';
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';
    $contactmethods['linkedin'] = 'LinkedIn';
    $contactmethods['vimeo'] = 'Vimeo';
    unset($contactmethods['yim']);
    unset($contactmethods['aim']);
    unset($contactmethods['jabber']);

    return $contactmethods;
}, 10, 1);

/**
 * Email Administrator on new & edited Posts
 */
add_action('publish_post', function($post_id){
    $post = get_post($post_id);
    $title = $post->post_title;
    $permalink = get_permalink($post->ID);
    wp_mail( get_option('admin_email'), '[Blog Post] ' . $title , $permalink );
});

/**
 * Wrap iframes with .video-container
 * http://webdesignerwall.com/tutorials/css-elastic-videos
 */
add_filter('the_content', function( $content ){

    $pattern = '~<iframe.*</iframe>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        // wrap matched iframe with div
        $wrappedframe = '<div class="video-container">' . $match . '</div>';

        //replace original iframe with new in content
        $content = str_replace($match, $wrappedframe, $content);
    }

    return $content;

});

/*
-------------------------------------------------------------------------------
THEME FUNCTIONS
-------------------------------------------------------------------------------
*/

/**
 * Post Meta list
 * Usage echo mnc_post_meta( array('author', 'date', 'categories', 'tags') );
 *
 */
if (!function_exists('m320_post_meta')) {
    function m320_post_meta($items = [])  {
        echo '<ul class="post-meta">';

            // Author
            if (in_array('author', $items)) :
                echo '<li class="post-meta-author">';
                    echo '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . sprintf(__( 'Posts by %s', 'm320'), get_the_author()) . '">';
                        echo printf(__('By %s', 'm320'), get_the_author());
                    echo '</a>';
                echo '</li>';
            endif;

            // Date
            if (in_array('date', $items)) :
            echo '<li class="post-meta-date">';
                echo '<time datetime="' . get_the_date('c') . '">' . get_the_date('j F Y') . '</time>';
            echo '</li>';
            endif;

            // Categories
            if (in_array('categories', $items)) :
                if ($categories = get_the_category_list( __( ', ', 'm320' ) )) {
                    echo "<li class=\"post-meta-categories\">$categories</li>";
                }
            endif;

            // Tags
            if (in_array('tags', $items)) :
                if ($tags = get_the_tag_list( '', __( ', ', 'm320' ) )) {
                    echo "<li class=\"post-meta-tags\">$tags</li>";
                }
            endif;

        echo '</ul>';
    }
}


/**
 * Social Links for the Sidebar
 * Usage echo m320_social_links( array( 'facebook' => 'Facebook', 'twitter' => 'Twitter', 'googleplus' => 'Google+', 'linkedin' => 'LinkedIn' ) );
 **/
if(!function_exists('m320_social_links')){
    function m320_social_links( $social_networks, $rss = true ){

        $html = '<ul class="social-links">';

        foreach( $social_networks as $key => $val ){
            $html .= '<li class="social-links-'. $key .'">';
            $html .= '<a target="_blank", href="'. get_option( 'mnc_' . $key . '_url' ) .'">'. $val .'</a>';
            $html .= '</li>';
        }
        if( $rss ){
            $html .= '<li class="w-rss"><a target="_blank" href="'. get_bloginfo('rss2_url') .'">'. __( 'RSS Feed' ) .'</a></li>';
        }

        $html .= '</ul>';

        echo $html;
    }
}

/**
 * Social Sharing buttons
 */
/*if ( !function_exists( 'm320_social_buttons' ) ) :
function m320_social_buttons($networks){

    global $post;

    global $scripts;
    $arr = array();
    $scripts = array();

    // Facebook
    $arr['facebook']['html'] = "<div class=\"fb-like\" style=\"vertical-align:top;top:0;padding-right:30px;\" data-send=\"true\" data-layout=\"button_count\" data-width=\"auto\" data-show-faces=\"false\"></div>";
    $arr['facebook']['script'] = "'//connect.facebook.net/en_US/all.js#xfbml=1'";

    // Twitter
    $arr['twitter']['html'] = "<a style=\"opacity: 0;\" href=\"http://twitter.com/share\" lang=\"" . _x('en', 'Twitter lang', 'm320') . "\" data-count=\"horizontal\" data-counturl=\"" . get_permalink($post->ID) . "\" data-url=\"" . bitly($post->ID) . "\" class=\"twitter-share-button\">Tweet</a>";
    $arr['twitter']['script'] = "'//platform.twitter.com/widgets.js', 'tweetjs'";

    // Google+
    $arr['google']['html'] = "<g:plusone size=\"medium\" ></g:plusone>";
    $arr['google']['script'] = "'//apis.google.com/js/plusone.js', 'gplus1js'";

    // LinkedIn
    // This API does not allow async load for the moment
    // Script is inserted before HTML tag
    $arr['linkedin']['html'] = "<script src=\"http://platform.linkedin.com/in.js\"></script><script type=\"IN/Share\" data-counter=\"right\"></script>";
    //$arr['linkedin']['script'] = "'http://platform.linkedin.com/in.js'";

    echo '<div class="social-sharing content-box">';
    foreach( $networks as $network ){

        // Print Button
        echo $arr[$network]['html'] . "\n";

        // Prevent linkedIn empty value
        if (isset($arr[$network]['script'])) {
            $scripts[$network] = $arr[$network]['script'];
        }
    }
    echo '</div>';

    // Append JS Async code to the footer
    add_action('wp_footer', function ($scripts) {

        global $scripts;

        echo '<!-- Social buttons loader -->';

        // Only for Facebook
        if(isset($scripts['facebook'])){
            echo '<div id="fb-root"></div>';
        }
        ?>

        <script>
            (function(w, d, s, $) {
                function go(){
                    var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
                        if (d.getElementById(id)) {return;}
                        js = d.createElement(s); js.src = url; js.id = id;
                        fjs.parentNode.insertBefore(js, fjs);
                    };

                    <?php
                    // Scripts load
                    foreach($scripts as $script){
                        echo "load($script);\n";
                    }
                    ?>
                }
                if (w.addEventListener) { w.addEventListener("load", go, false); }
                else if (w.attachEvent) { w.attachEvent("onload",go); }
            }(window, document, 'script', jQuery));
        </script>
        <?php

    }, 100);
}
endif;*/

/**
 * Display the post date in three span labels
 **/
if ( !function_exists('m320_date_block') ) :

    function m320_date_block(){
        $shortDate = get_the_date('j/M/Y');
        $arr = explode('/', $shortDate);

        $html = '<span class="date-day">'. $arr[0] .'</span>';
        $html .= '<span class="date-month">'. $arr[1] .'</span>';
        $html .= '<span class="date-year">'. $arr[2] .'</span>';

        return $html;
    }

endif;

/**
 * Check the current post for the existence of a short code
 * http://wp.tutsplus.com/articles/quick-tip-improving-shortcodes-with-the-has_shortcode-function/
 */
if ( !function_exists('has_shortcode') ) :

    function has_shortcode($shortcode = '') {

    	$post_to_check = get_post(get_the_ID());
    	// false because we have to search through the post content first
    	$found = false;
    	// if no short code was provided, return false
    	if (!$shortcode) {
    		return $found;
    	}
    	// check the post content for the short code
    	if ( stripos($post_to_check->post_content, '[' . $shortcode) !== false ) {
    		// we have found the short code
    		$found = true;
    	}
    	// return our final results
    	return $found;
    }

endif;

/**
 * Custom bitly Shorten function
 * Creates a custom field with the bitly url before request to the server
 * http://bitly.com/
 * Inspired on: http://wp.tutsplus.com/tutorials/using-bitly-urls-in-wordpress-and-use-them-with-twitter-and-googleplus-scripts/
 */
if ( !function_exists('bitly') ) :

    // Display bitly custom field, if nox exists creates it
    function bitly($post_id){

        if( !get_post_meta($post_id, '_bitly', true) ){

            $url = get_permalink( $post_id );
            $shorten = get_bitly( $url );

            if( $shorten ){
                add_post_meta($post_id, '_bitly', $shorten);
                return $shorten;
            }else{
                return $url;
            }
        }else{
            return get_post_meta($post_id, '_bitly', true);
        }
    }

    // generate bitly short url with bitly API, only call this if no custom field is setting
    function get_bitly( $url ){

        //login information
        $encodedUrl = urlencode($url);
        $login = 'o_2gjngkcukf';   //your bit.ly login
        $apikey = 'R_d424558755617553c89a492a8ef81482'; //add your bit.ly API
        $format = 'json';   //choose between json or xml
        $version = '2.0.1';

        //generate the URL
        $bitly = "http://api.bit.ly/shorten?version=2.0.1&longUrl=$encodedUrl&login=$login&apiKey=$apikey&format=$format";

        //fetch url
        $response = wp_remote_get($bitly);

        //for json formating
        if(strtolower($format) == 'json')
        {
            $json = @json_decode($response['body'], true);
            return $json['results'][$url]['shortUrl'];
        }
        else //for xml formatting
        {
            $xml = simplexml_load_string($response['body']);
            return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
        }
    }

endif;


/**
 * Trim By Characters
 */
if( !function_exists('short_str') ) :

    function short_str( $str, $len, $cut = true ) {
        if ( strlen( $str ) <= $len ) return $str;
        return ( $cut ? substr( $str, 0, $len ) : substr( $str, 0, strrpos( substr( $str, 0, $len ), ' ' ) ) ) . '&hellip;';
    }

endif;

/**
 * Trim By Words
 */
if( !function_exists('word_trim') ) :

    function word_trim($string, $count, $ellipsis = false){
        $words = explode(' ', $string);
        if (count($words) > $count){
            array_splice($words, $count);
            $string = implode(' ', $words);
            if (is_string($ellipsis)){
                $string .= $ellipsis;
            }
            elseif ($ellipsis){
                $string .= '&hellip;';
            }
        }
        return $string;
    }

endif;




/*
-------------------------------------------------------------------------------
LOGIN CUSTOMIZATION
-------------------------------------------------------------------------------
*/

/**
 * Login Behavior
 */
add_action('login_headerurl', function(){
    return home_url('/');
});

/**
 * Branding The Login Screen
 */
add_action('login_head', function(){
    echo '<style type="text/css">
        h1 a { background: url('. M320_STYLESHEET_URI .'/images/admin-logo.png) no-repeat center top; !important }
        form{ background: none; border: none; box-shadow: none;}
        #wp-submit{background-color: #3489df; border-radius: 3px; background-image: none; border: none; text-shadow: none;}
        #backtoblog{display: none;}
        .login #nav a, .login #backtoblog a{color: #3489df !important;}
        .login #nav a:hover, .login #backtoblog a:hover{color: #282828 !important;}
        .message{margin: 26px 24px 10px 31px;}
        </style>';
});

/**
 * Admin Section Footer Text
 */
add_filter('admin_footer_text', function(){
    echo '<p>Desarrollado por <a href="http://matiasmancini.com.ar" target="_blank">Matias Mancini</a></p>';
});





/*
-------------------------------------------------------------------------------
STUFF FOR NON-ADMINS
-------------------------------------------------------------------------------
*/
if( current_user_can('administrator') ) return false;

/**
 * Disable Core Updates
 */
remove_action( 'load-update-core.php', 'wp_update_core' );
add_filter( 'pre_site_transient_update_core', function(){ return; } );

/**
 * Disable Plugin Updates
 */
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', function(){ return; } );

/**
 * Remove metaboxes from the dashboard
 */
add_action('wp_dashboard_setup', function(){
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
});

/**
 * Remove metaboxes from the edit page
 */
add_action('admin_init', function(){
    // Page
    remove_meta_box( 'pageparentdiv', 'page', 'side' );
    remove_meta_box( 'postcustom', 'page', 'normal' );
    remove_meta_box( 'authordiv', 'page', 'normal' );

    // Post
    remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
    remove_meta_box( 'postcustom', 'post', 'normal' );
    remove_meta_box( 'commentstatusdiv', 'post', 'normal' );
    remove_meta_box( 'commentsdiv', 'post', 'normal' );
    remove_meta_box( 'authordiv', 'post', 'normal' );
    remove_meta_box( 'revisionsdiv', 'post', 'normal' );
});
?>
