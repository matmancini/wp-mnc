# TODO

## .htaccess

### Secure Your WordPress Against User-Agents and Bots
[http://wp.tutsplus.com/tutorials/secure-your-wordpress-against-user-agents-and-bots/](http://wp.tutsplus.com/tutorials/secure-your-wordpress-against-user-agents-and-bots/)

## Bot Blocker
    <IfModule mod_setenvif.c>
      SetEnvIfNoCase User-Agent ^$ keep_out
      SetEnvIfNoCase User-Agent (pycurl|casper|cmsworldmap|diavol|dotbot) keep_out
      SetEnvIfNoCase User-Agent (flicky|ia_archiver|jakarta|kmccrew) keep_out
      SetEnvIfNoCase User-Agent (purebot|comodo|feedfinder|planetwork) keep_out
      	<Limit GET POST PUT>
	    	Order Allow,Deny
	    	Allow from all
	    	Deny from env=keep_out
  		</Limit>
    </IfModule>

## wpconfig.php
    <files wp-config.php>
    	order allow, deny
    	deny from all
    </files>

    define('WP_POST_REVISIONS', false );

    define('WP_DEBUG', false);
    define('EMPTY_TRASH_DAYS', 7 );

    Change the Autosave Interval (in seconds)
    define('AUTOSAVE_INTERVAL', 60 );

## Plugins
* [Breadcrumb NavXT](http://wordpress.org/extend/plugins/breadcrumb-navxt/)
* [Regenerate Thumbnails](http://wordpress.org/plugins/regenerate-thumbnails/)
* [Facebook Like Thumbnail](http://wordpress.org/extend/plugins/facebook-like-thumbnail/)
* [MNC New user registration](https://github.com/matmancini/mnc-user-registration)
* [User role editor](http://wordpress.org/extend/plugins/user-role-editor/)
* [WordPress SEO](http://wordpress.org/extend/plugins/wordpress-seo/)
* [WP Super Cache](http://wordpress.org/extend/plugins/wp-super-cache/)
* [BackUpWordPress](http://wordpress.org/extend/plugins/backupwordpress/)
* [Contact Form 7](http://wordpress.org/extend/plugins/contact-form-7/)
* [WP Security Scan](http://wordpress.org/extend/plugins/wp-security-scan/)
* [MNC FlexSlider](https://github.com/matmancini/mnc-flex-slider)
* [Disqus Comment System](https://wordpress.org/extend/plugins/disqus-comment-system/)
* [WP-FB-AutoConnect](http://wordpress.org/extend/plugins/wp-fb-autoconnect/)
* [WP-PageNavi](http://wordpress.org/extend/plugins/wp-pagenavi/)
* [Search Everything](http://wordpress.org/extend/plugins/search-everything/)
* [Broken Link Checker](http://wordpress.org/extend/plugins/broken-link-checker/)

## Finish
* Change Modernizr source (functions.php)
* Allow Search Engines
