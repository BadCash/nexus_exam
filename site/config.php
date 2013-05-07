<?php
/**
 * Site configuration, this file is changed by user per site.
 *
 */

/**
 * Set level of error reporting
 */
error_reporting(-1);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

/**
 * Indicate that the installation proces has been completed
 *
 * This is set to false in the original config.php file that ships with Nexus.
 * If this is set to true, it is not possible to run the installer again.
 * This is to prevent anyone from running the installer and thereby resetting the entire system.
 */
$nx->config['installer']['installed'] = 'true';


/**
 * Set requirements for installation of Nexus MVC 
 *
 * Minimum PHP version can be determined with minVersion for example: http://phpduck.com/minimum-php-version-script/
 * DB Driver is of the form 'driver_name' => 'display_name'
 */
$nx->config['installer']['minphpversion'] = '5.3';
$nx->config['installer']['supported_databases'] = array('sqlite3' => 'SQLite 3');


/**
 * Set what to show as debug or developer information in the get_debug() theme helper.
 */
$nx->config['debug']['nexus'] = false;
$nx->config['debug']['session'] = false;
$nx->config['debug']['timer'] = true;
$nx->config['debug']['db-num-queries'] = true;
$nx->config['debug']['db-queries'] = true;


/**
 * Set database(s).
 */
$nx->config['database'][0]['dsn'] = 'sqlite:' . NEXUS_SITE_PATH . '/data/.ht.sqlite';


/**
 * What type of urls should be used?
 * 
 * default      = 0      => index.php/controller/method/arg1/arg2/arg3
 * clean        = 1      => controller/method/arg1/arg2/arg3
 * querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
 */
$nx->config['url_type'] = 1;


/**
 * Set a base_url to use another than the default calculated
 */
$nx->config['base_url'] = null;


/**
 * How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
 */
$nx->config['hashing_algorithm'] = 'sha1salt';


/**
 * Allow or disallow creation of new user accounts.
 */
$nx->config['create_new_users'] = true;


/**
 * Define session name
 */
$nx->config['session_name'] = preg_replace('/[:\.\/-_]/', '', __DIR__);
$nx->config['session_key']  = 'nexus';


/**
 * Define default server timezone when displaying date and times to the user. All internals are still UTC.
 */
$nx->config['timezone'] = 'Europe/Stockholm';


/**
 * Define internal character encoding
 */
$nx->config['character_encoding'] = 'UTF-8';


/**
 * Define language
 */
$nx->config['language'] = 'en';


/**
 * Define the controllers, their classname and enable/disable them.
 *
 * The array-key is matched against the url, for example: 
 * the url 'developer/dump' would instantiate the controller with the key "developer", that is 
 * CCDeveloper and call the method "dump" in that class. This process is managed in:
 * $nx->FrontControllerRoute();
 * which is called in the frontcontroller phase from index.php.
 */
$nx->config['controllers'] = array(
  'index'     => array('enabled' => true,'class' => 'CCIndex'),
  'developer' => array('enabled' => true,'class' => 'CCDeveloper'),
  'guestbook' => array('enabled' => true,'class' => 'CCGuestbook'),
  'content'   => array('enabled' => true,'class' => 'CCContent'),
  'blog'      => array('enabled' => true,'class' => 'CCBlog'),
  'page'      => array('enabled' => true,'class' => 'CCPage'),
  'user'      => array('enabled' => true,'class' => 'CCUser'),
  'acp'       => array('enabled' => true,'class' => 'CCAdminControlPanel'),
  'me'        => array('enabled' => true,'class' => 'CCMe'),
  'source'    => array('enabled' => true,'class' => 'CCSource'),
  'theme' 	  => array('enabled' => true,'class' => 'CCTheme'),
  'my' 		  => array('enabled' => true,'class' => 'CCMycontroller'),
  'module'    => array('enabled' => true,'class' => 'CCModules'),
  'installer' => array('enabled' => true,'class' => 'CCInstaller')
);


/**
 * Define a routing table for urls.
 *
 * Route custom urls to a defined controller/method/arguments
 */
$nx->config['routing'] = array(
  'home' => array('enabled' => true, 'url' => 'index/index'),
);

/**
 * Define menus.
 *
 * Create hardcoded menus and map them to a theme region through $nx->config['theme'].
 */
$nx->config['menus'] = array(
	'sys-navbar' => array(
		'home' => array( 'label' => 'Nexus', 'url' => 'home' ),
		'modules' => array( 'label' => 'Moduler', 'url' => 'module' ),
		'content' => array( 'label' => 'Innehåll', 'url' => 'content' ),
	),
	'me-navbar' => array(
		'about' => array( 'label' => 'Om mig', 'url' => 'me' ),
		'report' => array( 'label' => 'Redovisning', 'url' => 'me/redovisning' ),
		'blog' => array( 'label' => 'Min blogg', 'url' => 'blog' ),
		'guestbook' => array( 'label' => 'Gästbok', 'url' => 'guestbook' ),
	),
);


/**
 * Settings for the theme. The theme may have a parent theme.
 *
 * When a parent theme is used the parent's functions.php will be included before the current
 * theme's functions.php. The parent stylesheet can be included in the current stylesheet
 * by an @import clause. See site/themes/mytheme for an example of a child/parent theme.
 * Template files can reside in the parent or current theme, the CLydia::ThemeEngineRender()
 * looks for the template-file in the current theme first, then it looks in the parent theme.
 *
 * There are two useful theme helpers defined in themes/functions.php.
 *  theme_url($url): Prepends the current theme url to $url to make an absolute url. 
 *  theme_parent_url($url): Prepends the parent theme url to $url to make an absolute url. 
 *
 * path: Path to current theme, relativly LYDIA_INSTALL_PATH, for example themes/grid or site/themes/mytheme.
 * parent: Path to parent theme, same structure as 'path'. Can be left out or set to null.
 * stylesheet: The stylesheet to include, always part of the current theme, use @import to include the parent stylesheet.
 * template_file: Set the default template file, defaults to default.tpl.php.
 * regions: Array with all regions that the theme supports.
 * menu_to_region: Array mapping menus to regions.
 * data: Array with data that is made available to the template file as variables. 
 * 
 * The name of the stylesheet is also appended to the data-array, as 'stylesheet' and made 
 * available to the template files.
 */
$nx->config['theme'] = array(
  'path'            => 'site/themes/my_grid',
  //'path'            => 'themes/grid',
  //'parent'          => 'themes/grid',

//  'name'            => 'grid',            // The name of the theme in the theme directory
  'stylesheet'      => 'style.php',       // Main stylesheet to include in template files
  'template_file'   => 'index.tpl.php',   // Default template file, else use default.tpl.php
  
  // A list of valid theme regions
  'regions' => array('navbar', 'flash','featured-first','featured-middle','featured-last',
    'primary','sidebar','triptych-first','triptych-middle','triptych-last',
    'footer-column-one','footer-column-two','footer-column-three','footer-column-four',
    'footer',
  ),
  
  // Map menu to region
  'menu_to_region' => array( 'sys-navbar' => 'sys-navbar', 'me-navbar' => 'me-navbar',  ),
  
  // Add static entries for use in the template file.
  'data' => array(
    'header' => 'Nexus',
    'slogan' => 'ingen slogan',
    'favicon' => '',
    'logo' => 'emblem-bin.png',
    'logo_width' => 48,
    'logo_height' => 48,
	'footer' => 'Nexus &copy; by Magnus Wikhög'
  ),  
);
 